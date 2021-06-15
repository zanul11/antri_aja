@extends('layouts.app_user')

@section('content')
<div class="layout-px-spacing">

    <div class="row layout-top-spacing">

        <div class="col-xl-12 col-lg-12 col-sm-12 user-profile layout-spacing">

            <div class="widget-content widget-content-area br-6 ">
                <div class="d-flex justify-content-between">
                    <h3 class=""> {{$page_name}} </h3>
                    <a href="{{url('antri/create')}}" class="mt-2 "> <button class="btn btn-primary mb-2">DAFTAR ANTRIAN</button></a>
                </div>
                <div class="table-responsive mb-4 mt-4">
                    <table id="antrian" class="table table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>No Antri</th>
                                <th>Pasien</th>
                                <th>Dokter</th>
                                <th>Alamat</th>
                                <th>Waktu</th>
                                <th>Status</th>
                                <th class="no-content"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data_antri as $dt)
                            <tr>
                                <td>{{$dt->tgl}}</td>
                                <td>{{$dt->no_antrian}}</td>
                                <td>{{$dt->pasien}}</td>
                                <td>{{$dt->dokter_detail->name}}</td>
                                <td>{{$dt->dokter_detail->alamat}}</td>
                                <td>{{$dt->waktu_detail->dJam}}-{{$dt->waktu_detail->sJam}}</td>
                                <td>@if($dt->status==0)
                                    <span class="badge badge-warning"> Menunggu </span>
                                    @elseif($dt->status==1)
                                    <span class="badge badge-success"> Selesai </span>

                                    @endif</td>
                                <td>
                                    <a href="antri/{{$dt->id}}/edit"><i data-feather="eye" class="text-warning"></i></a>
                                    <a href="#" onclick="deleteData('/antri','{{$dt->id}}')"><i data-feather="trash" class="text-danger"></i></a>
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