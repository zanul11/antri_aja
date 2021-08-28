<?php

namespace App\Http\Controllers;

use App\Models\Spesialis;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class SpesialisController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $spesialis = Spesialis::all();
        $data = [
            'category_name' => 'Data Spesialisasi',
            'page_name' => 'Spesialisasi',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
            'data_spesialis' => $spesialis
        ];
        return view('pages.spesialis.index')->with($data);
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
        $cekSpesialis = Spesialis::where('spesialis', $request->spesialis)->get();
        if (count($cekSpesialis) > 0) {
            return Redirect::to('/spesialis')->withErrors(['Duplicate spesialis name!.'])->withInput()->with('message', 'Duplicate spesialisasi name!.');
        } else {
            Spesialis::create([
                "spesialis" => $request->spesialis,
                "user" => Auth::user()->name
            ]);
            return Redirect::to('/spesialis')->with('success', 'Data Spesialisasi added!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Spesialis  $spesialis
     * @return \Illuminate\Http\Response
     */
    public function show(Spesialis $spesiali)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Spesialis  $spesialis
     * @return \Illuminate\Http\Response
     */
    public function edit(Spesialis $spesiali)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Spesialis  $spesialis
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Spesialis $spesiali)
    {
        if ($request->spesialis_edit != $spesiali->spesialis) {
            $cek = Spesialis::where('spesialis', $request->spesialis_edit)->get();
            if (count($cek) > 0) {
                return Redirect::to('/spesialis')->withErrors(['Duplicate Spesialisasi name!.'])->withInput()->with('message', 'Duplicate Spesialisasi name!.');
            } else {

                $spesiali->spesialis = $request->spesialis_edit;
                $spesiali->user = Auth::user()->name;
                $spesiali->save();
                return Redirect::to('/spesialis')->with('success', 'Data Spesialisasi updated!');
            }
        } else {

            $spesiali->spesialis = $request->spesialis_edit;
            $spesiali->user = Auth::user()->name;
            $spesiali->save();
            return Redirect::to('/spesialis')->with('success', 'Data Spesialisasi updated!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Spesialis  $spesialis
     * @return \Illuminate\Http\Response
     */
    public function destroy(Spesialis $spesiali)
    {
        $spesiali->delete();
        // return $spesialis;
        // $spesialis->where('ids', $spesialis->id)->delete();
    }
}
