<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Database\Eloquent\Collection;

use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Illuminate\Contracts\View\View;

class PMSRomanasExport2 implements FromView, ShouldAutoSize, WithEvents
{
    use Exportable;
    
    public function __construct(Collection $datos) {
        $this->datos = $datos;
    }

    public function view(): View
    {
        return view('excel.pmsromanasexcel2', [
            'datos' => $this->datos
        ]);
    }

    public function collection()
    {
        return  $this->datos;
    }
    
    public function registerEvents(): array
    {
        return [
            /* AfterSheet::class    => function(AfterSheet $event) {
                $cellRange = 'A1:W1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14);
            }, */
        ];
    }
}
