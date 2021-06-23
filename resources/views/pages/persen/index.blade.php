@extends('layouts.app')

@section('content')
<div class="layout-px-spacing">
    <div class="row layout-top-spacing">
        <div class="col-xl-8 col-lg-8 col-sm-8 user-profile layout-spacing">
            <div class="widget-content widget-content-area br-6 ">
                <div class="d-flex justify-content-between">
                    <h3 class=""> {{$page_name}} </h3>
                    <a href="/dashboard" class="mt-2 edit-profile"> <i data-feather="home"> </i></a>
                </div>
                <div class="table-responsive mb-4 mt-4">


                    <form method="POST" action="/persen" class="form-info" id="form-register" autocomplete="off" enctype='multipart/form-data'>
                        @csrf

                        <div class="row">

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="noHp">Dokter/Marketing (%)</label>
                                    <input type="number" class="form-control mb-4" onkeyup="ubahDokter()" id="dokter" name="dokter" value="{{$data_persen->dokter}}" required>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="noHp">Admin</label>
                                    <input type="text" class="form-control mb-4" id="admin" value="{{$data_persen->admin}}" readonly>
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


<script>
    function ubahDokter() {
        var dokter = document.getElementById("dokter").value;
        document.getElementById("admin").value = 100 - parseInt(dokter);
    }
</script>
@endsection