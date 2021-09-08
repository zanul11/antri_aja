<p>Laporan Pasien</p>
<p>Nakes : {{$nakes}}</p>
<p>Periode Waktu : {{$periode}}</p>
<br>
<table id="zero-config" class="table table-hover" style="width:100%">
    <thead>
        <tr>
            <th style="width: 5%;">No</th>
            <th style="width: 30%;">Nama Pasien</th>
            <th style="width: 30%;">Faskes</th>
            <th style="width: 20%;">Nakes</th>
            <th style="width: 30%;">Waktu</th>
            <th style="width: 10%;">Status </th>
        </tr>
    </thead>
    <tbody>
        @foreach($laporan_pasien as $dt)
        <tr>
            <td>{{$loop->iteration}}</td>
            <td>{{$dt->pasien}}</td>
            <td>{{$dt->dokter_detail->faskes->nama_faskes}}</td>
            <td>{{$dt->dokter_detail->name}}</td>
            <td>{{$dt->dJam}}-{{$dt->sJam}}</td>
            <td>@if($dt->status==1)
                <span class="badge badge-success"> Ditangani </span>
                @elseif($dt->status==0)
                <span class="badge badge-warning"> Terdaftar </span>
                @endif
            </td>

        </tr>
        @endforeach

    </tbody>

</table>