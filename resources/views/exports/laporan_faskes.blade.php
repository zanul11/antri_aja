<center>
    <p>Laporan Fasilitas Kesehatan</p>
</center>

<table id="zero-config" class="table table-hover" style="width:100%">
    <thead>
        <tr>
            <th>No</th>
            <th>Email</th>
            <th>Nama Faskes</th>
            <th>No Hp</th>
            <!-- <th>Alamat</th> -->
            <th>Jumlah Nakes</th>
        </tr>
    </thead>
    <tbody>
        @foreach($laporan_faskes as $dt)
        <tr>
            <td>{{$loop->iteration}}</td>
            <td>{{$dt->email}}</td>
            <td>{{$dt->nama_faskes}}</td>
            <td>{{$dt->no_hp}} / {{$dt->tlp_faskes}}</td>
            <td>{{count($dt->akun_faskes)-1}}</td>
        </tr>
        @endforeach
    </tbody>

</table>