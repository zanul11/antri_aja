<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\TopUp;
use App\Models\Withdraw;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class WithdrawAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $request = Withdraw::with('user_detail')->orderby('created_at')->orderby('status')->get();
        // return $request;
        $data = [
            'category_name' =>  'Request Withdraw',
            'page_name' =>  'Request Withdraw',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
            'action' => 'Tambah',
            'data_request' => $request,
        ];
        return view('pages.withdraw-admin.index')->with($data);
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
        // return $request;
        $foto = null;
        if ($request->hasFile('file')) {
            $image = $request->file('file');
            $path = public_path() . '/uploads/';
            $foto = 'bukti_' . time() . '.' . $image->getClientOriginalExtension();
            $image->move($path, $foto);
        }
        Withdraw::where('id', $request->id_request)
            ->update([
                'status' => $request->status,
                'ket' => $request->ket,
                'bukti' => $foto,
                'user_verif' => Auth::user()->name
            ]);
        TopUp::create([
            "trx_id" => '-',
            "dokter" => $request->id_user,
            "jumlah" => $request->jumlah,
            "jumlah_admin" => $request->jumlah,
            "status" => 1,
            "jenis" => 0,
            "ket" => 'Withdraw/Penarikan',
        ]);
        return Redirect::to('/withdraw-admin')->with('success', 'Berhasil verifikasi penarikan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $request = Withdraw::where('id', $id)->first();
        $data = [
            'category_name' =>  'Request Withdraw',
            'page_name' =>  'Verifikasi Request Withdraw',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
            'action' => 'Tambah',
            'data_request' => $request,
        ];
        return view('pages.withdraw-admin.form')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
