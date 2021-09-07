@extends('layouts.app')

@section('content')

<div class="layout-px-spacing">

    <div class="account-settings-container layout-top-spacing">

        <div class="account-content">
            <div class="scrollspy-example" data-spy="scroll" data-target="#account-settings-scroll" data-offset="-100">
                <div class="col-lg-12 ">
                    <div class="bio layout-spacing">
                        <div class="widget-content widget-content-area">
                            <h3 class="">Disposisi Saldo</h3>
                            <form action="/disposisi-admin" method="POST">
                                @csrf
                                <div class="invoice-action-btn">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label for="no_hp">Pilih Faskes Tujuan Disposisi</label>
                                                <select name="dokter" id="disposisi-admin" class="disposisi-admin js-states form-control" required>
                                                    <option value="">-- Pilih Faskes Tujuan Disposisi --</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="no_hp">Jumlah Disposisi</label>
                                                <input type="number" class="form-control mb-4" id="nikDr" name="jumlah" placeholder="Jumlah disposisi" required>
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

            </div>
        </div>

        <div class="col-lg-12 ">
            <div class="bio layout-spacing">
                <div class="widget-content widget-content-area">
                    <h3 class="">Histori Disposisi</h3>
                    <div class="table-responsive mb-4 mt-4">
                        <table id="zero-config" class="table table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <!-- <th>Kredit</th> -->
                                    <th>Jumlah</th>
                                    <!-- <th>Fee</th> -->
                                    <!-- <th>Saldo </th> -->
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
                                @foreach($data_disposisi as $dt)

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
                                    <!-- <td>@if($dt->jenis==1) {{number_format($dt->jumlah)}} @else - @endif</td> -->
                                    <td>
                                        @if($dt->jenis==0)
                                        {{number_format($dt->jumlah)}}
                                        @else -
                                        @endif
                                    </td>
                                    <!-- <td>
                                        @if($dt->jenis==1)
                                        {{number_format($dt->fee)}}
                                        @else -
                                        @endif
                                    </td> -->
                                    <!-- <td> {{number_format($saldo)}}</td> -->
                                    <td> Disposisi ke {{$dt->bonus_detail->name}}{{isset($dt->bonus_detail->nama_faskes)?'/'.$dt->bonus_detail->nama_faskes:''}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="2">Jumlah</td>
                                    <!-- <td>{{number_format($debet)}} </td> -->
                                    <td>
                                        {{number_format($kredit)}}
                                    </td>
                                    <!-- <td>
                                        {{number_format($fee)}}
                                    </td> -->
                                    <td> {{number_format($saldo)}}</td>

                                </tr>
                            </tfoot>


                        </table>
                        <br>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
</form>
</div>




@endsection