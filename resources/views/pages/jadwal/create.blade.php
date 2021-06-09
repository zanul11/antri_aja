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
                        <div class="col-lg-3">
                            <label for="no_hp">Dari Jam</label>
                            <input type="time" class="form-control" placeholder="First name" ng-model="dJam">
                        </div>
                        <div class="col-lg-3">
                            <label for="no_hp">Sampai</label>
                            <input type="time" class="form-control" placeholder="First name" ng-model="sJam">
                        </div>
                        <div class="col-lg-2">
                            <label for="no_hp">#</label><br>
                            <button type="submit" ng-click="insertTabel()" class="btn btn-primary">Add Jadwal</button>

                        </div>

                    </div>

                </div>
            </div>
        </div>

        <div class="col-lg-3 col-sm-4 layout-spacing">

            <div class="statbox widget box box-shadow">
                <div class="height-300" style="display: block; position: relative; overflow-y: auto;">

                    <div class="widget-content widget-content-area">
                        <table class="table table-hover table-sm" style="width:100%">
                            <thead>
                                <tr>
                                    <th>SENIN</th>
                                    <th class="no-content">#</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                            <!-- <tbody>
                                <tr ng-repeat="dt in jadwals | orderBy:'value'">
                                    <td align="center">
                                        @{{$index+1}}
                                    </td>
                                    <td align="center">
                                        @{{dt.hari}}
                                    </td>
                                    <td align="center">
                                        @{{dt.dJam | date : 'HH:mm'}} - @{{dt.sJam | date : 'HH:mm'}}
                                    </td>
                                    <td align="center">
                                        <a ng-click="removeItem($index)"><i data-feather="x"></i></a>
                                    </td>
                                </tr>
                            </tbody> -->

                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-sm-4 layout-spacing">

            <div class="statbox widget box box-shadow">
                <div class="height-300" style="display: block; position: relative; overflow-y: auto;">

                    <div class="widget-content widget-content-area">
                        <table class="table table-hover table-sm" style="width:100%">
                            <thead>
                                <tr>
                                    <th>SELASA</th>
                                    <th class="no-content">#</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-sm-4 layout-spacing">

            <div class="statbox widget box box-shadow">
                <div class="height-300" style="display: block; position: relative; overflow-y: auto;">

                    <div class="widget-content widget-content-area">
                        <table class="table table-hover table-sm" style="width:100%">
                            <thead>
                                <tr>
                                    <th>RABU</th>
                                    <th class="no-content">#</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-sm-4 layout-spacing">

            <div class="statbox widget box box-shadow">
                <div class="height-300" style="display: block; position: relative; overflow-y: auto;">

                    <div class="widget-content widget-content-area">
                        <table class="table table-hover table-sm" style="width:100%">
                            <thead>
                                <tr>
                                    <th>KAMIS</th>
                                    <th class="no-content">#</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-sm-4 layout-spacing">

            <div class="statbox widget box box-shadow">
                <div class="height-300" style="display: block; position: relative; overflow-y: auto;">

                    <div class="widget-content widget-content-area">
                        <table class="table table-hover table-sm" style="width:100%">
                            <thead>
                                <tr>
                                    <th>JUMAT</th>
                                    <th class="no-content">#</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-sm-4 layout-spacing">

            <div class="statbox widget box box-shadow">
                <div class="height-300" style="display: block; position: relative; overflow-y: auto;">

                    <div class="widget-content widget-content-area">
                        <table class="table table-hover table-sm" style="width:100%">
                            <thead>
                                <tr>
                                    <th>SABTU</th>
                                    <th class="no-content">#</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-sm-4 layout-spacing">

            <div class="statbox widget box box-shadow">
                <div class="height-300" style="display: block; position: relative; overflow-y: auto;">

                    <div class="widget-content widget-content-area">
                        <table class="table table-hover table-sm" style="width:100%">
                            <thead>
                                <tr>
                                    <th>MINGGU</th>
                                    <th class="no-content">#</th>
                                </tr>
                            </thead>
                            <tbody>

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