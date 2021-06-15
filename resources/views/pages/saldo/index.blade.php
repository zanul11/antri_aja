@extends('layouts.app')

@section('content')

<div class="layout-px-spacing">

    <div class="account-settings-container layout-top-spacing">

        <div class="account-content">
            <div class="scrollspy-example" data-spy="scroll" data-target="#account-settings-scroll" data-offset="-100">
                <div class="row">
                    @if(isset($profile->api_key))
                    <div class="col-xl-5 layout-top-spacing">
                        <div class="user-profile layout-spacing">
                            <div class="widget-content widget-content-area">

                                <div class="text-center user-info">
                                    <img src="https://my.ipaymu.com/asset/images/logo-ipaymu.png" alt="avatar" height="50px">
                                    <p class="">Saldo iPaymu</p>
                                </div>
                                <div class="user-info-list">

                                    <div class="text-center">
                                        <h1>
                                            Rp.20.000
                                        </h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-7 layout-top-spacing">

                        <div class="bio layout-spacing ">
                            <div class="widget-content widget-content-area">
                                <h3 class="">Top Up</h3>
                                <form action="/saldo/{{Auth::user()->id}}" method="POST">
                                    @method('PUT')
                                    @csrf
                                    <div class="invoice-action-btn">

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <input type="number" class="form-control mb-4" id="nikDr" name="jumlah" placeholder="Jumlah top up">

                                            </div>
                                        </div>
                                        <center>
                                            <button class="btn btn-primary mb-2 text-center layout-top-spacing" type="submit"><i data-feather="plus"></i> TOP UP</button>
                                </form>

                                </center>

                            </div>
                            <br>


                        </div>
                    </div>
                </div>
                @endif
                <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing ">
                    <div class="section general-info">
                        <div class="info ">
                            <h6 class="">Informasi Diri</h6>
                            <form method="POST" action="/saldo" class="form-info" id="form-register" autocomplete="off" enctype='multipart/form-data'>
                                @csrf
                                <div class="row">
                                    <div class="col-lg-11 mx-auto">
                                        <div class="row">
                                            <div class="col-xl-2 col-lg-12 col-md-4">
                                                <div class="upload mt-4 pr-md-4">
                                                    <input type="file" id="input-file-max-fs" class="dropify" name="file" data-default-file="https://my.ipaymu.com/asset/images/logo-ipaymu.png" data-max-file-size="2M" disabled />
                                                    <p class="mt-2"><i class="flaticon-cloud-upload mr-1"></i> iPaymu</p>
                                                </div>
                                            </div>
                                            <div class="col-xl-10 col-lg-12 col-md-8 mt-md-0 mt-4">
                                                <div class="form">
                                                    <div class="row">

                                                        <div class="col-sm-12">
                                                            <div class="form-group">
                                                                <label for="nikDr">API KEY iPaymu</label>
                                                                <input type="text" class="form-control mb-4" id="nikDr" name="api_key" placeholder="Api Key" value="{{$profile->api_key}}" required>
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                                </div>
                                            </div>
                                        </div>
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