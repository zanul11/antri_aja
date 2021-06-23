@extends('layouts.app')

@section('content')

<div class="layout-px-spacing">

    <div class="account-settings-container layout-top-spacing">

        <div class="account-content">
            <div class="scrollspy-example" data-spy="scroll" data-target="#account-settings-scroll" data-offset="-100">
                <h3 class="">Laporan : {{$data_dokter->name}}</h3>

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

                    <div class="col-lg-12 ">
                        <div class="bio layout-spacing">
                            <div class="widget-content widget-content-area">
                                <h3 class="">Data Keuangan</h3>
                                <div class="table-responsive mb-4 mt-4">
                                    <table id="zero-config" class="table table-hover" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Tanggal</th>
                                                <th>Debet/TopUp</th>
                                                <th>Kredit</th>
                                                <th>Fee</th>
                                                <th>Saldo </th>
                                                <th>Saldo iPaymu </th>
                                                <th>Pemasukan </th>
                                                <!-- <th>Saldo Real</th> -->
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                            $debet = 0;
                                            $kredit = 0;
                                            $fee = 0;
                                            $saldo = 0;
                                            $pemasukan = 0;
                                            @endphp
                                            @foreach($data_dokter->saldo as $dt)

                                            @php
                                            if($dt->jenis==1){
                                            $debet+=$dt->jumlah;
                                            $fee+=$dt->fee;
                                            $saldo+=$dt->jumlah;
                                            }
                                            else{
                                            $kredit+=$dt->jumlah;
                                            $saldo-=$dt->jumlah;
                                            $pemasukan += $dt->jumlah_admin;
                                            }
                                            @endphp
                                            <tr>
                                                <td>{{$loop->iteration}}</td>
                                                <!-- <td>{{$dt->nik}}</td> -->
                                                <td>{{date('d-m-Y', strtotime($dt->created_at))}}</td>
                                                <td>@if($dt->jenis==1) {{number_format($dt->jumlah)}} @else - @endif</td>
                                                <td>
                                                    @if($dt->jenis==0)
                                                    {{number_format($dt->jumlah)}}
                                                    @else -
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($dt->jenis==1)
                                                    {{number_format($dt->fee)}}
                                                    @else -
                                                    @endif
                                                </td>
                                                <td> {{number_format($saldo)}}</td>
                                                <td> {{number_format($saldo-$fee)}}</td>
                                                <td> {{number_format($dt->jumlah_admin)}}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="2">Jumlah</td>
                                                <td>{{number_format($debet)}} </td>
                                                <td>
                                                    {{number_format($kredit)}}
                                                </td>
                                                <td>
                                                    {{number_format($fee)}}
                                                </td>
                                                <td> {{number_format($saldo)}}</td>
                                                <td> {{number_format($saldo-$fee)}}</td>
                                                <td> {{number_format($pemasukan)}}</td>
                                            </tr>
                                        </tfoot>


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