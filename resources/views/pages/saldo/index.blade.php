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
                                <h3 class="">Saldo</h3>
                                <div class="text-center user-info">
                                    <img src="{{asset('assets/img/logo2.png')}}" alt="avatar">
                                    <br><br>
                                    <p class="">{{Auth::user()->username}}</p>
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
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="no_hp">Pilih Metode</label>
                                                    <select class="pembayaran js-states form-control" id="metode" name="metode" onchange="pilihMetode()" required>
                                                        <option value="">Pilih metode pembayaran</option>
                                                        <option value="va">Virtual Akun</option>
                                                        <!-- <option value="banktransfer">Bank Transfer</option> -->
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
                                        </div>

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
                                            <th>Kredit</th>
                                            <th>Debet/TopUp</th>
                                            <th>Fee</th>
                                            <th>Saldo </th>
                                            <th>Ket </th>
                                            <!-- <th>Saldo Real</th> -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                        $debet = 0;
                                        $kredit = 0;
                                        $fee = 0;
                                        $saldo = 0;
                                        $pemasukan = 0;
                                        @endphp
                                        @foreach($data_dokter->saldo as $dt)

                                        @php
                                        if($dt->jenis==1){
                                        $debet+=$dt->jumlah;
                                        $fee+=$dt->fee;
                                        $saldo+=$dt->jumlah;
                                        }
                                        else{
                                        $kredit+=$dt->jumlah;
                                        $saldo-=$dt->jumlah;
                                        $pemasukan += $dt->jumlah_admin;
                                        }
                                        @endphp
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <!-- <td>{{$dt->nik}}</td> -->
                                            <td>{{date('d-m-Y', strtotime($dt->created_at))}}</td>
                                            <td>@if($dt->jenis==1) {{number_format($dt->jumlah)}} @else - @endif</td>
                                            <td>
                                                @if($dt->jenis==0)
                                                {{number_format($dt->jumlah)}}
                                                @else -
                                                @endif
                                            </td>
                                            <td>
                                                @if($dt->jenis==1)
                                                {{number_format($dt->fee)}}
                                                @else -
                                                @endif
                                            </td>
                                            <td> {{number_format($saldo)}}</td>
                                            <td> @if($dt->ket=='Bonus') {{$dt->ket}} dari {{$dt->dari}} @elseif($dt->ket=='Disposisi') @if($dt->jenis==1) {{$dt->ket}} dari {{$dt->dari}} @else {{$dt->ket}} ke {{$dt->dari}} @endif @else {{$dt->ket}} @endif</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="2">Jumlah</td>
                                            <td>{{number_format($debet)}} </td>
                                            <td>
                                                {{number_format($kredit)}}
                                            </td>
                                            <td>
                                                {{number_format($fee)}}
                                            </td>
                                            <td> {{number_format($saldo)}}</td>

                                        </tr>
                                    </tfoot>


                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                @if(Auth::user()->role!=5)
                <div class="col-lg-12 ">
                    <div class="bio layout-spacing">
                        <div class="widget-content widget-content-area">
                            <h3 class="">Disposisi Saldo</h3>
                            <form action="/disposisi" method="POST">
                                @csrf
                                <div class="invoice-action-btn">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label for="no_hp">Pilih Nakes Tujuan Disposisi</label>
                                                <select name="dokter" id="dokter" class="dokter js-states form-control" required>
                                                    <option value="">-- Pilih Nakes Tujuan Disposisi --</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="no_hp">Jumlah Disposisi</label>
                                                <input type="number" class="form-control mb-4" id="nikDr" name="jumlah" placeholder="Jumlah top up" required>

                                            </div>
                                        </div>
                                    </div>


                                    <center>
                                        <button class="btn btn-primary mb-2 text-center layout-top-spacing" type="submit"><i data-feather="send"></i> DISPOSISI</button>
                                </div>
                            </form>
                            </center>
                        </div>
                    </div>
                </div>
                @endif
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