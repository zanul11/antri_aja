@extends('layouts.app')

@section('content')
<div class="layout-px-spacing">

    <div class="row layout-top-spacing">

        <div class="col-xl-12 col-lg-12 col-sm-12 user-profile layout-spacing">

            <div class="widget-content widget-content-area br-6 ">
                <div class="d-flex justify-content-between">
                    <h3 class=""> {{$page_name}} </h3>
                    <a href="{{url('broadcast/create')}}" class="mt-2 edit-profile"> <i data-feather="plus" class="text-default"> </i></a>
                </div>
                <div class="table-responsive mb-4 mt-4">
                    <table id="zero-config" class="table table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Batas</th>
                                <th>Pesan</th>
                                <th>Gambar</th>
                                <th class="no-content"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data_broadcast as $dt)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{date('m-d-Y', strtotime($dt->batas))}}</td>
                                <td>{{$dt->isi}}</td>
                                <td><img src="{{asset('antri_aja/public/uploads/'.$dt->foto)}}" alt="Girl in a jacket" width="100"></td>
                                <td>
                                    <a href="broadcast/{{$dt->id}}/edit"><i data-feather="edit-2" class="text-warning"></i></a>
                                    <a href="#" onclick="deleteData('/broadcast','{{$dt->id}}')"><i data-feather="trash" class="text-danger"></i></a>
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