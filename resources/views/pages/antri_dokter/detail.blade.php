@extends('layouts.app')

@section('content')
<div class="layout-px-spacing">

    <div class="row layout-spacing">

        <!-- Content -->
        <div class="col-xl-4 col-lg-6 col-md-5 col-sm-12 layout-top-spacing">

            <div class="user-profile layout-spacing">
                <div class="widget-content widget-content-area">
                    <div class="d-flex justify-content-between">
                        <h3 class="">Data Pasien</h3>
                        <a href="#" class="mt-2 "> <button class="btn btn-primary mb-2"># NO ANTRIAN : {{$antri->no_antrian}}</button></a>
                    </div>
                    <div class="text-center user-info">
                        <img src="{{(isset($antri->pasien_detail->foto))?asset('uploads/'.$antri->pasien_detail->foto):asset('assets/img/200x200.jpg')}}" alt="avatar" height="50px">
                        <p class="">{{$antri->pasien_detail->name}}</p>
                    </div>
                    <div class="user-info-list">

                        <div class="">
                            <ul class="contacts-block list-unstyled">

                                <li class="contacts-block__item">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar">
                                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                        <line x1="16" y1="2" x2="16" y2="6"></line>
                                        <line x1="8" y1="2" x2="8" y2="6"></line>
                                        <line x1="3" y1="10" x2="21" y2="10"></line>
                                    </svg>{{date('d-m-Y', strtotime($antri->tgl))}}
                                </li>
                                <li class="contacts-block__item">
                                    <i data-feather="clock"></i> {{$antri->waktu_detail->dJam}} - {{$antri->waktu_detail->sJam}}
                                </li>
                                <!-- <li class="contacts-block__item">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-map-pin">
                                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                        <circle cx="12" cy="10" r="3"></circle>
                                    </svg>New York, USA
                                </li> -->
                                <li class="contacts-block__item">
                                    <a href="mailto:example@mail.com"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-mail">
                                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                            <polyline points="22,6 12,13 2,6"></polyline>
                                        </svg>{{$antri->pasien_detail->email}}</a>
                                </li>
                                <li class="contacts-block__item">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-phone">
                                        <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                                    </svg> {{$antri->pasien_detail->no_hp}}
                                </li>

                                <li class="contacts-block__item">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar">
                                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                        <line x1="16" y1="2" x2="16" y2="6"></line>
                                        <line x1="8" y1="2" x2="8" y2="6"></line>
                                        <line x1="3" y1="10" x2="21" y2="10"></line>
                                    </svg> Tgl Daftar : {{date('d-m-Y', strtotime($antri->created_at))}}
                                </li>

                            </ul>
                        </div>
                    </div>
                </div>
            </div>





        </div>

        <div class="col-xl-8 col-lg-6 col-md-7 col-sm-12 layout-top-spacing">

            <div class="skills layout-spacing ">
                <div class="widget-content widget-content-area">
                    <h3 class="">Catatan Untuk Dokter</h3>
                    <p>
                        {{$antri->catatan}}
                    </p>
                </div>
            </div>
            <div class="bio layout-spacing ">
                <div class="widget-content widget-content-area">
                    <h3 class="">Aksi</h3>
                    <form action="/antri_dokter" method="POST">
                        @csrf

                        <div class="invoice-action-btn">
                            <input type="hidden" name="id_antri" value="{{$antri->id}}" />
                            <div class="col-md-12">
                                <div class="form-group">
                                    <textarea class="form-control" placeholder="Catatan pasien" name="catatan" rows="2"></textarea>
                                </div>
                            </div>
                            <center>
                                <button class="btn btn-success mb-2 text-center layout-top-spacing" type="submit"><i data-feather="check"></i> SELESAIKAN</button>
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