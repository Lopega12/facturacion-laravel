<?php
namespace Src\Provider;
use App\Models\Factura;

class Billing
{
    public function getTotalesFacturacion($params)
    {
       $query = Factura::query()
           ->where('pagada',false)
           ->whereBetween('fecha_factura',[$params['start_date'],$params['end_date']])
           ->selectRaw('count(*) as numeroFacturas, sum(total_factura) as importeTotal, min(fecha_factura) as fechaDesde,max(fecha_factura) fechaHasta');
       return $query;
    }
}
