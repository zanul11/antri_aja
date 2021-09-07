@extends('layouts.app')

@section('content')
<div class="layout-px-spacing" ng-app="app" ng-controller="JadwalController">

    <div class="row layout-top-spacing">
        <div class="col-lg-12 col-12 layout-spacing">
            <div class="statbox widget box box-shadow">
                <div class="widget-header">
                    <div class="row">
                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                            <h4>Input Jadwal Pelayanan</h4>
                        </div>
                    </div>
                </div>
                <div class="widget-content widget-content-area">

                    <div class="row ">
                        <div class=" col-lg-4 ">
                            <label for="no_hp">Hari</label>
                            <select class="form-control" ng-model="selectedHari" ng-options="hari as hari.hari for hari in hari">
                            </select>
                        </div>
                        <div class="col-lg-2">
                            <label for="no_hp">Dari Jam</label>
                            <input type="time" class="form-control" placeholder="First name" ng-model="dJam">
                        </div>
                        <div class="col-lg-2">
                            <label for="no_hp">Sampai</label>
                            <input type="time" class="form-control" placeholder="First name" ng-model="sJam">
                        </div>
                        <div class="col-lg-2">
                            <label for="no_hp">Estimasi (menit)</label>
                            <input type="number" class="form-control" placeholder="Estimasi" ng-model="estimasi">
                        </div>
                        <div class="col-lg-2">
                            <label for="no_hp">#</label><br>
                            <button type="submit" ng-click="insertTabel()" class="btn btn-primary">Add Jadwal</button>

                        </div>

                    </div>

                </div>
            </div>
        </div>


        <div class="col-lg-4 col-sm-4 layout-spacing user-profile ">
            <div class="statbox widget box box-shadow">
                <div class="widget-content widget-content-area br-6 ">
                    <div class="d-flex ">
                        <h5 class=""> Senin </h5>
                    </div>
                    <div class="table-responsive mb-4 ">
                        <table class="table table-hover table-sm" style="width:100%">
                            <thead>
                                <tr>
                                    <th>NO</th>
                                    <th>JAM</th>
                                    <th>Estimasi</th>
                                    <th class="no-content">#</th>
                                </tr>
                            </thead>
                            <tbody class="table-sm">
                                <tr ng-repeat="dt in jadwals | orderBy:'dJam' | filter:{ value: 1 }">
                                    <td align="center">
                                        @{{$index+1}}
                                    </td>
                                    <td align="center">
                                        @{{dt.dJam | date : 'HH:mm'}} - @{{dt.sJam | date : 'HH:mm'}}
                                    </td>
                                    <td align="center">
                                        @{{dt.estimasi}}
                                    </td>
                                    <td align="center">
                                        <a ng-click="removeItem(dt)"><i data-feather="x"></i></a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-lg-4 col-sm-4 layout-spacing user-profile ">
            <div class="statbox widget box box-shadow">
                <div class="widget-content widget-content-area br-6 ">
                    <div class="d-flex ">
                        <h5 class=""> Selasa </h5>
                    </div>
                    <div class="table-responsive mb-4 ">
                        <table class="table table-hover table-sm" style="width:100%">
                            <thead align="center">
                                <tr>
                                    <th>NO</th>
                                    <th>JAM</th>
                                    <th>Estimasi</th>
                                    <th class="no-content">#</th>
                                </tr>
                            </thead>
                            <tbody class="table-sm">
                                <tr ng-repeat="dt in jadwals | orderBy:'dJam' | filter:{ value: 2 }">
                                    <td align="center">
                                        @{{$index+1}}
                                    </td>
                                    <td align="center">
                                        @{{dt.dJam | date : 'HH:mm'}} - @{{dt.sJam | date : 'HH:mm'}}
                                    </td>
                                    <td align="center">
                                        @{{dt.estimasi}}
                                    </td>
                                    <td align="center">
                                        <a ng-click="removeItem(dt)"><i data-feather="x"></i></a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-sm-4 layout-spacing user-profile ">
            <div class="statbox widget box box-shadow">
                <div class="widget-content widget-content-area br-6 ">
                    <div class="d-flex ">
                        <h5 class=""> Rabu </h5>
                    </div>
                    <div class="table-responsive mb-4 ">
                        <table class="table table-hover table-sm" style="width:100%">
                            <thead>
                                <tr>
                                    <th>NO</th>
                                    <th>JAM</th>
                                    <th>Estimasi</th>
                                    <th class="no-content">#</th>
                                </tr>
                            </thead>
                            <tbody class="table-sm">
                                <tr ng-repeat="dt in jadwals | orderBy:'dJam' | filter:{ value: 3 }">
                                    <td align="center">
                                        @{{$index+1}}
                                    </td>
                                    <td align="center">
                                        @{{dt.dJam | date : 'HH:mm'}} - @{{dt.sJam | date : 'HH:mm'}}
                                    </td>
                                    <td align="center">
                                        @{{dt.estimasi}}
                                    </td>
                                    <td align="center">
                                        <a ng-click="removeItem(dt)"><i data-feather="x"></i></a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-sm-4 layout-spacing user-profile ">
            <div class="statbox widget box box-shadow">
                <div class="widget-content widget-content-area br-6 ">
                    <div class="d-flex ">
                        <h5 class=""> Kamis </h5>
                    </div>
                    <div class="table-responsive mb-4 ">
                        <table class="table table-hover table-sm" style="width:100%">
                            <thead>
                                <tr>
                                    <th>NO</th>
                                    <th>JAM</th>
                                    <th>Estimasi</th>
                                    <th class="no-content">#</th>
                                </tr>
                            </thead>
                            <tbody class="table-sm">
                                <tr ng-repeat="dt in jadwals | orderBy:'dJam' | filter:{ value: 4 }">
                                    <td align="center">
                                        @{{$index+1}}
                                    </td>
                                    <td align="center">
                                        @{{dt.dJam | date : 'HH:mm'}} - @{{dt.sJam | date : 'HH:mm'}}
                                    </td>
                                    <td align="center">
                                        @{{dt.estimasi}}
                                    </td>
                                    <td align="center">
                                        <a ng-click="removeItem(dt)"><i data-feather="x"></i></a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-sm-4 layout-spacing user-profile ">
            <div class="statbox widget box box-shadow">
                <div class="widget-content widget-content-area br-6 ">
                    <div class="d-flex ">
                        <h5 class=""> Jumat </h5>
                    </div>
                    <div class="table-responsive mb-4 ">
                        <table class="table table-hover table-sm" style="width:100%">
                            <thead>
                                <tr>
                                    <th>NO</th>
                                    <th>JAM</th>
                                    <th>Estimasi</th>
                                    <th class="no-content">#</th>
                                </tr>
                            </thead>
                            <tbody class="table-sm">
                                <tr ng-repeat="dt in jadwals | orderBy:'dJam' | filter:{ value: 5 }">
                                    <td align="center">
                                        @{{$index+1}}
                                    </td>
                                    <td align="center">
                                        @{{dt.dJam | date : 'HH:mm'}} - @{{dt.sJam | date : 'HH:mm'}}
                                    </td>
                                    <td align="center">
                                        @{{dt.estimasi}}
                                    </td>
                                    <td align="center">
                                        <a ng-click="removeItem(dt)"><i data-feather="x"></i></a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-sm-4 layout-spacing user-profile ">
            <div class="statbox widget box box-shadow">
                <div class="widget-content widget-content-area br-6 ">
                    <div class="d-flex ">
                        <h5 class=""> Sabtu </h5>
                    </div>
                    <div class="table-responsive mb-4 ">
                        <table class="table table-hover table-sm" style="width:100%">
                            <thead>
                                <tr>
                                    <th>NO</th>
                                    <th>JAM</th>
                                    <th>Estimasi</th>
                                    <th class="no-content">#</th>
                                </tr>
                            </thead>
                            <tbody class="table-sm">
                                <tr ng-repeat="dt in jadwals | orderBy:'dJam' | filter:{ value: 6 }">
                                    <td align="center">
                                        @{{$index+1}}
                                    </td>
                                    <td align="center">
                                        @{{dt.dJam | date : 'HH:mm'}} - @{{dt.sJam | date : 'HH:mm'}}
                                    </td>
                                    <td align="center">
                                        @{{dt.estimasi}}
                                    </td>
                                    <td align="center">
                                        <a ng-click="removeItem(dt)"><i data-feather="x"></i></a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-sm-4 layout-spacing user-profile ">
            <div class="statbox widget box box-shadow">
                <div class="widget-content widget-content-area br-6 ">
                    <div class="d-flex ">
                        <h5 class=""> Minggu </h5>
                    </div>
                    <div class="table-responsive mb-4 ">
                        <table class="table table-hover table-sm" style="width:100%">
                            <thead>
                                <tr>
                                    <th>NO</th>
                                    <th>JAM</th>
                                    <th>Estimasi</th>
                                    <th class="no-content">#</th>
                                </tr>
                            </thead>
                            <tbody class="table-sm">
                                <tr ng-repeat="dt in jadwals | orderBy:'dJam' | filter:{ value: 0 }">
                                    <td align="center">
                                        @{{$index+1}}
                                    </td>
                                    <td align="center">
                                        @{{dt.dJam | date : 'HH:mm'}} - @{{dt.sJam | date : 'HH:mm'}}
                                    </td>
                                    <td align="center">
                                        @{{dt.estimasi}}
                                    </td>
                                    <td align="center">
                                        <a ng-click="removeItem(dt)"><i data-feather="x"></i></a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>



    </div>

</div>


@endsection
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.8.0/angular.min.js"></script>
<script src="{{asset('angular/jadwal.js')}}"></script>