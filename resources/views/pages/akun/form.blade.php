@extends('layouts.app')

@section('content')
<div class="layout-px-spacing">

    <div class="row layout-top-spacing">

        <div class="col-xl-12 col-lg-12 col-sm-12 user-profile layout-spacing">

            <div class="widget-content widget-content-area br-6 ">
                <div class="d-flex justify-content-between">
                    <h3 class=""> {{$page_name}} / {{$category_name}} </h3>
                    <a href="{{url('/akun')}}" class="mt-2  text-danger layout-spacing"><i data-feather="x"></i></a>
                </div>
                <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                    <form id="contact" class="section contact layout-spacing" method="POST" action="{{($action==='Tambah')?'/akun':'/akun/'.$akun->id}}">
                        @if($action=='Edit')
                        @method('PUT')
                        @endif
                        @csrf
                        <div class=" info">
                            @if ($errors->any())
                            <div class="alert alert-pink alert-dismissable fade show has-icon">
                                <i class="la la-info-circle alert-icon"></i>
                                <button class="close" data-dismiss="alert" aria-label="Close"></button>
                                @foreach ($errors->all() as $error)
                                {{ $error }}
                                @endforeach
                            </div>
                            @endif
                            <div class="row">
                                <div class="col-md-11 mx-auto">
                                    <div class="row">

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="nama">Nama</label>
                                                <input type="text" class="form-control mb-4" name="nama" id="nama" placeholder="Nama user" value="{{(isset($akun))?$akun->name:(old('nama')??'')}}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="email">Usename</label>
                                                <input type="text" class="form-control mb-4" name="username" id="username" placeholder="Username (tanpa spasi)" value="{{(isset($akun))?$akun->username:(old('username')??'')}}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="password">Password</label>
                                                <input type="password" class="form-control mb-4" name="password" id="password" placeholder="{{($action=='Edit')?'Cant show':'Write your password'}}" {{($action=='Tambah')?'required':''}}>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="no_hp">No Hp</label>
                                                <input type="number" class="form-control mb-4" name="no_hp" id="no_hp" placeholder="No Hp user" value="{{(isset($akun))?$akun->no_hp:(old('no_hp')??'')}}" required>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="no_hp">Spesialisasi</label>
                                                <select class="placeholder js-states form-control" name="spesialis" required>
                                                    @foreach($data_spesialis as $dt)
                                                    <option value="{{$dt->id}}" {{($action!='Tambah')?(($akun->spesialis==$dt->id)?'selected':''):''}}>{{$dt->spesialis}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="pengalaman">Pengalaman</label>
                                                <input type="number" class="form-control mb-4" name="pengalaman" id="pengalaman" placeholder="Dalam tahun" value="{{(isset($akun))?$akun->pengalaman:(old('pengalaman')??'')}}">
                                            </div>
                                        </div>
                                        <div class="col-lg-12">

                                            <div class="form-group">
                                                <label for="alamat">Deskripsi pribadi dokter</label>
                                                <textarea class="form-control" placeholder="Deskripsi" name="deskripsi" rows="2">{{(isset($akun))?$akun->deskripsi:(old('deskripsi')??'')}}</textarea>
                                            </div>

                                        </div>


                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="no_hp">Provinsi</label>
                                                <select class="provinsi js-states form-control" id="provinsi" name="province" onchange="getKota(this.value)" required>
                                                    <option value="">Pilih Provinsi</option>
                                                    @foreach($data_provinsi as $dt)
                                                    <option value="{{$dt->province_id}}" {{($action!='Tambah')?(($akun->id_province==$dt->province_id)?'selected':''):''}}>{{$dt->province}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="no_hp">Kabupaten/Kota</label>
                                                <select class="kota js-states form-control" name="kota" id="kota" onchange="getKec(this.value)" required>
                                                    <!-- <option value="">Pilih Provinsi Dulu!</option> -->
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="no_hp">Kecamatan</label>
                                                <select class="kecamatan js-states form-control" id="kec" name="kec" required>

                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-12">

                                            <div class="form-group">
                                                <label for="alamat">Alamat Detail Praktek</label>
                                                <textarea class="form-control" placeholder="Alamat" name="alamat" rows="5">{{(isset($akun))?$akun->alamat:(old('alamat')??'')}}</textarea>
                                            </div>

                                        </div>


                                    </div>
                                </div>
                            </div>

                            <center>
                                <button class=" btn btn-primary mb-2 text-center"><i data-feather="{{($action=='Tambah')?'plus':'refresh-cw'}}"></i> {{($action=='Tambah')?'SIMPAN':'UPDATE'}}</button>
                            </center>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

</div>


@endsection

@section('page_script')
<script>
    getKota = (id) => {
        console.log('{{$action}}');
        $("#kota").empty();
        var select = document.getElementById('kota');
        $.ajax({
            url: '/select2/getkota/' + id,
            type: 'GET',
            success: function(result) {
                $.each(result, function(i, item) {
                    var opt = document.createElement('option');
                    opt.value = item['city_id'];
                    opt.innerHTML = item['type'] + ' ' + item['city_name'];
                    select.appendChild(opt);
                });
                if ('{{$action}}' != 'Tambah')
                    $("#kota").val('{{(isset($akun))?$akun->id_city:""}}');
            },
        });
    }

    getKec = (id) => {
        console.log(id);
        $("#kec").empty();
        var select = document.getElementById('kec');
        $.ajax({
            url: '/select2/getkec/' + id,
            type: 'GET',
            success: function(result) {
                $.each(result, function(i, item) {
                    var opt = document.createElement('option');
                    opt.value = item['subdistrict_id'];
                    opt.innerHTML = item['subdistrict_name'];
                    select.appendChild(opt);
                });
                if ('{{$action}}' != 'Tambah')
                    $("#kec").val('{{(isset($akun))?$akun->id_subdistrict:""}}');
            },
        });
    }
    if ('{{$action}}' != 'Tambah') {
        getKota('{{(isset($akun))?$akun->id_province:""}}');
        getKec('{{(isset($akun))?$akun->id_city:""}}');

    }
</script>
@endsection