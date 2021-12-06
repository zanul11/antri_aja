@extends('layouts.app')

@section('content')

<div class="layout-px-spacing">

    <div class="account-settings-container layout-top-spacing">

        <div class="account-content">
            <div class="scrollspy-example" data-spy="scroll" data-target="#account-settings-scroll" data-offset="-100">
                <div class="row">

                    <div class="col-xl-5 layout-top-spacing">
                        <div class="bio layout-spacing">
                            <div class="widget-content widget-content-area">
                                <h3 class="">Saldo Bonus</h3>
                                <div class="text-center user-info">
                                    <img src="{{asset('assets/img/logo2.png')}}" alt="avatar">
                                    <br><br>
                                    <p class="">{{Auth::user()->username}}</p>
                                </div>
                                <div class="user-info-list layout-spacing">
                                    <div class="text-center">
                                        <h1>
                                            Rp. {{number_format($saldo_bonus)}}
                                        </h1>
                                    </div>
                                </div>
                            </div><br>
                        </div>
                    </div>
                    <div class="col-xl-7 layout-top-spacing">

                        <div class="bio layout-spacing ">
                            <div class="widget-content widget-content-area">
                                <h3 class="">Withdraw/Penarikan</h3>
                                <form action="/withdraw" method="POST">

                                    @csrf
                                    <div class="invoice-action-btn">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="no_hp">Nama Tujuan Transfer</label>
                                                    <input type="text" class="form-control mb-4" name="nm_trf" placeholder="Nama Tujuan Transfer" value="{{(isset($data_dokter->nm_trf))?$data_dokter->nm_trf:''}}" required>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="no_hp">Nama Bank</label>
                                                    <input type="text" class="form-control mb-4" name="nm_bank" placeholder="Nama Bank Tujuan Transfer" value="{{(isset($data_dokter->nm_bank))?$data_dokter->nm_bank:''}}" required>
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label for="no_hp">Nomor Rekening</label>
                                                    <input type="number" class="form-control mb-4" name="no_rek" placeholder="No Rekening" value="{{(isset($data_dokter->no_rek))?$data_dokter->no_rek:''}}" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <input type="number" class="form-control mb-4" id="nikDr" name="jumlah" placeholder="Jumlah withdraw/penarikan" required>
                                            </div>
                                        </div>
                                        <center>
                                            <button class="btn btn-primary mb-2 text-center layout-top-spacing" type="submit"><i data-feather="plus"></i> Request Withdraw</button>
                                            <br><br>
                                    </div>
                                </form>
                                </center>

                            </div>
                            <br>


                        </div>
                    </div>
                </div>
                <div class="col-lg-12 ">
                    <div class="bio layout-spacing">
                        <div class="widget-content widget-content-area">
                            <h3 class="">Data Keuangan</h3>
                            <div class="table-responsive mb-4 mt-4">
                                <table id="zero-config" class="table table-hover" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Tanggal</th>
                                            <th>Jumlah</th>
                                            <th>Bank Tujuan</th>
                                            <th>Status</th>
                                            <th class="no-content"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($data_withdraw as $dt)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$dt->created_at}}</td>
                                            <td>{{$dt->jumlah}}</td>
                                            <td>{{$dt->nm_trf}} ({{$dt->nm_bank}}) - {{$dt->no_rek}}</td>
                                            <td>@if($dt->status==0)
                                                <span class="badge badge-warning"> Menunggu Verifikasi </span>
                                                @elseif($dt->status==2)
                                                <span class="badge badge-danger"> Ditolak </span>
                                                @else
                                                <span class="badge badge-success"> Berhasil </span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($dt->status==0)
                                                <a href="#" onclick="deleteData('/withdraw','{{$dt->id}}')"><i data-feather="trash" class="text-danger"></i></a>
                                                @endif
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
                id: 'bca',
                text: 'BCA'
            },
            {
                id: 'bni',
                text: 'BNI'
            },
            {
                id: 'bri',
                text: 'BRI'
            },
            {
                id: 'cimb',
                text: 'Cimb Niaga'
            },
            {
                id: 'mandiri',
                text: 'Mandiri'
            },
            {
                id: 'bmi',
                text: 'Muamalat '
            },
        ];
        var tf = [{
            id: 'bca',
            text: 'BCA'
        }];
        var qris = [{
            id: 'linkaja',
            text: 'Link Aja, Dana, OVO, Dll'
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