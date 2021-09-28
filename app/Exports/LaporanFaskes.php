<?php

namespace App\Exports;

use App\Models\Dokter;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class LaporanFaskes implements FromView
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function view(): View
    {

        return view('exports.laporan_faskes', [
            'laporan_faskes' => Dokter::with('akun_faskes')->where('role', 3)->get()
        ]);
    }
}
