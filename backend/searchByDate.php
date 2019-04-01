<!DOCTYPE html>
<html>
<head>

<title>Page Title</title>
<link rel="stylesheet" type="text/css" href="bootstrap.css">
<link rel="stylesheet" type="text/css" href="bootstrap-datepicker.min.css">
<script
  src="jquery.js"></script>
  <script src="angular.min.js"></script>
  <script src="bootstrap.js"></script>
  <script src="bootstrap-datepicker.min.js"></script>
</head>

<body ng-app="myApp" ng-controller="myController" style="padding:50px;">

Select Date: <br><input class="form-control" style="width:120px;float:left;" id="date" name="date" placeholder="yyyy-mm-dd" type="text"/> <button ng-click="submitDate()" class="btn btn-success" style="float:left;margin-left:10px;">Submit</button>
<div style="clear:both;"></div>
<br>
<div class="row table-bordered"  style="background:gainsboro;">
	<div class="col-sm-2">Id</div>
	<div class="col-sm-4">Name</div>
	<div class="col-sm-3">Entry</div>
	<div class="col-sm-3">Exit</div>
</div>
<div class="row table-bordered" ng-repeat="item in finalRows">
	<div class="col-sm-2">{{item.id}}</div>
	<div class="col-sm-4">{{item.name}}</div>
	<div class="col-sm-6">
		<div class="row table-bordered" ng-repeat="entry in item.data">
			<div ng-repeat="i in entry" class="col-sm-6">{{i.split(" ")[1]}}</div>
		</div>
	</div>
</div>


  
  <script src="app.js"></script>
  <script>
    $(document).ready(function(){
      var date_input=$('input[name="date"]'); //our date input has the name "date"
      var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
      var options={
        format: 'dd-mm-yyyy',
        container: container,
        todayHighlight: true,
        autoclose: true,
      };
      date_input.datepicker(options);
    })
</script>
  
</body>
</html>