@extends('layouts.app')

@section('content')
<div class="layout-px-spacing">

    <div class="row layout-top-spacing">

        <div class="col-xl-12 col-lg-12 col-sm-12 user-profile layout-spacing">

            <div class="widget-content widget-content-area br-6 ">
                <div class="d-flex justify-content-between">
                    <h3 class=""> Pilih Spesialis </h3>
                    <a href="{{url('/dashboard')}}" class="mt-2 edit-profile"> <i data-feather="home" class="text-default"> </i></a>
                </div>
                @foreach($spesialis as $dt)
                <a href="{{url('/antri/'.$dt['id'])}}">
                    <div id="basic" class="col-lg-12 layout-top-spacing btn" style=" text-align: left;">
                        <div class="statbox widget box box-shadow">
                            <div class="widget-header">
                                <div class="row">
                                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                        <h4>{{$dt->spesialis}}</h4>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>

    </div>

</div>



@endsection