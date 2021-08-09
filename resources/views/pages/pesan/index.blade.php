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
                    <form method="POST" action="/pesan" class="form-info" id="form-register" autocomplete="off" enctype='multipart/form-data'>
                        @csrf
                        <div class="row">
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <label for="noHp">Pesan</label>
                                    <textarea type="text" class="form-control mb-4" name="pesan" rows="3">{{(isset($data_pesan))?$data_pesan->pesan:''}}</textarea>
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

</script>
@endsection