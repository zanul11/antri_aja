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
                    <form method="POST" action="/broadcast" class="form-info" id="form-register" autocomplete="off" enctype='multipart/form-data'>
                        @csrf
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="noHp">Pesan</label>
                                    <textarea type="text" class="form-control mb-4" name="pesan" rows="5" required></textarea>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="noHp">Batas broadcast</label>
                                    <input type="date" class="form-control mb-4" name="batas" required></input>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="no_hp">Pilih Tujuan</label>
                                    <select class="pembayaran js-states form-control" id="metode" name="jenis" required>
                                        <option value="0">Semua</option>
                                        <option value="1">Faskes & Nakes</option>
                                        <option value="2">User</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="noHp">#</label><br>
                                    <button class=" btn btn-primary mb-2 text-center"><i data-feather="send"></i> SEND</button>
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