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
                <div class="table-responsive mb-4 mt-4">
                    <form method="POST" action="/lainnya" class="form-info" id="form-register" autocomplete="off" enctype='multipart/form-data'>
                        @csrf
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="noHp">Tanya Jawab Umum</label>
                                    <textarea id="summernote" type="text" class="form-control mb-4" name="tanya_jawab" rows="10" required>{{(isset($lainnya))?$lainnya->tanya_jawab:(old('pesan')??'')}}</textarea>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="noHp">Syarat dan Ketentuan</label>
                                    <textarea id="summernote2" type="text" class="form-control mb-4" name="syarat" rows="10" required>{{(isset($lainnya))?$lainnya->syarat:(old('pesan')??'')}}</textarea>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="noHp">#</label><br>
                                    <button class=" btn btn-primary mb-2 text-center"><i data-feather="refresh-cw"></i> UPDATE</button>
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


@section('page_script')
<!-- include summernote css/js -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>

<script>
    $(document).ready(function() {
        $('#summernote').summernote({
            placeholder: 'Tanya Jawab Umum',
            tabsize: 2,
            height: 200
        });
    });
    $(document).ready(function() {
        $('#summernote2').summernote({
            placeholder: 'Syarat dan Ketentuan',
            tabsize: 2,
            height: 200
        });
    });
</script>
@endsection
@endsection