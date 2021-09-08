<?php

namespace App\Exports;

use App\Models\Marketing;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class LaporanMarketing implements FromView
{
    // public function drawings()
    // {
    //     $drawing = new Drawing();
    //     $drawing->setName('Logo');
    //     $drawing->setDescription('This is my logo');
    //     $drawing->setPath(public_path('/assets/img/logo2.png'));
    //     $drawing->setHeight(90);
    //     $drawing->setCoordinates('B3');
    //     return $drawing;
    // }

    public function view(): View
    {

        return view('exports.laporan_marketing', [
            'laporan_marketing' => Marketing::where('role', 2)->get()
        ]);
    }
}
