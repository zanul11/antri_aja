@extends('layouts.app')

@section('content')
<div class="layout-px-spacing">

    <div class="row layout-top-spacing">

        <div class="col-xl-12 col-lg-12 col-sm-12 user-profile layout-spacing">

            <div class="widget-content widget-content-area br-6 ">
                <div class="d-flex justify-content-between">
                    <h3 class=""> {{$page_name}} / {{$category_name}} </h3>
                    <a href="{{url('/faskes')}}" class="mt-2  text-danger layout-spacing"><i data-feather="x"></i></a>
                </div>
                <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                    <form id="contact" class="section contact layout-spacing" method="POST" action="{{($action==='Tambah')?'/faskes':'/faskes/'.$dokter->id}}">
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
                                        <!-- <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="country">NIK</label>
                                                <input oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="16" type="number" class="form-control mb-4" name="nik" id="nik" placeholder="Nik user" value="{{(isset($dokter))?$dokter->nik:(old('nik')??'')}}" required {{($action=='Edit')?'readonly':''}}>
                                            </div>
                                        </div> -->
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="nama">Nama</label>
                                                <input type="text" class="form-control mb-4" name="nama" id="nama" placeholder="Nama user" value="{{(isset($dokter))?$dokter->name:(old('nama')??'')}}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="email">Email</label>
                                                <input type="email" class="form-control mb-4" name="email" id="email" placeholder="Email user" value="{{(isset($dokter))?$dokter->email:(old('email')??'')}}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="password">Password</label>
                                                <input type="text" class="form-control mb-4" name="password" id="password" placeholder="{{($action=='Edit')?'Cant show':'Write your password'}}" {{($action=='Tambah')?'required':''}}>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="no_hp">No Hp</label>
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
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="pengalaman">Pengalaman</label>
                                                <input type="number" class="form-control mb-4" name="pengalaman" id="pengalaman" placeholder="Dalam tahun" value="{{(isset($dokter))?$dokter->pengalaman:(old('pengalaman')??'')}}">
                                            </div>
                                        </div> -->
                                        <input type="hidden" name="pengalaman" value="{{(isset($dokter))?$dokter->pengalaman:(old('pengalaman')??'')}}">
                                        <input type="hidden" name="spesialis" value="{{$data_spesialis[0]->id}}">
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
                                                <textarea class="form-control" placeholder="Alamat" name="alamat" rows="5">{{(isset($dokter))?$dokter->alamat:(old('alamat')??'')}}</textarea>
                                            </div>

                                        </div>
                                        <div class="col-lg-12 row">
                                            <!-- <div class="col-lg-8">

                                                <div class="col-md-12">
                                                    @if($action==='Tambah')
                                                    <div class="form-group">
                                                        <label for="no_hp">Tulis Nama Tempat</label>
                                                        <input type="text" class="form-control mb-4" id="almt" placeholder="Cari Tempat Disini!" onkeydown="clearTimer()" onkeyup="doneTyping()">
                                                    </div>
                                                    @endif
                                                </div>

                                                <div class="col-md-12 form-group mb-3v " style="{{($action!='Tambah')?'margin-top:50px':''}}">
                                                    <div id="map-container" style="width:100%;height:200px;z-index:1"></div>
                                                </div>
                                            </div> -->

                                        </div>

                                        <!-- <div class="col-md-12">
                                            <div class="form-group">
                                                <input type="hidden" name="latlong" id="longlat" value="{{(isset($dokter))?$dokter->latlong:(old('latlong')??'')}}">
                                            </div>
                                        </div> -->



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

<script>

</script>

@endsection


<!-- <script src="{{asset('assets/leaflet/leaflet.js')}}"></script> -->
<!-- <script src="{{asset('assets/leaflet/draw/leaflet.draw.js')}}"></script> -->
<!-- <script>
    var typingTimer; //timer identifier
    var doneTypingInterval = 2000; // 3sec
    function clearTimer() {
        clearTimeout(typingTimer);
    }

    function doneTyping() {
        clearTimeout(typingTimer);
        typingTimer = setTimeout(setCoordinate, doneTypingInterval);
    }

    var map;
    var areaOverlays = [];
    var markerHandle = "<?php echo (isset($dokter) ? $dokter->latlong : '') ?>";

    initMap();

    function initMap() {
        map = L.map('map-container').setView([-8.591367, 116.097428], 15);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        var editableLayers = new L.FeatureGroup();
        map.addLayer(editableLayers);

        var options = {
            position: 'topright',
            draw: {
                polygon: false,
                circle: false,
                rectangle: false,
                circlemarker: false,
                polyline: false,
                marker: true
            },
            edit: {
                featureGroup: editableLayers, //REQUIRED!!
                remove: true,
                edit: false
            }
        };
        var drawControl = new L.Control.Draw(options);
        map.addControl(drawControl);

        map.on("draw:drawstart", function(e) {

            if (e.layerType == "marker") {
                editableLayers.eachLayer(function(layer) {
                    if (layer instanceof L.Marker) {
                        editableLayers.removeLayer(layer);
                    }
                });

            } else {
                editableLayers.eachLayer(function(layer) {
                    if (layer instanceof L.Polygon) {
                        editableLayers.removeLayer(layer);
                    }
                });
            }


        });

        map.on(L.Draw.Event.CREATED, function(e) {

            editableLayers.addLayer(e.layer);
            // console.log(e);
            if (e.layerType == "marker") {
                coord = e.layer._latlng;
                newPath = [coord.lat, coord.lng];
                console.log(e.layer);

                JSONString = JSON.stringify(newPath);
                $("#longlat").val(JSONString);

            } else {
                coord = e.layer._latlngs[0];
                newPath = [];
                // Now iterate through all the polylines and draw them on the map.
                for (var i = 0; i < coord.length; i++) {
                    newPath.push([coord[i].lat, coord[i].lng]);
                }
                JSONString = JSON.stringify(newPath);
                $("#area").val(JSONString);
            }

        });

        <?php if ($action == 'Edit') { ?>
            displayMarker(editableLayers);
        <?php } ?>

    }

    function displayMarker(Layer) {
        if (markerHandle == "") {
            return;
        }

        longlat = JSON.parse(markerHandle);

        var marker = new L.Marker(longlat);
        Layer.addLayer(marker);
        map.flyTo(longlat);
    }


    function setCoordinate() {
        var alamat = $("#almt").val();
        $.get("https://nominatim.openstreetmap.org/?format=json&polygon_geojson=1&q=" + alamat + "&state=Nusa Tenggara Barat&country=Indonesia&limit=1")
            .done(function(data) {
                console.log(data);
                position = [data[0].lat, data[0].lon];
                map.setView(position, 13);

            });

    }
</script> -->