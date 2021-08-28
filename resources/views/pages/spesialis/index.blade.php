@extends('layouts.app')

@section('content')
<div class="layout-px-spacing">
    <div class="row layout-top-spacing">
        <div class="col-xl-8 col-lg-8 col-sm-8 user-profile layout-spacing">
            <div class="widget-content widget-content-area br-6 ">
                <div class="d-flex justify-content-between">
                    <h3 class=""> {{$page_name}} </h3>
                    <a href="#" onclick="showModal()" class="mt-2 edit-profile"> <i data-feather="plus" class="text-defaulr"> </i></a>
                </div>
                <div class="table-responsive mb-4 mt-4">
                    <table id="zero-config" class="table table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Spesialisasi</th>
                                <th class="no-content"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data_spesialis as $dt)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$dt->spesialis}}</td>
                                <td>
                                    <a href="#" onclick="showModalsEdit('{{$dt->id}}', '{{$dt->spesialis}}')"><i data-feather="edit-2" class="text-warning"></i></a>
                                    <a href="#" onclick="deleteData('/spesialis','{{$dt->id}}')"><i data-feather="trash" class="text-danger"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
            </div>
        </div>

    </div>

    <div class="modal fade" id="addSepesialis" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Data Spesialisasi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <form class="form-info" id="myForm" novalidate enctype="multipart/form-data" method="post" action="/spesialis" autocomplete="off">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="modal-body">

                                <div class="col-lg-12">
                                    <label> Nama Spesialisasi </label>
                                    <input type="text" name="spesialis" id="spesialis" class="form-control" required></input>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="javascript:;" class="btn btn-white" data-dismiss="modal">Close</a>
                        <button type="submit" class="btn btn-primary" id="btn-submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editSpesialis" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Data Spesialis</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <form class="form-info" id="editForm" novalidate enctype="multipart/form-data" method="post" action="/spesialis" autocomplete="off">
                    @method('PUT')
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="modal-body">

                                <div class="col-lg-12">
                                    <label> Nama Spesialis </label>
                                    <input type="text" name="spesialis_edit" id="spesialis_edit" class="form-control" required></input>
                                </div>
                            </div>
                            <input type="hidden" name="id_spesialis" id="id_spesialis"></input>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="javascript:;" class="btn btn-white" data-dismiss="modal">Close</a>
                        <button type="submit" class="btn btn-primary" id="btn-submit">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


</div>

<script>
    function showModal() {
        $('#addSepesialis').modal({
            backdrop: 'static',
            keyboard: false
        });
        // $('#spesialis').focus();
    }

    function showModalsEdit(id, spesialis) {
        document.getElementById("id_spesialis").value = id;
        document.getElementById("spesialis_edit").value = spesialis;
        document.getElementById('editForm').action = "/spesialis/" + id;
        $('#editSpesialis').modal({
            backdrop: 'static',
            keyboard: false
        });
    }
</script>

@endsection