@extends('layouts.app')

@section('content')
<div class="layout-px-spacing">

    <div class="row layout-top-spacing">

        <div class="col-lg-12 col-12 layout-spacing">
            <div class="statbox widget box box-shadow">
                <div class="widget-header">
                    <div class="row">
                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                            <h4>Informasi Pesanan</h4>
                        </div>
                    </div>
                </div>
                <div class="widget-content widget-content-area">
                    <div class="alert alert-warning mb-4 col-sm-12" role="alert">
                        <h3 class="text-center">NO ANTRIAN : {{$antri->no_antrian}}</h3>
                    </div>
                    <div class="col-xl-12 col-lg-12 col-md-8 mt-md-0 mt-4">
                        <div class="form">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="fullName">Nama Dokter</label>
                                        <input type="text" class="form-control mb-4" id="fullName" name="nama" placeholder="Nama Lengkap" value="{{$antri->dokter_detail->name}}" readonly>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="noHp">No Hp/Email Dokter</label>
                                        <input type="email" class="form-control mb-4" id="noHp" name="email" value="{{$antri->dokter_detail->no_hp}}/{{$antri->dokter_detail->email}}" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="">Spesialis</label>
                                        <select class="placeholder js-states form-control" name="spesialis" readonly>
                                            @foreach($data_spesialis as $dt)
                                            <option value="{{$dt->id}}" {{($antri->dokter_detail->spesialis==$dt->id)?'selected':''}}>{{$dt->spesialis}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="noHp">Pengalaman</label>
                                        <input type="number" class="form-control mb-4" id="noHp" name="pengalaman" value="{{$antri->dokter_detail->pengalaman}}" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="noHp">Tanggal</label>
                                        <input type="email" class="form-control mb-4" id="noHp" name="email" value="{{$antri->tgl}}" disabled>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="noHp">Jam</label>
                                        <input type="text" class="form-control mb-4" value="{{$antri->waktu_detail->dJam}} - {{$antri->waktu_detail->sJam}}" id="noHp" name="no_hp" placeholder="no Hp" readonly>
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="noHp">Catatan untuk Dokter</label>
                                        <textarea class="form-control" rows="2" autofocus ng-model="note" readonly>{{$antri->catatan}}</textarea>
                                    </div>
                                </div>


                            </div>

                        </div>
                    </div>

                </div>

            </div>

        </div>

        <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
            <div class="section general-info">
                <div class="info">
                    <h5 class="">Alamat Praktek</h5>
                    <div class="row">
                        <div class="col-md-11 mx-auto">
                            <div class="platform-div">
                                <div class="col-lg-12 row">
                                    <div class="col-lg-8">
                                        <div class="col-md-12 form-group mb-3v ">
                                            <div id="map-container" style="width:100%;height:200px;z-index:1"></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="alamat">Alamat Detail Praktek</label>
                                                <textarea class="form-control" placeholder="Alamat" name="alamat" rows="6">{{$antri->dokter_detail->alamat}}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>

</div>


<script src="{{asset('assets/leaflet/leaflet.js')}}"></script>
<script src="{{asset('assets/leaflet/draw/leaflet.draw.js')}}"></script>
<script>
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
    var markerHandle = "<?php echo (isset($antri) ? $antri->dokter_detail->latlong : '') ?>";

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


        displayMarker(editableLayers);


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
</script>
@endsection