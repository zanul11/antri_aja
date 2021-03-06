@extends('layouts.app')

@section('content')
<div class="layout-px-spacing">

    <div class="row layout-top-spacing">

        <div class="col-xl-12 col-lg-12 col-sm-12 user-profile layout-spacing">

            <div class="widget-content widget-content-area br-6 ">
                <div class="d-flex justify-content-between">
                    <h3 class=""> {{$page_name}} </h3>
                    <a href="{{url('akun/create')}}" class="mt-2 edit-profile"> <i data-feather="plus" class="text-defaulr"> </i></a>
                </div>
                <div class="table-responsive mb-4 mt-4">
                    <table id="zero-config" class="table table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Username</th>
                                <th>Nama</th>
                                <th>No Hp</th>
                                <th>Alamat</th>
                                <th class="no-content"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data_akun as $dt)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$dt->username}}</td>
                                <td>{{$dt->name}}</td>
                                <td>{{$dt->no_hp}}</td>
                                <td>{{$dt->alamat}}</td>
                                <td>
                                    <a href="akun/{{$dt->id}}/edit" title="Edit Data"><i data-feather="edit" class="text-warning"></i></a>
                                    <a href="#" onclick="deleteData('/akun','{{$dt->id}}')" title="Hapus Data"><i data-feather="trash" class="text-danger"></i></a>
                                    <a href="jadwal/{{$dt->id}}/edit" title="Jadwal Pelayanan"><i data-feather="calendar" class="text-primary"></i></a>
                                    <a href="akun/{{$dt->id}}" title="Data Antrian"><i data-feather="users" class="text-green"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>

                    </table>

                </div>

            </div>
        </div>

    </div>

</div>



@endsection