@extends('layouts.app')

@section('content')
<div class="layout-px-spacing">

    <div class="row layout-spacing">

        <!-- Content -->
        <div class="col-xl-4 col-lg-6 col-md-5 col-sm-12 layout-top-spacing">

            <div class="user-profile layout-spacing">
                <div class="widget-content widget-content-area">
                    <div class="d-flex justify-content-between">
                        <h3 class="">Data Request Withdraw/Penarikan Saldo Bonus</h3>
                        <a href="#" class="mt-2 "> <button class="btn btn-primary mb-2">Rp. {{number_format($data_request->jumlah)}}</button></a>
                    </div>
                    <div class="text-center user-info">
                        <img src="{{(isset($data_request->user_detail->foto))?asset('antri_aja/public/uploads/'.$data_request->user_detail->foto):asset('assets/img/200x200.jpg')}}" alt="avatar" height="50px">
                        <p class="">{{$data_request->user_detail->name}}</p>
                    </div>
                    <div class="user-info-list">

                        <div class="">
                            <ul class="contacts-block list-unstyled">

                                <li class="contacts-block__item">
                                    <i data-feather="user"></i>{{$data_request->user_detail->username}}
                                </li>
                                <li class="contacts-block__item">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-phone">
                                        <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                                    </svg>
                                    {{$data_request->user_detail->name}}
                                </li>


                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 layout-top-spacing">

            <div class="bio layout-spacing ">
                <div class="widget-content widget-content-area">
                    <h3 class="">Form Verifikasi</h3>
                    <form action="/withdraw-admin" method="POST" enctype='multipart/form-data'>
                        @csrf
                        <input type="hidden" name="id_request" value="{{$data_request->id}}">
                        <input type="hidden" name="id_user" value="{{$data_request->user}}">
                        <input type="hidden" name="jumlah" value="{{$data_request->jumlah}}">


                        <div class="invoice-action-btn">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="status">Status</label>
                                        <select class="pembayaran js-states form-control" name="status" required>
                                            <option value="1">Terima</option>
                                            <option value="2">Tolak</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>File Bukti Transfer </label>
                                        <input type="file" class="form-control" name="file">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <textarea class="form-control" placeholder="Keterangan" name="ket" rows="3"></textarea>
                                </div>
                            </div>
                            <center>
                                <button class="btn btn-success mb-2 text-center layout-top-spacing" type="submit"><i data-feather="check"></i>VERIFIKASI</button>

                    </form>
                    <button class="btn btn-default mb-2 text-center layout-top-spacing"><i data-feather="x"></i> Kembali</button>
                    </center>

                </div>
                <br>


            </div>
        </div>

    </div>

</div>
</div>
@endsection