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
            $scope.info = true;
            $scope.jam_ = data['dJam']+' - '+data['sJam'];
            console.log(data)
        };
        $scope.kembali = function() {
            $scope.info = false;
           
        };
        $scope.submit = function() {
            console.log($scope.note)
           
        };
    }
    
]);
