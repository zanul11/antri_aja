@extends('layouts.app')

@section('content')
<div class="layout-px-spacing" ng-app="app" ng-controller="WaktuController" ng-init="init({{$dokter->id}})">

    <div class="row layout-top-spacing">

        <div class="col-xl-12 col-lg-12 col-sm-12 user-profile layout-spacing">

            <div class="widget-content widget-content-area br-6 ">
                <div class="d-flex justify-content-between">
                    <h3 class=""> {{$dokter->name}} - {{$dokter->spesialis_detail->spesialis}} </h3>
                    <a href="{{url('/antri')}}" class="mt-2 edit-profile"> <i data-feather="home" class="text-default"> </i></a>
                </div>
                <div class="table-responsive mb-4 mt-4">
                    <div class="col-lg-12 col-12 layout-spacing" ng-show="!info">
                        <div class="statbox widget box box-shadow">
                            <div class="widget-header">
                                <div class="row">
                                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                        <h4>Pilih Tanggal</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="widget-content widget-content-area">
                                <div class="form-group mb-0">
                                    <input id="basicFlatpickr" ng-model="tgl" ng-change="onChange()" class="form-control flatpickr flatpickr-input active" type="text" placeholder="Pilih Tanggal Antrian..">
                                </div>
                                <div class="form-group mb-0 layout-top-spacing">
                                    <div class="row">
                                        <div class="col-lg-4" ng-repeat="dt in jam">
                                            <button class="btn btn-block btn-primary mb-2" ng-click="selectJam(dt)">@{{dt.dJam | date : 'HH:mm'}} - @{{dt.sJam | date : 'HH:mm'}}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 col-12 layout-spacing" ng-show="info">
                        <div class="statbox widget box box-shadow">
                            <div class="widget-header">
                                <div class="row">
                                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                        <h4>Informasi Pesanan</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="widget-content widget-content-area">

                                <div class="col-xl-10 col-lg-12 col-md-8 mt-md-0 mt-4">

                                    <div class="form">
                                        <div class="row">
                                            <div class="alert alert-warning mb-4 col-sm-12" role="alert">
                                                <h5 class="text-center">Jumlah Antrian : @{{jumlahAntrian}}</h5>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="fullName">Nama Dokter</label>
                                                    <input type="text" class="form-control mb-4" id="fullName" name="nama" placeholder="Nama Lengkap" value="{{$dokter->name}}" readonly>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="noHp">No Hp/Email Dokter</label>
                                                    <input type="email" class="form-control mb-4" id="noHp" name="email" value="{{$dokter->no_hp}}/{{$dokter->email}}" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="">Spesialis</label>
                                                    <select class="placeholder js-states form-control" name="spesialis" readonly>
                                                        @foreach($data_spesialis as $dt)
                                                        <option value="{{$dt->id}}" {{($dokter->spesialis==$dt->id)?'selected':''}}>{{$dt->spesialis}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="noHp">Pengalaman</label>
                                                    <input type="number" class="form-control mb-4" id="noHp" name="pengalaman" value="{{$dokter->pengalaman}}" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="noHp">Tanggal</label>
                                                    <input type="email" class="form-control mb-4" id="noHp" name="email" ng-model="tgl" disabled>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="noHp">Jam</label>
                                                    <input type="text" class="form-control mb-4" ng-model="jam_" id="noHp" name="no_hp" placeholder="no Hp" readonly>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="noHp">Catatan untuk Dokter</label>
                                                    <textarea class="form-control" rows="5" autofocus ng-model="note"></textarea>
                                                </div>
                                            </div>


                                        </div>

                                    </div>
                                </div>
                                <center>
                                    <button class="btn btn-success mb-2 text-center layout-top-spacing" ng-click="submit()"><i data-feather="plus"></i> Buat Antrian</button>

                                    <button class="btn btn-default mb-2 text-center layout-top-spacing" ng-click="kembali()"><i data-feather="x"></i> Kembali</button>
                                </center>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>

</div>



@endsection
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.8.0/angular.min.js"></script>
<script src="{{asset('angular/waktu.js')}}"></script>