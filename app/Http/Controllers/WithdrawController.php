<?php

namespace App\Http\Controllers;

use App\Models\Withdraw;
use App\Http\Controllers\Controller;
use App\Models\Dokter;
use App\Models\TopUp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class WithdrawController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $profile = Auth::user();
        $dokter = Dokter::where('id', Auth::user()->id)->with(['saldo' => function ($q) {
            $q->where('status', 1);
            $q->orderby('created_at');
        }])->first();

        $withdraw = Withdraw::where('user', Auth::user()->id)->orderby('created_at')->get();
        // return json_decode($response->getBody(), true);
        $data = [
            'category_name' => 'Withdraw',
            'page_name' => 'Withdraw',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
            'profile' => $profile,
            'saldo_bonus' => $this->getSaldo(),
            'data_dokter' => $dokter,
            'data_withdraw' => $withdraw
        ];
        return view('pages.withdraw.index')->with($data);
    }

    public function getSaldo()
    {
        $kredit2 = TopUp::where('dokter', Auth::user()->id)->where('ket', 'Withdraw/Penarikan')->sum('jumlah');
        $saldo = TopUp::where('dokter', Auth::user()->id)->where('status', 1)->where('jenis', 1)->where('ket', 'Bonus')->sum('jumlah');
        return $saldo - $kredit2;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Dokter::where('id', Auth::user()->id)
            ->update([
                'nm_trf' => $request->nm_trf,
                'nm_bank' => $request->nm_bank,
                'no_rek' => $request->no_rek
            ]);

        if ($this->getSaldo() >= $request->jumlah) {
            Withdraw::create([
                'user' => Auth::user()->id,
                'jumlah' => $request->jumlah,
                'nm_trf' => $request->nm_trf,
                'nm_bank' => $request->nm_bank,
                'no_rek' => $request->no_rek,
            ]);
            return Redirect::to('/withdraw')->with('success', 'Berhasil request penarikan!');
        } else {
            return Redirect::to('/withdraw')->withInput()->with('message', 'Jumlah Saldo Bonus tidak cukup!.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Withdraw  $withdraw
     * @return \Illuminate\Http\Response
     */
    public function show(Withdraw $withdraw)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Withdraw  $withdraw
     * @return \Illuminate\Http\Response
     */
    public function edit(Withdraw $withdraw)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Withdraw  $withdraw
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Withdraw $withdraw)
    {
        return $request;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Withdraw  $withdraw
     * @return \Illuminate\Http\Response
     */
    public function destroy(Withdraw $withdraw)
    {
        $withdraw->delete();
    }
}
