@extends('layouts.app')

@section('content')

<div class="layout-px-spacing">

    <div class="account-settings-container layout-top-spacing">

        <div class="account-content">
            <div class="scrollspy-example" data-spy="scroll" data-target="#account-settings-scroll" data-offset="-100">
                <div class="row">
                    @if(isset($profile->api_key))
                    <div class="col-xl-5 layout-top-spacing">
                        <div class="bio layout-spacing">
                            <div class="widget-content widget-content-area">
                                <h3 class="">Saldo</h3>
                                <div class="text-center user-info">
                                    <img src="{{asset('assets/img/favicon.ico')}}" alt="avatar" height="50px">
                                    <p class="">{{Auth::user()->email}}</p>
                                </div>
                                <div class="user-info-list layout-spacing">
                                    <div class="text-center">
                                        <h1>
                                            Rp. {{number_format($saldo)}}
                                        </h1>
                                    </div>
                                </div>
                            </div><br>
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
                                        <!-- <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="no_hp">Pilih Metode</label>
                                                    <select class="pembayaran js-states form-control" id="metode" name="metode" onchange="pilihMetode()" required>
                                                        <option value="">Pilih metode pembayaran</option>
                                                        <option value="va">Virtual Akun</option>
                                                        <option value="banktransfer">Bank Transfer</option>
                                                        <option value="qris">QRIS</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="no_hp">Pilih Metode</label>
                                                    <select class="pembayaran js-states form-control" name="paymentChannel" id="paymentChannel" required>

                                                    </select>
                                                </div>
                                            </div>
                                        </div> -->

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <input type="number" class="form-control mb-4" id="nikDr" name="jumlah" placeholder="Jumlah top up" required>
                                            </div>
                                        </div>
                                        <center>
                                            <button class="btn btn-primary mb-2 text-center layout-top-spacing" type="submit"><i data-feather="plus"></i> TOP UP</button>
                                    </div>
                                </form>
                                </center>

                            </div>
                            <br>


                        </div>
                    </div>
                </div>
                @endif
                <!-- <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing ">
                    <div class="section general-info">
                        <div class="info ">
                            <h6 class="">Pembayaran</h6>
                            <div class="alert alert-warning">
                                PERHATIAN: Virtual Account untuk top up Antri Aja </div>
                            <center>
                                <div class=" col-lg-6 inv--product-table-section">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead class="">
                                                <tr>

                                                    <th scope="col">Items</th>

                                                    <th class="text-right" scope="col">Harga</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Top Up</td>
                                                    <td class="text-right">$120</td>
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
                                                        <div class="col-sm-8 col-7">
                                                            <p class="">Sub Total: </p>
                                                        </div>
                                                        <div class="col-sm-4 col-5">
                                                            <p class="">$3155</p>
                                                        </div>
                                                        <div class="col-sm-8 col-7">
                                                            <p class="">Harga Layanan: </p>
                                                        </div>
                                                        <div class="col-sm-4 col-5">
                                                            <p class="">$700</p>
                                                        </div>

                                                        <div class="col-sm-8 col-7 grand-total-title">
                                                            <h4 class="">Total : </h4>
                                                        </div>
                                                        <div class="col-sm-4 col-5 grand-total-amount">
                                                            <h4 class="">$3845</h4>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="pcmall-paymentfe_3ro10m">
                                        <div class="pcmall-paymentfe_h13V0I">
                                            <div class="pcmall-paymentfe_jObzzU"><img src="https://shopee.co.id/static/images/img_bankid_mandiri@3x.png"></div>
                                            <div class="pcmall-paymentfe_2rMsHZ">Bank Mandiri &amp; Bank lainnya (Dicek Otomatis)</div>
                                        </div>
                                        <div class="pcmall-paymentfe_380Dqo">
                                            <div class="pcmall-paymentfe_1ygB7G">No. VA :</div>
                                            <div class="pcmall-paymentfe_35WPGa">

                                                <div class="pcmall-paymentfe_1J4pBb" id="no_va">
                                                    <h5>896 0819 3947 7455</h5>
                                                </div>
                                                <button class="btn" style="color:blue" onclick="copyToClipboard('#no_va')">SALIN</button>



                                            </div>
                                        </div>
                                       
                                    </div>
                                    <button class="btn btn-primary mb-2 text-center layout-top-spacing" type="submit"><i data-feather="check"></i> OK</button>

                                </div>
                            </center>


                        </div>
                    </div>
                </div> -->
                <!-- <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing ">
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
                </div> -->
            </div>
        </div>
    </div>

</div>
</form>
</div>




@endsection
<script>
    function copyToClipboard(element) {
        var $temp = $("<input>");
        $("body").append($temp);
        $temp.val($(element).text()).select();
        document.execCommand("copy");
        $temp.remove();
        alert('Berhasil disalin')
    }


    function pilihMetode() {
        var metode = document.getElementById("metode").value;
        var select = document.getElementById('paymentChannel');
        var va = [{
                id: 'bni',
                text: 'BNI'
            },
            {
                id: 'cimb',
                text: 'Cimb Niaga'
            },
            {
                id: 'mandiri',
                text: 'Mandiri'
            }
        ];
        var tf = [{
            id: 'bca',
            text: 'BCA'
        }];
        var qris = [{
            id: 'linkaja',
            text: 'Link Aja'
        }];


        if (metode == 'va')
            var data = va;
        else if (metode == 'banktransfer')
            var data = tf;
        else
            var data = qris;

        $("#paymentChannel").empty();

        for (var i = 0; i < data.length; i++) {
            var opt = document.createElement('option');
            opt.value = data[i]['id'];
            opt.innerHTML = data[i]['text'];
            select.appendChild(opt);
        }
    }
</script>