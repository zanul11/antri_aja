@extends('layouts.app')

@section('content')
<div class="layout-px-spacing">

    <div class="row layout-top-spacing">

        <div class="col-xl-12 col-lg-12 col-sm-12 user-profile layout-spacing">

            <div class="widget-content widget-content-area br-6 ">
                <div class="d-flex justify-content-between">
                    <h3 class=""> Daftar Dokter {{$spesialis->spesialis}}</h3>
                    <a href="{{url('marketing/create')}}" class="mt-2 edit-profile"> <i data-feather="plus" class="text-defaulr"> </i></a>
                </div>
                <div class="table-responsive mb-4 mt-4">
                    <table id="zero-config" class="table table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>No Hp/email</th>
                                <th>Pengalaman</th>
                                <th>Jadwal</th>
                                <th class="no-content"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($dokter as $dt)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$dt->name}}</td>
                                <td>{{$dt->no_hp}}/{{$dt->email}}</td>
                                <td>{{$dt->pengalaman}}</td>
                                <td>
                                    @if(count($dt->jadwal)>0)
                                    @php
                                    $i=0;
                                    @endphp
                                    @foreach($dt->jadwal as $j)
                                    <span class="badge badge-success badge-pills">{{($j->hari==1)?'Senin':(($j->hari==2)?'Selasa':(($j->hari==3)?'Rabu':(($j->hari==4)?'Kamis':(($j->hari==5)?'Jumat':(($j->hari==6)?'Sabtu':'Minggu')))))}}</span>

                                    @endforeach
                                    @else
                                    Tidak Ada Jadwal!
                                    @endif
                                </td>
                                <td>
                                    <a href="marketing/{{$dt->id}}/edit"><button class="btn btn-primary mb-2">Daftar</button></a>

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