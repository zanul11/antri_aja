app = angular.module("app", []);

app.controller("JadwalController", [
    "$scope",
    "$http",
    function JadwalController($scope, $http) {
        $scope.jadwals = [];
        $scope.dJam = null;
        $scope.sJam = null;
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
                }else {
                    console.log($scope.dJam);
                    $scope.jadwals.push({
                        hari: $scope.selectedHari.hari,
                        value: $scope.selectedHari.value,
                        dJam: $scope.dJam,
                        sJam: $scope.sJam,
                    });
                    $scope.dJam = null;
                    $scope.sJam = null;
                    $scope.selectedHari = $scope.hari[0];
                }
            }
            // }
        
        };

        $scope.removeItem = function(index) {
            $scope.jadwals.splice(index, 1);
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
