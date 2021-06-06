@extends('layouts.app')

@section('content')
<div class="layout-px-spacing">

    <div class="row layout-top-spacing">

        <div class="col-xl-12 col-lg-12 col-sm-12 user-profile layout-spacing">

            <div class="widget-content widget-content-area br-6 ">
                <div class="d-flex justify-content-between">
                    <h3 class=""> {{$page_name}} {{$category_name}} </h3>
                    <a href="{{url('user/create')}}" class="mt-2  text-danger layout-spacing"><i data-feather="x"></i></a>
                </div>
                <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                    <form id="contact" class="section contact layout-spacing" method="POST" action="{{($action==='Tambah')?'/user':''}}">
                        @csrf
                        <div class=" info">
                            <div class="row">
                                <div class="col-md-11 mx-auto">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="country">Role</label>
                                                <select class="form-control selectpicker" id="country" disabled>
                                                    <option selected>Administrator</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="nama">Nama</label>
                                                <input type="text" class="form-control mb-4" name="nama" id="nama" placeholder="Nama user" value="{{(isset($user))?$user->name:(old('nama')??'')}}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="email">Email</label>
                                                <input type="email" class="form-control mb-4" name="email" id="email" placeholder="Email user" value="{{(isset($user))?$user->email:(old('email')??'')}}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="password">Password</label>
                                                <input type="password" class="form-control mb-4" name="password" id="password" placeholder="Write your password" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <center>
                                <button class="btn btn-primary mb-2 text-center"><i data-feather="plus"></i>SIMPAN</button>

                            </center>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>


    <script>
        swal({
            title: 'Good job!',
            text: "You clicked the!",
            type: 'success',
            padding: '2em'
        })
    </script>
</div>


@endsection