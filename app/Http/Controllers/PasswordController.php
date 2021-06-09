<?php

namespace App\Http\Controllers;

use App\Models\Password;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;

class PasswordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $profile = Auth::user();
        $data = [
            'category_name' => 'Password',
            'page_name' => 'Password',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
            'profile' => $profile,
        ];
        return view('pages.user.password')->with($data);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Password  $password
     * @return \Illuminate\Http\Response
     */
    public function show(Password $password)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Password  $password
     * @return \Illuminate\Http\Response
     */
    public function edit(Password $password)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Password  $password
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Password $password)
    {

        $user = Password::where('email', $password->email)->first();
        if (!Hash::check($request->old_password, $user->password)) {
            return Redirect::to('/password')->withErrors(['Password Lama Anda Salah'])->with('message', 'Password Lama Anda Salah!');
        } else {
            if ($request->new_password != $request->konfirmasi_password) {
                return Redirect::to('/password')->withErrors(['Password Lama Anda Salah'])->with('message', 'Password Baru Tidak Sama');
            } else {
                $password->password = bcrypt($request->new_password);
                $password->save();
                return Redirect::to('/password')->with('success', 'Password updated!');
            }

            // return $request;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Password  $password
     * @return \Illuminate\Http\Response
     */
    public function destroy(Password $password)
    {
        //
    }
}
