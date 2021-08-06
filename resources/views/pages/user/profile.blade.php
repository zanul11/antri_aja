@extends('layouts.app')

@section('content')

<div class="layout-px-spacing">

    <div class="account-settings-container layout-top-spacing">

        <div class="account-content">
            <div class="scrollspy-example" data-spy="scroll" data-target="#account-settings-scroll" data-offset="-100">
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing ">
                        <div class="section general-info">


                            <div class="info ">
                                <h6 class="">Informasi Diri</h6>
                                <form method="POST" action="/profile/{{$profile->id}}" class="form-info" id="form-register" autocomplete="off" enctype='multipart/form-data'>
                                    @method('PUT')
                                    @csrf
                                    <div class="row">
                                        <div class="col-lg-11 mx-auto">
                                            <div class="row">
                                                <div class="col-xl-2 col-lg-12 col-md-4">
                                                    <div class="upload mt-4 pr-md-4">
                                                        <input type="file" id="input-file-max-fs" class="dropify" name="file" data-default-file="{{(isset($profile->foto))?asset('uploads/'.$profile->foto):asset('assets/img/200x200.jpg')}}" data-max-file-size="2M" />
                                                        <p class="mt-2"><i class="flaticon-cloud-upload mr-1"></i> Upload Foto</p>
                                                    </div>
                                                </div>
                                                <div class="col-xl-10 col-lg-12 col-md-8 mt-md-0 mt-4">
                                                    <div class="form">
                                                        <div class="row">
                                                            @if($profile->role!=4)
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label for="nikDr">Username</label>
                                                                    <input type="text" class="form-control mb-4" id="nikDr" name="username" value="{{$profile->username}}" required>
                                                                </div>
                                                            </div>
                                                            @endif
                                                            @if($profile->role==5)
                                                            <input type="hidden" name="email" value="{{$profile->email}}">

                                                            @endif
                                                            <div class="{{($profile->role!=4)?'col-sm-6':'col-sm-12'}}">
                                                                <div class="form-group">
                                                                    <label for="fullName">Nama</label>
                                                                    <input type="text" class="form-control mb-4" id="fullName" name="nama" placeholder="Nama Lengkap" value="{{$profile->name}}" required>
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label for="noHp">Email</label>
                                                                    <input type="email" class="form-control mb-4" id="noHp" name="email" value="{{$profile->email}}" required {{(Auth::user()->role==5)?'disabled':''}}>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label for="noHp">No Hp/Telpon</label>
                                                                    <input type="text" class="form-control mb-4" id="noHp" name="no_hp" placeholder="no Hp" value="{{$profile->no_hp}}" required>
                                                                </div>
                                                            </div>

                                                        </div>
                                                        @if($profile->role!=4)
                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label for="">Spesialis</label>
                                                                    <select class="placeholder js-states form-control" name="spesialis" required>
                                                                        @foreach($data_spesialis as $dt)
                                                                        <option value="{{$dt->id}}" {{($profile->spesialis==$dt->id)?'selected':''}}>{{$dt->spesialis}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label for="noHp">Pengalaman</label>
                                                                    <input type="number" class="form-control mb-4" id="noHp" name="pengalaman" value="{{$profile->pengalaman}}">
                                                                </div>
                                                            </div>

                                                            @if($profile->role==3)
                                                            <div class="col-sm-3">
                                                                <div class="form-group">
                                                                    <label for="noHp">Kode Faskes</label>
                                                                    <input type="text" class="form-control mb-4" name="kode_faskes" value="{{$profile->kode_faskes}}">
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-5">
                                                                <div class="form-group">
                                                                    <label for="noHp">Nama Faskes</label>
                                                                    <input type="text" class="form-control mb-4" name="nama_faskes" value="{{$profile->nama_faskes}}">
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <div class="form-group">
                                                                    <label for="noHp">Telp. Faskes</label>
                                                                    <input type="text" class="form-control mb-4" name="tlp_faskes" value="{{$profile->tlp_faskes}}">
                                                                </div>
                                                            </div>
                                                            @endif

                                                        </div>
                                                        @endif

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>
                    @if($profile->role!=4)
                    <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                        <div class="section general-info">
                            <div class="info">
                                <h5 class="">About</h5>
                                <div class="row">
                                    <div class="col-md-11 mx-auto">
                                        <div class="form-group">
                                            <label for="aboutBio">Deskripsi Diri</label>
                                            <textarea class="form-control" id="aboutBio" name="deskripsi" placeholder="Tell something interesting about yourself" rows="5">{{$profile->deskripsi}}</textarea>
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

                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="no_hp">Tulis Nama Tempat</label>
                                                            <input type="text" class="form-control mb-4" id="almt" placeholder="Cari Tempat Disini!" onkeydown="clearTimer()" onkeyup="doneTyping()">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12 form-group mb-3v ">
                                                        <div id="map-container" style="width:100%;height:200px;z-index:1"></div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="alamat">Alamat Detail Praktek</label>
                                                            <textarea class="form-control" placeholder="Alamat" name="alamat" rows="10">{{$profile->alamat}}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <input type="hidden" name="latlong" id="longlat" value="{{(isset($profile))?$profile->latlong:(old('latlong')??'')}}">
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    <!-- <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">

                        <div class="info">
                            <h5 class="">Ubah Password</h5>
                            <div class="row">
                                <div class="col-md-6 mx-auto">
                                    <div class="row">

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="address">Password Lama</label>
                                                <input type="text" class="form-control mb-4" id="address" name="old_password" placeholder="Password Lama">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="location">Password Baru</label>
                                                <input type="text" class="form-control mb-4" id="location" name="new_password" placeholder="Password Baru">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="phone">Konfirmasi Password Baru</label>
                                                <input type="text" class="form-control mb-4" id="phone" name="konfirmasi_password" placeholder="Password Baru">
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div> -->

                    <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                        <div class="section general-info">
                            <div class="info">
                                <h5 class="">Sosial Media</h5>
                                <div class="row">

                                    <div class="col-md-11 mx-auto">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="input-group social-linkedin mb-3">
                                                    <div class="input-group-prepend mr-3">
                                                        <span class="input-group-text" id="tweet">
                                                            <i data-feather="instagram"></i></span>
                                                    </div>
                                                    <input type="text" class="form-control" placeholder="Instagram Username" name="ig" aria-label="Username" aria-describedby="linkedin" value="{{$profile->ig}}">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="input-group social-tweet mb-3">
                                                    <div class="input-group-prepend mr-3">
                                                        <span class="input-group-text" id="tweet"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-twitter">
                                                                <path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"></path>
                                                            </svg></span>
                                                    </div>
                                                    <input type="text" class="form-control" placeholder="Twitter Username" name="fb" aria-label="Username" aria-describedby="tweet" value="{{$profile->twitter}}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-11 mx-auto">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="input-group social-fb mb-3">
                                                    <div class="input-group-prepend mr-3">
                                                        <span class="input-group-text" id="fb"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-facebook">
                                                                <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path>
                                                            </svg></span>
                                                    </div>
                                                    <input type="text" class="form-control" placeholder="Facebook Username" name="twitter" aria-label="Username" aria-describedby="fb" value="{{$profile->fb}}">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="input-group social-github mb-3">
                                                    <div class="input-group-prepend mr-3">
                                                        <span class="input-group-text" id="github">
                                                            <i data-feather="youtube"></i>
                                                        </span>
                                                    </div>
                                                    <input type="text" class="form-control" placeholder="Youtube Channel" name="youtube" aria-label="Username" aria-describedby="github" value="{{$profile->youtube}}">
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

        <div class="account-settings-footer">

            <div class="as-footer-container">

                <!-- <button id="multiple-reset" class="btn btn-primary">Reset All</button>
                <div class="blockui-growl-message">
                    <i class="flaticon-double-check"></i>&nbsp; Settings Saved Successfully
                </div> -->

                <button type="submit" class="btn btn-primary">Save Changes</button>

            </div>

        </div>
    </div>
    </form>
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
    var markerHandle = "<?php echo (isset($profile) ? $profile->latlong : '') ?>";

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