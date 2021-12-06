@extends('layouts.app')

@section('content')
<div class="layout-px-spacing">

    <div class="row layout-top-spacing">

        <div class="col-xl-12 col-lg-12 col-sm-12 user-profile layout-spacing">

            <div class="widget-content widget-content-area br-6 ">
                <div class="d-flex justify-content-between">
                    <h3 class=""> {{$page_name}} </h3>
                    <a href="/dashboard" class="mt-2 edit-profile"> <i data-feather="home" class="text-defaulr"> </i></a>
                </div>
                <div class="table-responsive mb-4 mt-4">
                    <table id="zero-config" class="table table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>User</th>
                                <th>Jumlah Request Penarikan</th>
                                <th>Tujuan Transfer</th>
                                <th>Status</th>
                                <th class="no-content"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data_request as $dt)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$dt->user_detail->name}}</td>
                                <td>{{number_format($dt->jumlah)}}</td>
                                <td>{{$dt->nm_trf}} ({{$dt->nm_bank}}) - {{$dt->no_rek}}</td>
                                <td>@if($dt->status==1)
                                    <span class="badge badge-success"> Selesai </span>
                                    @elseif($dt->status==2)
                                    <span class="badge badge-danger"> Ditolak </span>
                                    @else
                                    <span class="badge badge-warning"> Menunggu Verifikasi </span>
                                    @endif
                                </td>
                                <td>
                                    @if($dt->status==0)
                                    <a href="withdraw-admin/{{$dt->id}}/edit"><i data-feather="check-square" class="text-primary"></i></a>
                                    @endif
                                    <!-- <a href="#" onclick="deleteData('/faskes','{{$dt->id}}')"><i data-feather="trash" class="text-danger"></i></a> -->
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