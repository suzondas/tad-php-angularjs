angular.module("myApp", ['ngRoute', 'ngAnimate'])
    .config(['$routeProvider', '$locationProvider',
        function ($routeProvider, $locationProvider) {
            $routeProvider
                .when('/newEntry', {
                    templateUrl: 'frontend/template/newEntry.html',
                    controller: 'myController',
                    controllerAs: 'myController'
                })
                .when('/searchUser', {
                    templateUrl: 'frontend/template/searchUser.html',
                    controller: 'userController',
                    controllerAs: 'userController'
                })
                .when('/reports', {
                    templateUrl: 'frontend/template/report.html',
                    controller: 'reportController',
                    controllerAs: 'reportController'
                });

            $locationProvider.html5Mode(true);

        }]).controller("myController", function ($scope) {
    $scope.checkForm = function (data) {
        console.log(data);
        var result = true;
        for (var i in data) {
            console.log(data[i]);
            if (data[i] === '') {
                result = false;
                break;
            }
        }
        console.log(result);
        return result;
    };

    //adding new user
    $scope.newUser = {};
    $scope.newUser.id = '';
    $scope.newUser.name = '';
    $scope.newUser.membership = '';

    $scope.addNewUser = function () {
        if (!$scope.checkForm($scope.newUser)) {
            alert("Fill all fields");
            return;
        }
        var submitDate = new FormData();
        submitDate.append("id", $scope.newUser.id);
        submitDate.append("name", $scope.newUser.name);
        submitDate.append("membership", $scope.newUser.membership);
        $.ajax({
            url: 'backend/add.php', // point to server-side PHP script
            dataType: 'text', // what to expect back from the PHP script, if anything
            cache: false,
            contentType: false,
            processData: false,
            data: submitDate,
            type: 'post',
            success: function (data) {
                var output = JSON.parse(data);
                if (output.Row.Result == 1) {
                    alert("Data Saved");
                    window.location.reload('../');
                } else {
                    alert("Something went wrong. Try Again");
                }
            },
            error: function (err) {
                alert('Something went wrong. Try Again!')
            }
        });
    };


}).controller("userController", function ($scope) {
    $scope.searchingAllUser = true;

    $.ajax({
        url: 'backend/users.php', // point to server-side PHP script
        dataType: 'json', // what to expect back from the PHP script, if anything
        cache: false,
        contentType: false,
        processData: false,
        data: '',
        type: 'post',
        success: function (data) {
            $scope.items = data.Row;
            $scope.$apply();

            $("#usersTabld").DataTable();
            $("#usersTabld_filter").find('label').find('input').attr('placeholder', 'ID, Name, Membership');
            $scope.searchingAllUser = false;

        },
        error: function (err) {
            alert('Something went wrong. Try Again!');
            $scope.searchingAllUser = false;
        }
    });
}).controller("reportController", function ($scope) {
    $scope.loading = false;
    $scope.label = "No Report Type Selected!";

    $scope.totalMembers = 0;


    $scope.addInMember = function () {
        $scope.inMembers += 1;
    };

    $.ajax({
        url: 'backend/users.php', // point to server-side PHP script
        dataType: 'json', // what to expect back from the PHP script, if anything
        cache: false,
        contentType: false,
        processData: false,
        data: '',
        type: 'post',
        success: function (data) {
            $scope.items = data.Row;
            $scope.$apply();

            $("#usersTabld").DataTable();
            $("#usersTabld_filter").find('label').find('input').attr('placeholder', 'ID, Name, Membership');
        },
        error: function (err) {
            alert('Something went wrong. Try Again!')

        }
    });


    $scope.finalRows = [];

    $scope.staticReport = function (param) {
        $scope.loading = true;

        $scope.label = param.toUpperCase() + ' report type selected';
        $scope.finalRows = [];


        var submitDate = new FormData();

        if (param === 'specific') {
            var date = $("#specificDate").val();

            if (date === '') {
                alert("No date selected!");
                $scope.loading = false;
                return;
            }

            var newdate = date.split("/").reverse().join("-");
            submitDate.append("date", param);
            submitDate.append("specific", newdate);
        } else {
            submitDate.append("date", param);
        }

        $.ajax({
            url: 'backend/get.php', // point to server-side PHP script
            dataType: 'json', // what to expect back from the PHP script, if anything
            cache: false,
            contentType: false,
            processData: false,
            data: submitDate,
            type: 'post',
            success: function (data) {

                if (data.Row) {
                    if (!Array.isArray(data.Row)) {
                        var tmp = data.Row;
                        data.Row = [];
                        data.Row.push(tmp);
                    }
                    setTimeout(function () {
                        $scope.$apply(function () {
                            var rows = data.Row;
                            var pinList = [];
                            for (var i = 0; i < rows.length; i++) {
                                pinList.push(rows[i].PIN);
                            }

                            function onlyUnique(value, index, self) {
                                return self.indexOf(value) === index;
                            }

                            var finalPinList = pinList.filter(onlyUnique);

                            var countInMember = 0;
                            for (var i = 0; i < finalPinList.length; i++) {
                                var name = '';
                                var arr = [];
                                for (var j = 0; j < rows.length; j++) {
                                    if (finalPinList[i] === rows[j].PIN) {
                                        arr.push(rows[j].DateTime);
                                        name = rows[j].Name;
                                    }
                                }

                                if(arr.length%2!==0){
                                    countInMember+=1;
                                }

                                function chunkArray(myArray, chunk_size) {
                                    var index = 0;
                                    var arrayLength = myArray.length;
                                    var tempArray = [];

                                    for (index = 0; index < arrayLength; index += chunk_size) {
                                        myChunk = myArray.slice(index, index + chunk_size);
                                        // Do something if you want with the group
                                        tempArray.push(myChunk);
                                    }
                                    return tempArray;
                                }

                                var result = chunkArray(arr, 2);
                                console.log(result);
                                $scope.finalRows.push({id: finalPinList[i], name: name, data: result});
                            }
                            $scope.totalMembers = $scope.finalRows.length;
                            $scope.inMembers = countInMember;
                            $scope.outMembers = $scope.totalMembers - $scope.inMembers;
                        });
                    }, 500);
                }
                $scope.loading = false;
            },
            error: function (err) {
                alert('Something went wrong. Try Again!')
                $scope.loading = false;
            }
        });
    }

});
