@extends('layouts.app')

@section('content')
<div class="layout-px-spacing ">

    <div class="row layout-top-spacing ">

        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">

            <div class="widget-content widget-content-area br-6 ">
                <div class="d-flex justify-content-between">
                    <h3 class=""> {{$page_name}} </h3>
                </div>
                <div class="table-responsive mb-4 mt-4">
                    <table id="antrian" class="table table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>No Antri</th>
                                <th>Pasien</th>
                                <th>User</th>
                                <th>No Hp</th>
                                <th>Catatan</th>
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
                                <td>{{$dt->user_name}}</td>
                                <td>{{$dt->no_hp}}</td>
                                <td>{{$dt->catatan}}</td>
                                <td>{{$dt->waktu_detail->dJam}}-{{$dt->waktu_detail->sJam}}</td>
                                <td>@if($dt->status==0)
                                    <span class="badge badge-warning"> Menunggu </span>
                                    @elseif($dt->status==1)
                                    <span class="badge badge-success"> Selesai </span>
                                    @endif</td>
                                <td>
                                    <a href="antri_dokter/{{$dt->id}}/edit"><i data-feather="eye" class="text-warning"></i></a>
                                    <!-- <a href="#" onclick="deleteData('/antri','{{$dt->id}}')"><i data-feather="trash" class="text-danger"></i></a> -->
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