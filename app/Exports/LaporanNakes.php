<?php

namespace App\Exports;

use App\Models\Dokter;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class LaporanNakes implements FromView
{
    /**
     * @return \Illuminate\Support\Collection
     */

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function view(): View
    {
        $faskes = Dokter::where('id', $this->id)->first();
        $data = Dokter::where('email', $faskes['email'])->where('role', 5)->get();
        return view('exports.laporan_nakes', [
            'laporan_nakes' => $data,
            'faskes' => $faskes
        ]);
    }
}
