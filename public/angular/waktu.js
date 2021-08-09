app = angular.module("app", []);

app.controller("WaktuController", [
    "$scope",
    "$http",
    "$filter",
    function WaktuController($scope, $http, $filter) {
        $scope.tgl = null;
        $scope.jam = '';
        $scope.info = false;
        $scope.note = '';
        $scope.nama_pasien = null;
        $scope.umur_pasien = null;
        $scope.jumlahAntrian = 0;
        $scope.init = function(dokter)
        {
            $scope.dokter = dokter;
        }
        $scope.onChange = function() {
            $scope.jam = [];
            const date = new Date($scope.tgl+' 10:27:14 AM')
            $http({
                method: "POST",
                url: "/antri/getJam",
                data:{
                    dokter:$scope.dokter,
                    hari:date.getDay()
                }
            }).then(res => {
                if(res.data.length!=0){
                    angular.forEach(res.data, function(dt) {
                        $scope.jam.push({
                            id : dt['id'],
                            value: dt['hari'],
                            dJam: $filter('date')(dt['dJam'], 'HH:mm') ,
                            sJam: $filter('date')(dt['sJam'], 'HH:mm') ,
                            kuota: dt['kuota']
                        });
                    });
                }else {
                    Swal.fire(
                        "Warning!",
                        "Jadwal tidak tersedia!",
                        "warning"
                    );
                }
                console.log($scope.jam);
            });
            // console.info(date.getDay());
            // console.info(date.toTimeString());
            // console.info(date.toUTCString());
        };

        $scope.selectJam = function(data) {
            console.log(data);
            $http({
                url: "/antri/getJum",
                method: "POST",
                data: {
                    dokter: $scope.dokter,
                    jam : data['id'],
                    tgl : $scope.tgl 
                }
            }).then(function(res){
                if(data['kuota']>res.data){
                    $scope.jumlahAntrian = res.data;
                    $scope.info = true;
                    $scope.jam_ = data['dJam']+' - '+data['sJam'];
                    $scope.selectedJam = data;
                }else {
                    Swal.fire(
                        "Warning!",
                        "Kuota Penuh Pada Jadwal Tersebut!",
                        "warning"
                    );
                }
                
                
            });
            
            // console.log(data)
        };

        $scope.kembali = function() {
            $scope.info = false;
        };
        $scope.submit = function() {
            if($scope.nama_pasien==null||$scope.nama_pasien==undefined||$scope.nama_pasien==''){
                Swal.fire(
                    "Warning!",
                    "Input nama pasien untuk dokter!",
                    "warning"
                );
            }
            else if($scope.umur_pasien==null||$scope.umur_pasien==undefined||$scope.umur_pasien==0){
                Swal.fire(
                    "Warning!",
                    "Input umur pasien untuk dokter!",
                    "warning"
                );
            }
            else if($scope.note==null||$scope.note==undefined||$scope.note==''){
                Swal.fire(
                    "Warning!",
                    "Input catatan untuk dokter!",
                    "warning"
                );
            }else {
                $http({
                    url: "/antri",
                    method: "POST",
                    data: {
                        dokter: $scope.dokter,
                        jam : $scope.selectedJam,
                        catatan : $scope.note,
                        tgl : $scope.tgl,
                        pasien : $scope.nama_pasien,
                        umur : $scope.umur_pasien 
                    }
                }).then(function(res){
                    console.log(res);
                  Swal.fire(
                    "Success",
                    "Berhasil daftar antrian!",
                    "success"
                    ).then(result => {
                        window.location='/antri';
                    });
                });
                
            }
        };
    }
    
]);
