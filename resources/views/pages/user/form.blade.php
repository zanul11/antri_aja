@extends('layouts.app')

@section('content')
<div class="layout-px-spacing">

    <div class="row layout-top-spacing">

        <div class="col-xl-12 col-lg-12 col-sm-12 user-profile layout-spacing">

            <div class="widget-content widget-content-area br-6 ">
                <div class="d-flex justify-content-between">
                    <h3 class=""> {{$page_name}} {{$category_name}} </h3>
                    <a href="{{url('/user')}}" class="mt-2  text-danger layout-spacing"><i data-feather="x"></i></a>
                </div>
                <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                    <form id="contact" class="section contact layout-spacing" method="POST" action="{{($action==='Tambah')?'/user':'/user/'.$user->id}}">
                        @if($action=='Edit')
                        @method('PUT')
                        @endif
                        @csrf
                        <div class=" info">
                            @if ($errors->any())
                            <div class="alert alert-pink alert-dismissable fade show has-icon">
                                <i class="la la-info-circle alert-icon"></i>
                                <button class="close" data-dismiss="alert" aria-label="Close"></button>
                                @foreach ($errors->all() as $error)
                                {{ $error }}
                                @endforeach
                            </div>
                            @endif
                            <div class="row">
                                <div class="col-md-11 mx-auto">
                                    <div class="row">
                                        <!-- <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="country">Role</label>
                                                @if($action=='Tambah')
                                                <select class="form-control selectpicker" id="country">
                                                    <option selected>Administrator</option>
                                                </select>
                                                @else
                                                <input type="text" class="form-control mb-4" value="{{($user->role==1)?'Administrator':(($user->role==2)?'Marketing':(($user->role==3)?'Dokter':'Pasien'))}}" disabled>
                                                @endif
                                            </div>
                                        </div> -->
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="nama">Nama</label>
                                                <input type="text" class="form-control mb-4" name="nama" id="nama" placeholder="Nama user" value="{{(isset($user))?$user->name:(old('nama')??'')}}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="email">Email</label>
                                                <input type="email" class="form-control mb-4" name="email" id="email" placeholder="Email user" value="{{(isset($user))?$user->email:(old('email')??'')}}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="password">Password</label>
                                                <input type="text" class="form-control mb-4" name="password" id="password" placeholder="Write your password" value="{{(isset($user))?$user->password_show:(old('password')??'')}}" {{($action=='Tambah')?'required':''}}>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <center>
                                <button class="btn btn-primary mb-2 text-center"><i data-feather="{{($action=='Tambah')?'plus':'refresh-cw'}}"></i> {{($action=='Tambah')?'SIMPAN':'UPDATE'}}</button>

                            </center>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

</div>


@endsection