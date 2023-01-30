<?php

namespace App\Jobs;

use App\Dto\InvoiceDTO;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Psr\EventDispatcher\StoppableEventInterface;
use Src\Provider\Billing;

class FacturacionJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->proxy = new Billing();
        $params = [
            "start_date" =>Carbon::now()->subDays(30)->format('Y-m-d'),
            "end_date" =>Carbon::now()->format('Y-m-d')
        ];
        $query = $this->proxy->getTotalesFacturacion($params);
        $response = $query->first();
        $result = new InvoiceDTO($response->numerofacturas,$response->fechadesde,$response->fechahasta,$response->importetotal);
        Storage::disk('public')->put('cron/facturacion/facturas-impagadas.json',json_encode($result));
    }
}
