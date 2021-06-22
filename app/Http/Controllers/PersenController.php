<?php

namespace App\Http\Controllers;

use App\Models\Persen;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class PersenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $persen = Persen::first();
        $data = [
            'category_name' => 'Persentase Bonus',
            'page_name' => 'Persentase Bonus',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
            'data_persen' => $persen
        ];
        return view('pages.persen.index')->with($data);
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
        Persen::where('id', 1)->update(["dokter" => $request->dokter, "admin" => 100 - $request->dokter]);
        return Redirect::to('/persen')->with('success', 'Data Persen updated!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Persen  $persen
     * @return \Illuminate\Http\Response
     */
    public function show(Persen $persen)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Persen  $persen
     * @return \Illuminate\Http\Response
     */
    public function edit(Persen $persen)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Persen  $persen
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Persen $persen)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Persen  $persen
     * @return \Illuminate\Http\Response
     */
    public function destroy(Persen $persen)
    {
        //
    }
}
