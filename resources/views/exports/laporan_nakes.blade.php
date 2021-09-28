<p>Laporan Tenaga Kesehatan</p>
<p>Faskes : {{$faskes->nama_faskes}}</p>

<br>
<table id="zero-config" class="table table-hover" style="width:100%">
    <thead>
        <tr>
            <th>No</th>
            <th>Username</th>
            <th>Nama</th>
            <th>No Hp</th>
            <th>Alamat</th>

        </tr>
    </thead>
    <tbody>
        @foreach($laporan_nakes as $dt)
        <tr>
            <td>{{$loop->iteration}}</td>
            <td>{{$dt->username}}</td>
            <td>{{$dt->name}}</td>
            <td>{{$dt->no_hp}}</td>
            <td>{{$dt->alamat}}</td>
        </tr>
        @endforeach
    </tbody>

</table>