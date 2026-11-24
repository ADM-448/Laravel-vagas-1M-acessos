<?php

namespace App\Jobs;

use App\Models\Vaga;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class SincronizarVisualizacoesVagasJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Consolida as visualizações acumuladas no Redis em lote no MySQL
     */
    public function handle(): void
    {
        try {
            // Busca todas as chaves de visualização de vagas no Redis
            $keys = Redis::keys('vaga:views:*');

            if (empty($keys)) {
                return;
            }

            foreach ($keys as $key) {
                // Remove prefixos do redis se houver
                $vagaId = (int) str_replace('vaga:views:', '', $key);
                $viewsAcumuladas = (int) Redis::getset($key, 0);

                if ($viewsAcumuladas > 0 && $vagaId > 0) {
                    Vaga::where('id', $vagaId)->increment('visualizacoes_count', $viewsAcumuladas);
                }
            }
        } catch (\Throwable $e) {
            // Log de monitoramento
        }
    }
}
