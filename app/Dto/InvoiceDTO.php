<?php
namespace App\Dto;
class InvoiceDTO
{
//    private int $numeroFacturas;
//    private string $fechaDesde, $fechaHasta, $importeTotal;

    public function __construct(public int $numeroFacturas,public string $fechaDesde, public string $fechaHasta, public string $importeTotal)
    {

    }
}
