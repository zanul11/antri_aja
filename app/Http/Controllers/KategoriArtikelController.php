<?php

namespace App\Http\Controllers;

use App\Models\KategoriArtikel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class KategoriArtikelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kategori = KategoriArtikel::all();
        $data = [
            'category_name' => 'Kategori Artikel',
            'page_name' => 'Kategori Artikel',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
            'data_kategori' => $kategori
        ];
        return view('pages.kategori.index')->with($data);
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
        $cekSpesialis = KategoriArtikel::where('kategori', $request->kategori)->get();
        if (count($cekSpesialis) > 0) {
            return Redirect::to('/kategori')->withErrors(['Duplicate kategori name!.'])->withInput()->with('message', 'Duplicate kategori name!.');
        } else {
            KategoriArtikel::create([
                "kategori" => $request->kategori
            ]);
            return Redirect::to('/kategori')->with('success', 'Data Kategori added!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\KategoriArtikel  $kategoriArtikel
     * @return \Illuminate\Http\Response
     */
    public function show(KategoriArtikel $kategoriArtikel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\KategoriArtikel  $kategoriArtikel
     * @return \Illuminate\Http\Response
     */
    public function edit(KategoriArtikel $kategoriArtikel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\KategoriArtikel  $kategoriArtikel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  $kategoriArtikel)
    {
        $kategori = KategoriArtikel::find($kategoriArtikel);
        if ($request->kategori_edit != $kategori->kategori) {
            $cek = KategoriArtikel::where('kategori', $request->kategori_edit)->get();
            if (count($cek) > 0) {
                return Redirect::to('/kategori')->withErrors(['Duplicate Kategori name!.'])->withInput()->with('message', 'Duplicate Kategori name!.');
            } else {
                $kategori->kategori = $request->kategori_edit;
                $kategori->save();
                return Redirect::to('/kategori')->with('success', 'Data Kategori updated!');
            }
        } else {
            $kategori->kategori = $request->kategori_edit;
            $kategori->save();
            return Redirect::to('/kategori')->with('success', 'Data Kategori updated!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\KategoriArtikel  $kategoriArtikel
     * @return \Illuminate\Http\Response
     */
    public function destroy($kategoriArtikel)
    {
        KategoriArtikel::where('id', $kategoriArtikel)->delete();
    }
}
