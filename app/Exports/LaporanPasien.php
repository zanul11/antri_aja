<?php

namespace App\Exports;

use App\Models\Antri;
use App\Models\Dokter;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;

class LaporanPasien implements FromView
{
    use Exportable;

    public function __construct($nakes, $dtgl, $stgl)
    {
        $this->nakes = $nakes;
        $this->dtgl = $dtgl;
        $this->stgl = $stgl;
    }

    public function view(): View
    {
        $user = Dokter::where('id', $this->nakes)->first();
        if ($this->nakes == 0) {
            return view('exports.laporan_pasien', [
                'laporan_pasien' => Antri::where('tgl', date('Y-m-d'))->with('waktu_detail')->orderBy('status')->with('dokter_detail.faskes')->orderBy('tgl')->orderBy('no_antrian')->get(),
                'nakes' => 'Semua',
                'periode' => $this->dtgl . ' - ' . $this->stgl
            ]);
        } else {
            return view('exports.laporan_pasien', [
                'laporan_pasien' => Antri::with('waktu_detail')->orderBy('status')->with('dokter_detail.faskes')->where('dokter', $this->nakes)->whereBetween('tgl', [$this->dtgl, $this->stgl])->orderBy('tgl')->orderBy('no_antrian')->get(),
                'nakes' => $user['name'],
                'periode' => $this->dtgl . ' - ' . $this->stgl
            ]);
        }
    }
}
