<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::where('role', 1)->get();
        // $user = User::where('role', 1)->get();
        $data = [
            'category_name' => 'User',
            'page_name' => 'User',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
            'data_user' => $user
        ];
        // return config('sidemenu.administrator');
        return view('pages.user.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'category_name' => 'User',
            'page_name' => 'Tambah Data',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
            'action' => 'Tambah'
        ];
        // return config('sidemenu.administrator');
        return view('pages.user.form')->with($data);
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

        $cekUser = User::where('email', $request->email)->get();
        if (count($cekUser) > 0) {
            return Redirect::to('/user/create')->withErrors(['Duplicate user email!.'])->withInput()->with('message', 'Duplicate user email!.');
        } else {
            User::create([
                "name" => $request->nama,
                "email" => $request->email,
                "username" => $request->email,
                "password" => bcrypt($request->password),
                "password_show" => $request->password,
            ]);
            return Redirect::to('/user')->with('success', 'Data User added!');
        }
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
    public function edit(User $user)
    {
        // return $user;
        $data = [
            'category_name' => 'User',
            'page_name' => 'Tambah Data',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
            'action' => 'Edit',
            'user' => $user
        ];
        // return config('sidemenu.administrator');
        return view('pages.user.form')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        // return $user;
        if ($request->email != $user->email) {
            $cekUser = User::where('email', $request->email)->get();
            if (count($cekUser) > 0) {
                return Redirect::to('/user/' . $user->id . '/edit')->withErrors(['Duplicate user email!.'])->withInput()->with('message', 'Duplicate user email!.');
            } else {
                if (isset($request->password) || $request->password != '') {
                    $user->password = bcrypt($request->password);
                    $user->password_show = $request->password;
                }

                $user->email = $request->email;
                $user->username = $request->email;
                $user->name = $request->nama;
                $user->save();
                return Redirect::to('/user')->with('success', 'Data User updated!');
            }
        } else {
            if (isset($request->password) || $request->password != '') {
                $user->password = bcrypt($request->password);
                $user->password_show = $request->password;
            }
            $user->email = $request->email;
            $user->username = $request->email;
            $user->name = $request->nama;
            $user->save();
            return Redirect::to('/user')->with('success', 'Data User updated!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
    }

    public function delete(User $user)
    {
        $user->delete();
    }
}
