@extends('layouts.app')

@section('content')
<div class="layout-px-spacing">

    <div class="row layout-top-spacing">

        <div class="col-xl-12 col-lg-12 col-sm-12 user-profile layout-spacing">

            <div class="widget-content widget-content-area br-6 ">
                <div class="d-flex justify-content-between">
                    <h3 class=""> {{$page_name}} </h3>
                    <a href="{{url('dokter/create')}}" class="mt-2 edit-profile"> <i data-feather="plus" class="text-defaulr"> </i></a>
                </div>
                <div class="table-responsive mb-4 mt-4">
                    <!-- <table id="zero-config" class="table table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>NIK</th>
                                <th>Nama</th>
                                <th>No Hp/email</th>
                                <th>Alamat</th>
                                <th class="no-content"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data_dokter as $dt)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$dt->nik}}</td>
                                <td>{{$dt->name}}</td>
                                <td>{{$dt->no_hp}}/{{$dt->email}}</td>
                                <td>{{$dt->alamat}}</td>
                                <td>
                                    <a href="dokter/{{$dt->id}}/edit"><i data-feather="edit-2" class="text-warning"></i></a>
                                    <a href="#" onclick="deleteData('/dokter','{{$dt->id}}')"><i data-feather="trash" class="text-danger"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>

                    </table> -->
                    <div class="flex-tree-container">
                        <ul>
                            <li>
                                <p><img src="{{asset('assets/img/90x90.jpg')}}" alt="avatar"> <br>
                                    {{$jaringan->name}} <br>
                                    <!-- <button onclick="getData('{{$jaringan->id}}')" data-toggle="modal" data-target="#exampleModal" class="btn btn-primary btn-sm">Detail</button>
                                    <button class="btn btn-warning btn-sm">Lihat</button> -->
                                </p>

                                @if(count($jaringan->children)>0)
                                <ul>
                                    @foreach($jaringan->children as $child)
                                    <li>
                                        <p> <img src="{{asset('assets/img/90x90.jpg')}}" alt="avatar"> <br>{{$child->name}} <br>
                                            <a href="dokter/{{$child->id}}/edit"><i data-feather="edit-2" class="text-warning"></i></a>
                                            <a href="#" onclick="deleteData('/dokter','{{$child->id}}')"><i data-feather="trash" class="text-danger"></i></a>
                                        </p>
                                        <!-- @if(count($child->childrenRekursif)>0)
                                        <ul>
                                            @foreach($child->childrenRekursif as $childRekursif)
                                            <li>
                                                <p> <img src="{{asset('assets/img/90x90.jpg')}}" alt="avatar"> <br>{{$childRekursif->name}} <br>
                                                    <button onclick="getData('{{$childRekursif->id}}')" data-toggle="modal" data-target="#exampleModal" class="btn btn-primary btn-sm">Detail</button>
                                                    <a href="/admin/jaringans/sub/{{$childRekursif->id}}" class="btn btn-warning btn-sm">Lihat</a></p>
                                            </li>
                                            @endforeach
                                        </ul>
                                        @endif -->
                                    </li>
                                    @endforeach
                                </ul>
                                @endif

                            </li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>

    </div>

</div>



@endsection