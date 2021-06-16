@extends('layouts.app')

@section('content')

<div class="layout-px-spacing">

    <div class="account-settings-container layout-top-spacing">

        <div class="account-content">
            <div class="scrollspy-example" data-spy="scroll" data-target="#account-settings-scroll" data-offset="-100">
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing ">
                        <div class="section general-info">
                            <div class="info ">
                                <h6 class="">Pembayaran</h6>
                                <div class="alert alert-warning">
                                    PERHATIAN: Berikut detail pembayaran untuk Top Up Antri Aja</div>
                                <center>
                                    <div class=" col-lg-6 inv--product-table-section">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <!-- <thead class="">
                                                    <tr>

                                                        <th scope="col">Items</th>

                                                        <th class="text-right" scope="col">Harga</th>

                                                    </tr>
                                                </thead> -->
                                                <tbody>
                                                    <tr>
                                                        <td>Top Up</td>
                                                        @if ($dt_pembayaran['Via']=='Bank Transfer')
                                                        <td class="text-right">{{number_format($dt_pembayaran['SubTotal'])}}</td>
                                                        @else
                                                        <td class="text-right">{{number_format($dt_pembayaran['Total'])}}</td>
                                                        @endif
                                                    </tr>

                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="inv--total-amounts">
                                            <div class="row mt-4">
                                                <div class="col-sm-5 col-12 order-sm-0 order-1">
                                                </div>
                                                <div class="col-sm-7 col-12 order-sm-1 order-0">
                                                    <div class="text-sm-right">
                                                        <div class="row">
                                                            <!-- <div class="col-sm-8 col-7">
                                                                <p class="">Sub Total: </p>
                                                            </div>
                                                            <div class="col-sm-4 col-5">
                                                                <p class="">$3155</p>
                                                            </div>-->
                                                            @if ($dt_pembayaran['Via']=='Bank Transfer')
                                                            <div class="col-sm-8 col-7">
                                                                <p class="">Kode Unik : </p>
                                                            </div>
                                                            <div class="col-sm-4 col-5">
                                                                <p class="">{{$dt_pembayaran['Total']-((int)$dt_pembayaran['SubTotal'])}}</p>
                                                            </div>
                                                            @endif
                                                            <div class="col-sm-8 col-7 grand-total-title">
                                                                <h5 class="">Total : </h5>
                                                            </div>
                                                            <div class="col-sm-4 col-5 grand-total-amount">
                                                                <h5 class="">Rp. {{number_format($dt_pembayaran['Total'])}}</h5>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        @if($dt_pembayaran['Via']=='VA')
                                        <div class="pcmall-paymentfe_3ro10m">
                                            <div class="pcmall-paymentfe_h13V0I">
                                                @if($dt_pembayaran['Channel']=='BNI')
                                                <div class="pcmall-paymentfe_jObzzU"><img src="{{asset('assets/img/bank_bni.png')}}" height="50px"></div>
                                                @elseif ($dt_pembayaran['Channel']=='MANDIRI')
                                                <div class="pcmall-paymentfe_jObzzU"><img src="{{asset('assets/img/bank_mandiri.png')}}" height="50px"></div>
                                                @else
                                                <div class="pcmall-paymentfe_jObzzU"><img src="{{asset('assets/img/bank_cimb.png')}}" height="50px"></div>
                                                @endif
                                                <br>
                                                <div class="pcmall-paymentfe_2rMsHZ">Virtual Account Bank {{$dt_pembayaran['Channel']}} (Dicek Otomatis)</div>
                                            </div>
                                            <div class="pcmall-paymentfe_380Dqo">
                                                <div class="pcmall-paymentfe_1ygB7G">No. VA :</div>
                                                <div class="pcmall-paymentfe_35WPGa">
                                                    <div class="pcmall-paymentfe_1J4pBb" id="no_va">
                                                        <h5>{{$dt_pembayaran['PaymentNo']}}</h5>
                                                    </div>
                                                    <button class="btn" style="color:blue" onclick="copyToClipboard('#no_va')">SALIN</button>
                                                </div>
                                            </div>

                                        </div>
                                        @elseif ($dt_pembayaran['Via']=='Bank Transfer')
                                        <div class="pcmall-paymentfe_3ro10m">
                                            <div class="pcmall-paymentfe_h13V0I">

                                                <div class="pcmall-paymentfe_jObzzU"><img src="{{asset('assets/img/bank_bca.png')}}" height="50px"></div>


                                                <br>
                                                <div class="pcmall-paymentfe_2rMsHZ">Transfer Bank {{$dt_pembayaran['Channel']}} (Dicek Otomatis)</div>
                                            </div>
                                            <div class="pcmall-paymentfe_380Dqo">
                                                <div class="pcmall-paymentfe_1ygB7G">No Rekening :</div>
                                                <div class="pcmall-paymentfe_35WPGa">
                                                    <div class="pcmall-paymentfe_1J4pBb" id="no_va">
                                                        <h5>{{$dt_pembayaran['PaymentNo']}}</h5>
                                                    </div>
                                                    atas nama : {{$dt_pembayaran['PaymentName']}}<br>
                                                    <button class="btn" style="color:blue" onclick="copyToClipboard('#no_va')">SALIN</button>
                                                </div>
                                            </div>

                                        </div>
                                        @else
                                        <div class="pcmall-paymentfe_3ro10m">
                                            <div class="pcmall-paymentfe_h13V0I">
                                                Scan QR dengan : <br>
                                                <div class="pcmall-paymentfe_jObzzU"><img src="https://sandbox.ipaymu.com/asset/images/qris-bpd-bali.png" height="50px"></div>
                                                <br>
                                            </div>
                                            <div class="pcmall-paymentfe_380Dqo">
                                                <div class="pcmall-paymentfe_35WPGa">
                                                    {!! QrCode::size(250)->generate($dt_pembayaran['QrString']); !!}
                                                </div>
                                            </div>

                                        </div>
                                        @endif

                                        <a target="_blank" href="{{asset('assets/help.pdf')}}"><button class="btn btn-primary mb-2 text-center layout-top-spacing" type="submit"><i data-feather="file-text"></i> PANDUAN PEMBAYARAN</button></a>

                                    </div>
                                </center>


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