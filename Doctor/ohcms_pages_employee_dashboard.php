<?php
session_start();
include('assets/configs/config.php');
include('assets/configs/checklogin.php');
check_login();
$aid = $_SESSION['em_id'];
?>
<!DOCTYPE html>
<html lang="en">
<!--Header-->
<?php include('includes/header.php'); ?>
<!--End Header-->

<body>
  <div class="be-wrapper be-fixed-sidebar">
    <!--Navigation bar-->
    <?php include("includes/navbar.php"); ?>
    <!--Navigation-->

    <!--Sidebar-->
    <?php include("includes/sidebar.php"); ?>
    <!--Sidebar-->
    <div class="be-content">
      <div class="main-content container-fluid">
        <div class="row">
          <div class="col-12 col-lg-6 col-xl-3">
            <?php
            //code for getting all inpatients ever admitted the hospital
            $result = "SELECT count(*) FROM patients where p_type='Isolation Patient' ";
            $stmt = $mysqli->prepare($result);
            $stmt->execute();
            $stmt->bind_result($isolated);
            $stmt->fetch();
            $stmt->close();
            ?>
            <div class="widget widget-tile" style="background-color: #74c365; width: 300px; ">
              <div class="chart sparkline">
              <i class="material-icons" style="float: center;  opacity: 0.5;  font-size: 5rem; ">people_alt</i> 
              </div>
                <div class="data-info">
                 <div class="desc" style="color: white; font-weight: bold; font-size: 23px;">Isolated Patients</div>
                  <div class="value"> <span class="number" data-toggle="counter" data-end="<?php echo $isolated; ?>" style="color: white; font-weight: bold; font-size: 50px"><?php echo $isolated; ?></span>
               </div>
              </div>
            </div>
          </div>
          <div class="col-12 col-lg-6 col-xl-3">
            <?php
            //code for getting all inpatients ever admitted the hospital
            $result = "SELECT count(*) FROM patients where p_type='InPatient' ";
            $stmt = $mysqli->prepare($result);
            $stmt->execute();
            $stmt->bind_result($inpatients);
            $stmt->fetch();
            $stmt->close();
            ?>
            <div class="widget widget-tile" style="background-color: #3271A5; width: 300px;">
              <div class="chart sparkline"><i class="material-icons"style="float: center;  opacity: 0.5;  font-size: 5rem; ">airline_seat_flat</i></div>
              <div class="data-info">
                <div class="desc" style="color: white; font-weight: bold; font-size: 23px;">InPatients</div>
                <div class="value"><span class="number" data-toggle="counter" data-end="<?php echo $inpatients; ?>"style="color: white; font-weight: bold; font-size: 50px;"><?php echo $inpatients; ?></span>
                </div>
              </div>
            </div>
          </div>
          <div class="col-12 col-lg-6 col-xl-3">
            <?php
            //code for getting all outpatients ever visited the hospital
            $result = "SELECT count(*) FROM patients where p_type='OutPatient'";
            $stmt = $mysqli->prepare($result);
            $stmt->execute();
            $stmt->bind_result($outpatients);
            $stmt->fetch();
            $stmt->close();
            ?>
            <div class="widget widget-tile" style="background-color: #C24641;  width: 300px;">
              <div class="chart sparkline"><i class="large material-icons"style="float: center;  opacity: 0.5;  font-size: 5rem; ">accessible</i></div>
              <div class="data-info">
                <div class="desc"style="color: white; font-weight: bold; font-size:23px;">OutPatients</div>
                <div class="value"><span class="number" data-toggle="counter" data-end="<?php echo $outpatients; ?>"style="color: white; font-weight: bold; font-size:50px;"><?php echo $outpatients; ?></span>
                </div>
              </div>
            </div>
          </div>
          <div class="col-12 col-lg-6 col-xl-3">
            <?php
            //code for getting all number of pharmaceuticals 
            $result = "SELECT count(*) FROM assets where department ='Laboratory' ";
            $stmt = $mysqli->prepare($result);
            $stmt->execute();
            $stmt->bind_result($pharmaceuticals);
            $stmt->fetch();
            $stmt->close();
            ?>
            <div class="widget widget-tile" style="background-color: #FA9C1B;  width: 288px;">
              <div class="chart sparkline"><i class="large material-icons" style="float: center;  opacity: 0.5;  font-size: 5rem; ">add_shopping_cart</i></div>
              <div class="data-info">
                <div class="desc" style="color: white; font-weight: bold; font-size:20px;">Med Equipment</div>
                <div class="value"><span class="number" data-toggle="counter" data-end="<?php echo $pharmaceuticals; ?>"style="color: white; font-weight: bold; font-size: 50px;"><?php echo $pharmaceuticals; ?></span>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12 col-lg-12">
            <div class="widget be-loading">

              <div class="widget-chart-container">
                <div id="chartContainer" style="height: 295px; width: 100%;"></div>

                <!--Wackass Javascript But It Aint Shit-->
                <script>
                  window.onload = function() {

                    var chart = new CanvasJS.Chart("chartContainer", {
                      exportEnabled: true,
                      animationEnabled: true,
                      title: {
                        text: "Percentage Patient Numbers By Categories"
                      },
                      legend: {
                        cursor: "pointer",
                        itemclick: explodePie
                      },
                      data: [{
                        type: "pie",
                        showInLegend: true,
                        toolTipContent: "{name}: <strong>{y}%</strong>",
                        indexLabel: "{name} - {y}%",
                        dataPoints: [
                          //Data Populated from database and represented by the pie chart from patients records

                          {
                            y: <?php
                                //code for getting all inpatients 
                                $result = "SELECT count(*)  FROM patients where p_type = 'InPatient'";
                                $stmt = $mysqli->prepare($result);
                                $stmt->execute();
                                $stmt->bind_result($in);
                                $stmt->fetch();
                                $stmt->close(); ?>
                            <?php echo $in; ?>,
                            name: "In Patients",
                            exploded: true
                          },

                          {
                            y
                            <?php
                            //code for getting all inpatients 
                            $result = "SELECT count(*)  FROM patients where p_type = 'OutPatient'  ";
                            $stmt = $mysqli->prepare($result);
                            $stmt->execute();
                            $stmt->bind_result($out);
                            $stmt->fetch();
                            $stmt->close(); ?>: <?php echo $out; ?>,
                            name: "Out Patients"
                          },

                          {
                            y
                            <?php
                            //code for getting all inpatients 
                            $result = "SELECT count(*)  FROM patients where p_type = 'Isolation Patient '  ";
                            $stmt = $mysqli->prepare($result);
                            $stmt->execute();
                            $stmt->bind_result($isolation);
                            $stmt->fetch();
                            $stmt->close(); ?>: <?php echo $isolation; ?>,
                            name: "Isolation Ward Patients"
                          }


                        ]
                      }]
                    });
                    chart.render();
                  }

                  function explodePie(e) {
                    if (typeof(e.dataSeries.dataPoints[e.dataPointIndex].exploded) === "undefined" || !e.dataSeries.dataPoints[e.dataPointIndex].exploded) {
                      e.dataSeries.dataPoints[e.dataPointIndex].exploded = true;
                    } else {
                      e.dataSeries.dataPoints[e.dataPointIndex].exploded = false;
                    }
                    e.chart.render();

                  }
                </script>
              </div>

            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12 col-lg-6">
            <div class="card card-table">
              <div class="card-header">
                <div class="title">Laboratory Equipments</div>
              </div>
              <div class="card-body table-responsive">
                <table class="table table-striped ">
                  <thead>
                    <tr>
                      <th style="width:40%;">Name</th>
                      <th style="width:40%;">Department</th>
                      <th style="width:20%;">Status</th>
                    </tr>
                  </thead>
                  <?php

                  $ret = "SELECT * FROM assets where department ='Laboratory' ORDER BY RAND() LIMIT 100  ";
                  $stmt = $mysqli->prepare($ret);
                  //$stmt->bind_param('i',$aid);
                  $stmt->execute(); //ok
                  $res = $stmt->get_result();
                  $cnt = 1;
                  while ($row = $res->fetch_object()) {
                  ?>
                    <tbody class="no-border-x">
                      <tr>
                        <td class="text-success"><?php echo $row->name; ?></td>
                        <td><?php echo $row->department; ?></td>
                        <td><?php echo $row->status; ?></td>
                      </tr>
                    </tbody>
                  <?php } ?>

                </table>
              </div>
            </div>
          </div>

          <div class="col-12 col-lg-6">
            <div class="card card-table">
              <div class="card-header">
                <div class="title">Latest Patients Records</div>
              </div>
              <div class="card-body table-responsive">
                <table class="table table-striped table-hover">
                  <thead>
                    <tr>
                      <th style="width:37%;">Name</th>
                      <th style="width:36%;">Category</th>
                      <th>Date Added</th>
                    </tr>
                  </thead>
                  <?php

                  $ret = "SELECT * FROM patients ORDER BY RAND() LIMIT 100  ";
                  $stmt = $mysqli->prepare($ret);
                  //$stmt->bind_param('i',$aid);
                  $stmt->execute(); //ok
                  $res = $stmt->get_result();
                  $cnt = 1;
                  while ($row = $res->fetch_object()) {
                  ?>
                    <tbody>
                      <tr>
                        <td><?php echo $row->p_fname; ?> <?php echo $row->p_lname; ?></td>
                        <td><?php echo $row->p_type; ?></td>
                        <td><?php echo $row->created_at; ?></td>
                      </tr>
                    </tbody>
                  <?php $cnt = $cnt + 1;
                  } ?>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
  <script src="assets/lib/jquery/jquery.min.js" type="text/javascript"></script>
  <script src="assets/lib/perfect-scrollbar/js/perfect-scrollbar.min.js" type="text/javascript"></script>
  <script src="assets/lib/bootstrap/dist/js/bootstrap.bundle.min.js" type="text/javascript"></script>
  <script src="assets/js/app.js" type="text/javascript"></script>
  <script src="assets/lib/jquery-flot/jquery.flot.js" type="text/javascript"></script>
  <script src="assets/lib/jquery-flot/jquery.flot.pie.js" type="text/javascript"></script>
  <script src="assets/lib/jquery-flot/jquery.flot.time.js" type="text/javascript"></script>
  <script src="assets/lib/jquery-flot/jquery.flot.resize.js" type="text/javascript"></script>
  <script src="assets/lib/jquery-flot/plugins/jquery.flot.orderBars.js" type="text/javascript"></script>
  <script src="assets/lib/jquery-flot/plugins/curvedLines.js" type="text/javascript"></script>
  <script src="assets/lib/jquery-flot/plugins/jquery.flot.tooltip.js" type="text/javascript"></script>
  <script src="assets/lib/jquery.sparkline/jquery.sparkline.min.js" type="text/javascript"></script>
  <script src="assets/lib/countup/countUp.min.js" type="text/javascript"></script>
  <script src="assets/lib/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
  <script src="assets/lib/canvas/canvasjs.min.js"></script>
  <script src="assets/lib/canvas/jquery.canvasjs.min.js"></script>
  <script type="text/javascript">
    $(document).ready(function() {
      //-initialize the javascript
      App.init();
      App.dashboard();

    });
  </script>
</body>

</html>