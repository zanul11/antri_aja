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
                                <h3 class="">Pemasukan</h3>
                                <div class="text-center user-info">
                                    <img src="{{asset('assets/img/favicon.ico')}}" alt="avatar" height="50px">
                                    <p class=""></p>
                                </div>
                                <div class="user-info-list layout-spacing">
                                    <div class="text-center">
                                        <h1>
                                            Rp. {{number_format($pemasukan)}}
                                        </h1>
                                    </div>
                                </div>
                            </div><br>
                        </div>
                    </div>
                    <div class="col-lg-3 layout-top-spacing">
                        <div class="bio layout-spacing">
                            <div class="widget-content widget-content-area">
                                <h3 class="">Saldo Dokter</h3>
                                <div class="text-center user-info">
                                    <img src="{{asset('assets/img/favicon.ico')}}" alt="avatar" height="50px">
                                    <p class=""></p>
                                </div>
                                <div class="user-info-list layout-spacing">
                                    <div class="text-center">
                                        <h2>
                                            Rp. {{number_format($saldo-$pemasukan)}}
                                        </h2>
                                    </div>
                                </div>
                            </div><br>
                        </div>
                    </div>
                    <div class="col-lg-3 layout-top-spacing">
                        <div class="bio layout-spacing">
                            <div class="widget-content widget-content-area">
                                <h3 class="">Saldo Dokter Real</h3>
                                <div class="text-center user-info">
                                    <img src="https://my.ipaymu.com/asset/images/logo-ipaymu.png" alt="avatar" height="50px">
                                    <p class=""></p>
                                </div>
                                <div class="user-info-list layout-spacing">
                                    <div class="text-center">
                                        <h2>
                                            Rp. {{number_format(($saldo-$pemasukan)-$fee)}}
                                        </h2>
                                    </div>
                                </div>
                            </div><br>
                        </div>
                    </div>
                    <!-- end -->
                    <div class="col-lg-12 layout-top-spacing">
                        <div class="bio layout-spacing">
                            <div class="widget-content widget-content-area">
                                <div class="table-responsive mb-4 mt-4">
                                    <table id="zero-config" class="table table-hover" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <!-- <th>NIK</th> -->
                                                <th>Nama</th>
                                                <th>No Hp/email</th>
                                                <th>Saldo</th>
                                                <th>Saldo Real</th>
                                                <th>Pasien </th>
                                                <th class="no-content"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($data_dokter as $dt)
                                            @php
                                            $saldo_dokter = 0;
                                            $pasien_dokter = 0;
                                            $fee = 0;
                                            @endphp

                                            @foreach($dt->antri as $d)
                                            @php
                                            $pasien_dokter++;
                                            @endphp
                                            @endforeach

                                            @foreach($dt->saldo as $d)
                                            @php
                                            $saldo_dokter+=$d->jumlah;
                                            $fee+=$d->fee;
                                            @endphp
                                            @endforeach
                                            <tr>
                                                <td>{{$loop->iteration}}</td>
                                                <!-- <td>{{$dt->nik}}</td> -->
                                                <td>{{$dt->name}}</td>
                                                <td>{{$dt->no_hp}}/{{$dt->email}}</td>
                                                <td>
                                                    {{number_format($saldo_dokter-($pasien_dokter*2000))}}
                                                </td>
                                                <td>
                                                    {{number_format(($saldo_dokter-($pasien_dokter*2000))-$fee)}}
                                                </td>
                                                <td>{{$pasien_dokter}}</td>
                                                <td>
                                                    <a href="pemasukan/{{$dt->id}}/edit" class="btn btn-primary"><i data-feather="eye"></i></a>
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