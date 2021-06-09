@extends('layouts.app')

@section('content')

<div class="layout-px-spacing">

    <div class="account-settings-container layout-top-spacing">

        <div class="account-content">
            <div class="scrollspy-example" data-spy="scroll" data-target="#account-settings-scroll" data-offset="-100">
                <form method="POST" action="/password/{{$profile->id}}" class="form-info" id="form-register" autocomplete="off" enctype='multipart/form-data'>
                    @method('PUT')
                    @csrf
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                            <div class="section general-info">
                                <div class="info">
                                    <h5 class="">Ubah Password</h5>
                                    <div class="row">
                                        <div class="col-md-6 mx-auto">
                                            <div class="row">

                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="address">Password Lama</label>
                                                        <input type="password" class="form-control mb-4" id="address" name="old_password" placeholder="Password Lama" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="location">Password Baru</label>
                                                        <input type="password" class="form-control mb-4" id="location" name="new_password" placeholder="Password Baru" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="phone">Konfirmasi Password Baru</label>
                                                        <input type="password" class="form-control mb-4" id="phone" name="konfirmasi_password" placeholder="Password Baru" required>
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
        <div class="account-settings-footer">
            <div class="as-footer-container">
                <button type="submit" class="btn btn-primary">Ubah Password</button>
            </div>
        </div>
    </div>
    </form>
</div>

@endsection