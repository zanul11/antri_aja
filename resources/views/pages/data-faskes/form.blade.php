@extends('layouts.app')

@section('content')
<div class="layout-px-spacing">

    <div class="row layout-top-spacing">

        <div class="col-xl-12 col-lg-12 col-sm-12 user-profile layout-spacing">

            <div class="widget-content widget-content-area br-6 ">
                <div class="d-flex justify-content-between">
                    <h3 class=""> {{$page_name}} / {{$category_name}} </h3>
                    <a href="{{url('/data-faskes')}}" class="mt-2  text-danger layout-spacing"><i data-feather="x"></i></a>
                </div>
                <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">

                    <form id="contact" class="section contact layout-spacing" method="POST" action="{{($action==='Tambah')?'/data-faskes':'/data-faskes/'.$dokter->id}}">
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
                                                <label for="nama">Nama (Kepala/Owner)</label>
                                                <input type="text" class="form-control mb-4" name="nama" id="nama" placeholder="Nama user" value="{{(isset($dokter))?$dokter->name:(old('nama')??'')}}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="email">Email </label>
                                                <input type="email" class="form-control mb-4" name="email" id="email" placeholder="Email user" value="{{(isset($dokter))?$dokter->email:(old('email')??'')}}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="password">Password</label>
                                                <input type="text" class="form-control mb-4" name="password" id="password" value="{{(isset($dokter))?$dokter->password_show:(old('password')??'')}}" placeholder="{{($action=='Edit')?'Cant show':'Write your password'}}" {{($action=='Tambah')?'required':''}}>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="no_hp">No Hp (Kepala/Owner)</label>
                                                <input type="number" class="form-control mb-4" name="no_hp" id="no_hp" placeholder="No Hp user" value="{{(isset($dokter))?$dokter->no_hp:(old('no_hp')??'')}}" required>
                                            </div>
                                        </div>

                                        <!-- <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="no_hp">Spesialisasi</label>
                                                <select class="placeholder js-states form-control" name="spesialis" required>
                                                    @foreach($data_spesialis as $dt)
                                                    <option value="{{$dt->id}}" {{($action!='Tambah')?(($dokter->spesialis==$dt->id)?'selected':''):''}}>{{$dt->spesialis}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div> -->
                                        <input type="hidden" name="pengalaman" value="{{(isset($dokter))?$dokter->pengalaman:(old('pengalaman')??'')}}">
                                        <input type="hidden" name="spesialis" value="{{$data_spesialis[0]->id}}">

                                        <!-- <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="pengalaman">Pengalaman</label>
                                                <input type="hidden" class="form-control mb-4" name="pengalaman" id="pengalaman" placeholder="Dalam tahun" value="{{(isset($dokter))?$dokter->pengalaman:(old('pengalaman')??'')}}">
                                            </div>
                                        </div> -->
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="nama">Kode Faskes</label>
                                                <input type="text" class="form-control mb-4" name="kode_faskes" placeholder="Kode Faskes" value="{{(isset($dokter))?$dokter->kode_faskes:(old('kode_faskes')??'')}}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="nama">Nama Faskes</label>
                                                <input type="text" class="form-control mb-4" name="nama_faskes" placeholder="Nama Faskes" value="{{(isset($dokter))?$dokter->nama_faskes:(old('nama_faskes')??'')}}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="email">Telepon Faskes</label>
                                                <input type="text" class="form-control mb-4" name="tlp_faskes" placeholder="Telepon Faskes" value="{{(isset($dokter))?$dokter->tlp_faskes:(old('tlp_faskes')??'')}}" required>
                                            </div>
                                        </div>

                                        <div class="col-lg-8">

                                            <div class="form-group">
                                                <label for="alamat">Deskripsi Faskes</label>
                                                <textarea class="form-control" placeholder="Deskripsi" name="deskripsi" rows="2">{{(isset($dokter))?$dokter->deskripsi:(old('deskripsi')??'')}}</textarea>
                                            </div>

                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="no_hp">Provinsi</label>
                                                <select class="provinsi js-states form-control" id="provinsi" name="province" onchange="getKota(this.value)" required>
                                                    <option value="">Pilih Provinsi</option>
                                                    @foreach($data_provinsi as $dt)
                                                    <option value="{{$dt->province_id}}" {{($action!='Tambah')?(($dokter->id_province==$dt->province_id)?'selected':''):''}}>{{$dt->province}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="no_hp">Kabupaten/Kota</label>
                                                <select class="kota js-states form-control" name="kota" id="kota" onchange="getKec(this.value)" required>

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

                                        <div class="col-lg-8">

                                            <div class="form-group">
                                                <label for="alamat">Alamat Detail Praktek</label>
                                                <textarea class="form-control" placeholder="Alamat" name="alamat" rows="5">{{(isset($dokter))?$dokter->alamat:(old('alamat')??'')}}</textarea>
                                            </div>

                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="potongan">Potongan Penanganan Pasien</label>
                                                <input type="number" class="form-control mb-4" name="potongan" placeholder="Telepon Faskes" value="{{(isset($dokter))?$dokter->potongan:(old('potongan')??'2000')}}" required>
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