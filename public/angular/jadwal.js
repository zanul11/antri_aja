app = angular.module("app", []);

app.controller("JadwalController", [
    "$scope",
    "$http",
    "$filter",
    function JadwalController($scope, $http, $filter) {
        $scope.jadwals = [];
        $scope.dJam = null;
        $scope.sJam = null;
        $scope.estimasi = 0;
        $scope.hari =  [
            { hari: "Pilih Hari", value : null},
            { hari: "Senin", value : 1},
            { hari: "Selasa", value : 2 },
            { hari: "Rabu", value : 3 },
            { hari: "Kamis", value : 4 },
            { hari: "Jumat", value : 5 },
            { hari: "Sabtu", value : 6 },
            { hari: "Minggu", value : 0 }
          ];

          $http({
            method: "GET",
            url: "/jadwal/getData"
        }).then(res => {
            angular.forEach(res.data, function(dt) {
                console.log(dt);
                $scope.jadwals.push({
                    hari:'-',
                    value: dt['hari'],
                    dJam: $filter('date')(dt['dJam'], 'HH:mm') ,
                    sJam: $filter('date')(dt['sJam'], 'HH:mm') ,
                    estimasi : dt['estimasi'],
                    kuota : dt['kuota']
                });
            });
            // $scope.kwitansi = res.data;
          
        });
          
          $scope.selectedHari = $scope.hari[0];

        $scope.insertTabel = function() {

            if($scope.selectedHari.value==null){
                Swal.fire(
                    "Warning!",
                    "Pilih Hari!",
                    "warning"
                );
            }else{
                if($scope.dJam==null||$scope.sJam==null){
                    Swal.fire(
                        "Warning!",
                        "Field Jam Kosong!",
                        "warning"
                    );
                }
                else if($scope.estimasi==0){
                    Swal.fire(
                        "Warning!",
                        "Field Estimasi 0!",
                        "warning"
                    );
                }
                else {
                    $http({
                        url: "/jadwal",
                        method: "POST",
                        data: {
                            hari: $scope.selectedHari.hari,
                            value: $scope.selectedHari.value,
                            dJam: $filter('date')($scope.dJam, 'HH:mm:ss') ,
                            sJam: $filter('date')($scope.sJam, 'HH:mm:ss'),
                            estimasi: $scope.estimasi,
                            kuota : (($scope.sJam-$scope.dJam)/60000)/$scope.estimasi
                        }
                    }).then(function(res){
                        $scope.jadwals.push({
                            hari: $scope.selectedHari.hari,
                            value: $scope.selectedHari.value,
                            dJam: $filter('date')($scope.dJam, 'HH:mm:ss') ,
                            sJam: $filter('date')($scope.sJam, 'HH:mm:ss'),
                            estimasi: $scope.estimasi,
                            kuota : (($scope.sJam-$scope.dJam)/60000)/$scope.estimasi
                        });
                        $scope.dJam = null;
                        $scope.sJam = null;
                        $scope.selectedHari = $scope.hari[0];
                        $scope.estimasi = 0;
                    });
                    
                }
            }
            // }
        
        };

        $scope.removeItem = function(obj) {
            for(var i = $scope.jadwals.length - 1; i >= 0; i--){
                if($scope.jadwals[i].value == obj['value'] && $scope.jadwals[i].dJam == obj['dJam'] && $scope.jadwals[i].sJam == obj['sJam']){
                    $scope.jadwals.splice(i,1);
                    $http({
                        url: "/jadwal/delete",
                        method: "POST",
                        data: {
                            hari: obj['hari'],
                            value: obj['value'],
                            dJam: $filter('date')(obj['dJam'], 'HH:mm:ss') ,
                            sJam: $filter('date')(obj['sJam'], 'HH:mm:ss'),
                        }
                    }).then(function(res){
                        // console.log(obj);
                    });
                }
            }
            // console.log(obj);
            // var index  =$scope.jadwals.;
            // console.log(index);
            // $scope.jadwals.splice(index, 1);
        };

        $scope.submitData = function() {
            
            swal({
                title: 'Success!',
                text: 's',
                type: 'success',
                padding: '2em'
              });
            console.log($scope.dJam)
        };
    }
]);
