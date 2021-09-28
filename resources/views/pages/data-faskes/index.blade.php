@extends('layouts.app')

@section('content')
<div class="layout-px-spacing">

    <div class="row layout-top-spacing">

        <div class="col-xl-12 col-lg-12 col-sm-12 user-profile layout-spacing">

            <div class="widget-content widget-content-area br-6 ">
                <div class="d-flex justify-content-between">
                    <h3 class=""> {{$page_name}} </h3>
                    <a href="{{url('data-faskes/create')}}" class="mt-2 edit-profile"> <i data-feather="plus" class="text-defaulr"> </i></a>
                </div>
                <div class="table-responsive mb-4 mt-4">
                    <a href="/export-faskes" class="btn btn-success">Export Excel</a><br><br>
                    <table id="zero-config" class="table table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Email</th>
                                <th>Nama Faskes</th>
                                <th>No Hp</th>
                                <!-- <th>Alamat</th> -->
                                <th>Nakes</th>
                                <th class="no-content"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data_dokter as $dt)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$dt->email}}</td>
                                <td>{{$dt->nama_faskes}}</td>
                                <td>{{$dt->no_hp}} / {{$dt->tlp_faskes}}</td>
                                <!-- <td>{{$dt->alamat}}</td> -->
                                <td>{{count($dt->akun_faskes)-1}}</td>
                                <td>
                                    <a href="data-faskes/{{$dt->id}}/edit" title="Edit Data"><i data-feather="edit" class="text-warning"></i></a>
                                    <a href="data-faskes/{{$dt->id}}" title="Data Nakes"><i data-feather="users" class="text-primary"></i></a>
                                    <a href="#" onclick="deleteData('/data-faskes','{{$dt->id}}')" title="Hapus Data"><i data-feather="trash" class="text-danger"></i></a>
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