<center>

    <p>Laporan Marketing</p>
</center>

<br>
<table id="zero-config" class="table table-hover" style="width:100%">
    <thead>
        <tr>
            <th style="width: 5%;">No</th>
            <th style="width: 30%;">Username</th>
            <th style="width: 30%;">Nama</th>
            <th style="width: 30%;">No Hp</th>
            <th style="width: 40%;">Alamat</th>
        </tr>
    </thead>
    <tbody>
        @foreach($laporan_marketing as $dt)
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