@extends('layouts.app')

@section('content')
<div class="layout-px-spacing">
    <div class="row layout-top-spacing">
        <div class="col-xl-12 col-lg-12 col-sm-12 user-profile layout-spacing">
            <div class="widget-content widget-content-area br-6 ">
                <div class="d-flex justify-content-between">
                    <h3 class=""> {{$page_name}} </h3>
                    <a href="/dashboard" class="mt-2 edit-profile"> <i data-feather="home"> </i></a>
                </div>
                <div class="table-responsive mb-12 mt-12">
                    <form method="POST" action="{{($action==='Tambah')?'/broadcast':'/broadcast/'.$broadcast->id}}" class="form-info" id="form-register" autocomplete="off" enctype='multipart/form-data'>
                        @if($action=='Edit')
                        @method('PUT')
                        @endif
                        @csrf
                        <div class="row">
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <label for="noHp">Pesan</label>
                                    <textarea type="text" class="form-control mb-4" name="pesan" rows="5" required>{{(isset($broadcast))?$broadcast->isi:(old('pesan')??'')}}</textarea>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="upload mt-4 pr-md-4">
                                        <input type="file" id="input-file-max-fs" class="dropify" name="file" data-default-file="{{(isset($gangguan->gambar))?asset('uploads/'.$gangguan->gambar):asset('assets/img/1280x857.jpg')}}" data-max-file-size="2M" />
                                        <p class="mt-2"><i class="flaticon-cloud-upload mr-1"></i> Upload Foto</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="noHp">Batas broadcast</label>
                                    <input type="date" class="form-control mb-4" name="batas" value="{{(isset($broadcast))?$broadcast->batas:(old('batas')??'')}}" required></input>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="no_hp">Pilih Tujuan</label>
                                    <select class="pembayaran js-states form-control" id="metode" name="jenis" required>
                                        <option value="0" {{(isset($broadcast))?(($broadcast->jenis==0)?'selected':''):''}}>Semua</option>
                                        <option value="1" {{(isset($broadcast))?(($broadcast->jenis==1)?'selected':''):''}}>Faskes & Nakes</option>
                                        <option value="2" {{(isset($broadcast))?(($broadcast->jenis==2)?'selected':''):''}}>User</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="noHp">#</label><br>
                                    <button class=" btn btn-primary mb-2 text-center"><i data-feather="send"></i> {{($action=='Tambah')?'SEND':'UPDATE'}}</button>
                                </div>
                            </div>
                        </div>
                        <center>
                        </center>
                    </form>


                </div>
            </div>
        </div>
    </div>

</div>

</div>


<script>

</script>
@endsection