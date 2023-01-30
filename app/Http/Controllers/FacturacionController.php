<?php

namespace App\Http\Controllers;

use App\Dto\InvoiceDTO;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Src\Provider\Billing;

class FacturacionController extends Controller
{
    public function __construct()
    {
        $this->proxy = new Billing();
    }

    public function index()
    {
        $params = [
            "start_date" =>Carbon::now()->subDays(30)->format('Y-m-d'),
            "end_date" =>Carbon::now()->format('Y-m-d')
        ];
        $query = $this->proxy->getTotalesFacturacion($params);
        $response = $query->first();
        $result = new InvoiceDTO($response->numerofacturas,$response->fechadesde,$response->fechahasta,$response->importetotal);
        return view('facturacion',["data" => $result]);
    }
}
