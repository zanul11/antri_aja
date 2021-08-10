@extends('layouts.app')

@section('content')

<div class="layout-px-spacing">

    <div class="account-settings-container layout-top-spacing">

        <div class="account-content">
            <div class="scrollspy-example" data-spy="scroll" data-target="#account-settings-scroll" data-offset="-100">
                <div class="row">
                    <div class="col-lg-6 layout-top-spacing">
                        <div class="bio layout-spacing">
                            <div class="widget-content widget-content-area">
                                <h3 class="">Jumlah Pasien Hari {{Session::get('hari')}}, {{Session::get('tgl')}}</h3>
                                <div class="user-info-list layout-spacing">
                                    <div class="text-center">
                                        <h1>
                                            {{$semua}}
                                        </h1>
                                    </div>
                                </div>
                            </div><br>
                        </div>
                    </div>
                    <div class="col-lg-3 layout-top-spacing">
                        <div class="bio layout-spacing">
                            <div class="widget-content widget-content-area">
                                <h3 class="">Terdaftar</h3>
                                <div class="user-info-list layout-spacing">
                                    <div class="text-center">
                                        <h2>
                                            {{$terdaftar}}
                                        </h2>
                                    </div>
                                </div>
                            </div><br>
                        </div>
                    </div>
                    <div class="col-lg-3 layout-top-spacing">
                        <div class="bio layout-spacing">
                            <div class="widget-content widget-content-area">
                                <h3 class="">Ditangani</h3>
                                <div class="user-info-list layout-spacing">
                                    <div class="text-center">
                                        <h2>
                                            {{$ditangani}}
                                        </h2>
                                    </div>
                                </div>
                            </div><br>
                        </div>
                    </div>
                    <!-- end -->
                    <div class="col-lg-12 ">
                        <div class="bio ">
                            <div class="widget-content widget-content-area">
                                <form id="contact" method="POST" action="/pasien">
                                    @csrf
                                    <div class="row">
                                        <div class="form-group col-lg-3" style="margin-right: 20px;">
                                            <label class="font-normal">Filter Tanggal</label>
                                            <div class="input-group date">
                                                <input class="form-control" type="date" name="dtgl" value="{{Session::get('selectedTgl')}}">
                                            </div>
                                        </div>
                                        <div class="form-group col-lg-3" style="margin-right: 20px;">
                                            <label class="font-normal">#</label>
                                            <div class="input-group date">
                                                <button type="submit" class="btn btn-primary">Filter</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                                <div class="table-responsive mb-4 mt-4">
                                    <table id="zero-config" class="table table-hover" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Pasien</th>
                                                <th>Dokter</th>
                                                <th>Waktu</th>
                                                <th>Status </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($data_antrian as $dt)
                                            <tr>
                                                <td>{{$loop->iteration}}</td>
                                                <td>{{$dt->pasien}}</td>
                                                <td>{{$dt->dokter_detail->name}}</td>
                                                <td>{{$dt->waktu_detail->dJam}}-{{$dt->waktu_detail->sJam}}</td>
                                                <td>@if($dt->status==1)
                                                    <span class="badge badge-success"> Ditangani </span>
                                                    @elseif($dt->status==0)
                                                    <span class="badge badge-warning"> Terdaftar </span>
                                                    @endif
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
            </div>
        </div>
    </div>

</div>
</form>
</div>




@endsection