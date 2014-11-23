<div class="col-xs-12 col-sm-6 col-md-8">
  <h2>Weekly visits</h2>
  <div class="panel panel-default">
    <div class="panel-body">
      <canvas id="weekly" height="40" width="100" style="padding-right: 30px;"></canvas>
      <script>
        var weeklyData = {
            labels: ["January", "February", "March", "April", "May", "June", "July"],
            datasets: [
                {
                    label: "My First dataset",
                    fillColor: "rgba(220,220,220,0.2)",
                    strokeColor: "rgba(220,220,220,1)",
                    pointColor: "rgba(220,220,220,1)",
                    pointStrokeColor: "#fff",
                    pointHighlightFill: "#fff",
                    pointHighlightStroke: "rgba(220,220,220,1)",
                    data: [65, 59, 80, 81, 56, 55, 40]
                }
            ]

        }
      </script>
    </div>
  </div>
  <h2>Users platform </h2>
  <div class="panel panel-default">
    <div class="panel-body">
      <div class="canvas-holder-half">
        <canvas id="platform" height="40" width="50" style="padding-right: 30px;"></canvas>
        <script>
          var platformData = [
              {
                  value: 300,
                  color:"#F7464A",
                  highlight: "#FF5A5E",
                  label: "Windows"
              },
              {
                  value: 50,
                  color: "#46BFBD",
                  highlight: "#5AD3D1",
                  label: "Android"
              },
              {
                  value: 100,
                  color: "#FDB45C",
                  highlight: "#FFC870",
                  label: "Linux"
              }
          ]
        </script>
      </div>
      <div class="canvas-holder-half">
        <canvas id="browser" height="40" width="50" style="padding-right: 30px;"></canvas>
        <script>
          var browserData = [
              {
                  value: 300,
                  color:"#F7464A",
                  highlight: "#FF5A5E",
                  label: "Windows"
              },
              {
                  value: 50,
                  color: "#46BFBD",
                  highlight: "#5AD3D1",
                  label: "Android"
              },
              {
                  value: 100,
                  color: "#FDB45C",
                  highlight: "#FFC870",
                  label: "Linux"
              }
          ]
        </script>
      </div>
      <script>
        window.onload = function(){
            var ctx_line = document.getElementById("weekly").getContext("2d");
            window.myLine = new Chart(ctx_line).Line(weeklyData, {
                responsive: true
            });
            var ctx_pie_i = document.getElementById("platform").getContext("2d");
            window.myPie = new Chart(ctx_pie_i).Pie(platformData, {
                responsive: true
            });
            var ctx_pie_ii = document.getElementById("browser").getContext("2d");
            window.myPie = new Chart(ctx_pie_ii).Pie(browserData, {
                responsive: true
            });
        }
      </script>
    </div>
  </div>
  <h2>Refering sites & Popular content</h2>
  <div class="panel panel-default">
    <div class="panel-body">
      <h3>Refering sites</h3>
      <table class="table table-bordered">
        <tr>
          <td>Site</td>
          <td>Views</td>
          <td>Unique visitors</td>
        </tr>
        <tr>
          <td>google.cz</td>
          <td>40</td>
          <td>7</td>
        </tr>
        <tr>
          <td>idnes.cz</td>
          <td>400</td>
          <td>70</td>
        </tr>
        <tr>
          <td>vutbr.cz</td>
          <td>4000</td>
          <td>700</td>
        </tr>
      </table>
      <h3>Popular content</h3>
      <table class="table table-bordered">
        <tr>
          <td>Content</td>
          <td>Views</td>
          <td>Unique visitors</td>
        </tr>
        <tr>
          <td>index.html</td>
          <td>40</td>
          <td>7</td>
        </tr>
        <tr>
          <td>school-stuff.html</td>
          <td>400</td>
          <td>70</td>
        </tr>
        <tr>
          <td>idontknow.html</td>
          <td>4000</td>
          <td>700</td>
        </tr>
      </table>
    </div>
  </div>
</div>
