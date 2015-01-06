<!doctype html>
<html lang="en">

<head>
  <?php include 'header.php'; ?>
  <?php include 'modals.php'; ?>

    <style>
    input[type="text"] { height: 30px; }
        body{	padding-top: 60px;max-height:100%; overflow:hidden;}
        .container-fluid{padding-right:0px;} /*makes map stretch all the way to the right side */
        iframe {width:100%;height:100%;	position: absolute; }
        .scrollable{overflow-y: scroll;height:350px;}
        .fuck{position:right;}
  </style>

  <script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.3.0-beta.13/angular.min.js"></script>
  <script type="text/javascript" src="http://www.google.com/jsapi"></script>
  <script>
    var formApp = angular.module('formApp', []);

    function formController($scope, $http) {
      $scope.activitiesDoor = [
        { name: 'ski', selected: false },
        { name: 'bike', selected: false },
        { name: 'hike', selected: false },
        { name: 'golf', selected: false },
        { name: 'art', selected: false },
        { name: 'prosport', selected: false },
        { name: 'beach', selected: false },
        { name: 'gamble', selected: false },
        { name: 'family', selected: false },
        { name: 'night', selected: false }
      ];

      $scope.formData = [];
      
      // watch activitiesDoor for changes
      $scope.$watch('activitiesDoor|filter:{selected:true}', function (nv) {
        $scope.formData = nv.map(function (activity) {
          return activity.name
        });
      }, true);

      $scope.processForm = function processForm() {
        $http({
        method  : 'POST',
        url     : 'triposal-test/ajax2.php',
        data    : { 'activitiesDoor': $scope.formData }
        })
          .success(function(data) {
            console.log(data);
            if (!data.success) {
              $scope.errorName == "Request failed";
            }
            else {
              $scope.message = data.message;
            }
          });
      };
    }
  </script>

</head>

<body ng-app="formApp">
  <div ng-controller="formController">
    <div class="container-fluid">
      <div class="row-fluid">
        <div class="span3">
          <div class="well sidebar-nav scrollable">
            <form ng-submit="processForm()">
              <h4>Activities/Environment</h4>
              <label ng-repeat="activity in activitiesDoor" class="checkbox-inline">
                <input type="checkbox" name="activitiesDoor[]" value="{{activityName}}" ng-model="activity.selected"> {{activity.name}}
              </label>
                  <button type="submit" class="btn btn-success btn-lg btn-block">
      <span class="glyphicon glyphicon-flash"></span> Submit!
    </button>
            </form>
            </div>
          </div>
        </div>
      </div>
      <pre>{{formData|json}}</pre>
    </div>
</body>

<footer class="footer">
  <?php include 'footer.php'; ?>
</footer>

</html>