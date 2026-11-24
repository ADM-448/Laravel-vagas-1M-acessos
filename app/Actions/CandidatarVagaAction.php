<?php

namespace App\Actions;

use App\Models\Candidato;
use App\Models\Candidatura;
use App\Models\RespostaTriagem;
use App\Models\Vaga;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class CandidatarVagaAction
{
    /**
     * Registra a candidatura com lock atômico no Redis e avaliação de triagem
     */
    public function execute(Vaga $vaga, Candidato $candidato, array $respostasTriagem = []): Candidatura
    {
        // 1. Lock atômico no Redis (evita race conditions e candidaturas duplicadas em alta concorrência)
        $lockKey = "candidatura:lock:{$vaga->id}:{$candidato->id}";
        $lock = Cache::lock($lockKey, 10);

        return $lock->block(5, function () use ($vaga, $candidato, $respostasTriagem) {
            // Verifica duplicidade no banco
            $existente = Candidatura::where('vaga_id', $vaga->id)
                ->where('candidato_id', $candidato->id)
                ->first();

            if ($existente) {
                throw new InvalidArgumentException('Você já está inscrito nesta vaga.');
            }

            return DB::transaction(function () use ($vaga, $candidato, $respostasTriagem) {
                $reprovouEliminatoria = false;

                // Cria o registro da candidatura
                $candidatura = Candidatura::create([
                    'vaga_id' => $vaga->id,
                    'candidato_id' => $candidato->id,
                    'etapa_pipeline' => 'inscrito',
                    'score_compatibilidade' => 100,
                ]);

                // Avalia as respostas de triagem
                foreach ($vaga->perguntas as $pergunta) {
                    $respostaValor = $respostasTriagem[$pergunta->id] ?? null;

                    $eliminado = false;
                    if ($pergunta->resposta_eliminatoria && $respostaValor) {
                        if (strtolower(trim($respostaValor)) === strtolower(trim($pergunta->resposta_eliminatoria))) {
                            $eliminado = true;
                            $reprovouEliminatoria = true;
                        }
                    }

                    RespostaTriagem::create([
                        'candidatura_id' => $candidatura->id,
                        'pergunta_vaga_id' => $pergunta->id,
                        'resposta' => (string) $respostaValor,
                        'reprovou_eliminatoria' => $eliminado,
                    ]);
                }

                if ($reprovouEliminatoria) {
                    $candidatura->update([
                        'etapa_pipeline' => 'reprovado',
                        'motivo_reprovacao' => 'Não atendeu aos critérios eliminatórios da triagem inicial.',
                    ]);
                }

                // Incrementa contador de candidaturas da vaga
                $vaga->incrementQuietly('candidaturas_count');

                return $candidatura;
            });
        });
    }
}
