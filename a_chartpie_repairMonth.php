<?php
	session_start();
	if($_SESSION['user_admin'] == "")
	{
    ?>
    <meta http-equiv='refresh' content='0;URL=index.php?id=login'>
    <?
		//exit();
	}
  else {

?>
<!DOCTYPE html>
<html>
  <head>
		<?php include "a_inc_css.php"; ?>

		<title>กราฟแสดงงานซ่อมแต่ละเดือน</title>

  </head>

  <body class="sidebar-mini fixed">
    <div class="wrapper">
			<?php include "connect.php"; ?>				<!-- connect database -->
			<?php include "a_header.php"; ?>				<!-- header -->
			<?php include "a_side_nav.php"; ?>				<!-- Side-Nav-->
			<?php include "function.php"; ?>				<!-- function-->

      <?php
      function dateToBE1($date){
        list($y,$m,$d)=explode('-',$date);
        if($y!=""){
         $y += 543;
         if($m=='01'){
         $m="มกราคม";
        }
        elseif($m=='02'){
          $m="กุมภาพันธ์";
        }
        elseif($m=='03'){
          $m="มีนาคม";
        }
        elseif($m=='04'){
          $m="เมษายน";
        }
        elseif($m=='05'){
          $m="พฤษภาคม";
        }
        elseif($m=='06'){
          $m="มิถุนายน";
        }
        elseif($m=='07'){
          $m="กรกฎาคม";
        }
        elseif($m=='08'){
          $m="สิงหาคม";
        }
        elseif($m=='09'){
          $m="กันยายน";
        }
        elseif($m=='10'){
          $m="ตุลาคม";
        }
        elseif($m=='11'){
          $m="พฤศจิกายน";
        }
        elseif($m=='12'){
          $m="ธันวาคม";
        }
         return ($d.'-'.$m.'-'.$y);
       }else {
         return ("");
       }
      }

      if($m=='01'){
        $m="มกราคม";
       }
      $date = date("Y");
      $month=$_REQUEST['month'];
      if($month=="มกราคม"){
        $m='01';
      }
      elseif ($month=="กุมภาพันธ์") {
        $m='02';
      }
      elseif ($month=="มีนาคม") {
        $m='03';
      }
      elseif ($month=="เมษายน") {
        $m='04';
      }
      elseif ($month=="พฤษภาคม") {
        $m='05';
      }
      elseif ($month=="มิถุนายน") {
        $m='06';
      }
      elseif ($month=="กรกฎาคม") {
        $m='07';
      }
      elseif ($month=="สิงหาคม") {
        $m='08';
      }
      elseif ($month=="กันยายน") {
        $m='09';
      }
      elseif ($month=="ตุลาคม") {
        $m='10';
      }
      elseif ($month=="พฤศจิกายน") {
        $m='11';
      }
      elseif ($month=="ธันวาคม") {
        $m='12';
      }


      ?>

      <div class="content-wrapper">
				<div class="page-title">
          <div>
            <h1><i class="fa fa-pie-chart fa-lg"></i> กราฟแสดงงานซ่อมแต่ละเดือน</h1>
          </div>
        </div>
				<?
				$date_start=dateFormatDB($_REQUEST['date_start']);
				$date_end=dateFormatDB($_REQUEST['date_end']);
				$id_problem_type=$_REQUEST['id_problem_type'];

        $query= "SELECT date_s, count(id_repair) FROM repair WHERE YEAR(date_s)= $date AND MONTH(date_s)= $m group by date_s";
        $res = mysql_query($query);

        ?>


				<div class="row">
					<div class="col-md-12">
						<div class="card">
			          <div class="bs-component">
									<div class="panel panel-info" >
											<div class="container-fluid" style="padding-top:10px;">
									          <div class="table-responsive">

                              <table width="100%"  class="table table-bordered table-striped table-hover table-condensed">
                                <tr>
                                  <td width="20%" height="32" align="center"><strong>ข้อมูลของเดือน :  </strong>
                                   <? echo $month ?></td>
                                  </tr>
                                </table>

                                <div class="container-fluid" style="padding-top:10px;">
                                    <div id="piechart" style="width: 800px; height: 400px;"></div>
                                </div>

									        	</div>
									        </div>
												</div>
                        <center><a class="btn btn-info icon-btn" href="a_report_repairMonth_process.php?month=<? echo $month;?>" >ย้อนกลับ</a>


					          </div>
									</div>
								</div>
							</div>
		        </div>
					</form>
				</div>
					<?php include"a_inc_js.php";?>

          <script type="text/javascript">
            google.charts.load('current', {'packages':['corechart']});
            google.charts.setOnLoadCallback(drawChart);

            function drawChart() {
              var data = google.visualization.arrayToDataTable([
                ['date_s', 'id_repair'],
                <?php
                while($row=mysql_fetch_array($res))
                {
                  echo "['".dateToBE1($row['date_s'])."',".$row['count(id_repair)']."],";
                }
                ?>
              ]);
              var options = {
                title: 'กราฟแสดงงานซ่อมแต่ละเดือน',
                is3D:true,
              };

              var chart = new google.visualization.PieChart(document.getElementById('piechart'));

              chart.draw(data, options);
            }
          </script>



  </body>
</html>
<?php } ?>
