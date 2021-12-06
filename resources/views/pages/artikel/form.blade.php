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
                    <form method="POST" action="{{($action==='Tambah')?'/artikel':'/artikel/'.$artikel->id}}" class="form-info" id="form-register" autocomplete="off" enctype='multipart/form-data'>
                        @if($action=='Edit')
                        @method('PUT')
                        @endif
                        @csrf
                        <div class="row">
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <label for="noHp">Judul</label>
                                    <input type="text" class="form-control mb-4" name="judul" required value="{{(isset($artikel))?$artikel->judul:(old('judul')??'')}}"></input>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <label for="noHp">Isi</label>
                                    <textarea id="summernote" type="text" class="form-control mb-4" name="isi" rows="10" required>{{(isset($artikel))?$artikel->isi:(old('isi')??'')}}</textarea>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="upload mt-4 pr-md-4">
                                        <input type="file" id="input-file-max-fs" class="dropify" name="file" data-default-file="{{(isset($artikel->foto))?asset('antri_aja/public/uploads/'.$artikel->foto):asset('assets/img/1280x857.jpg')}}" data-max-file-size="2M" />
                                        <p class="mt-2"><i class="flaticon-cloud-upload mr-1"></i> Upload Foto</p>
                                    </div>
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

@endsection


@section('page_script')
<!-- include summernote css/js -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>

<script>
    $(document).ready(function() {
        $('#summernote').summernote({
            placeholder: 'Isi Artikel',
            tabsize: 2,
            height: 200
        });
    });
</script>
@endsection