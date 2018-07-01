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

		<title>กราฟสรุปการซ่อมตามประเภทปัญหา</title>

  </head>

  <body class="sidebar-mini fixed">
    <div class="wrapper">
			<?php include "connect.php"; ?>				<!-- connect database -->
			<?php include "a_header.php"; ?>				<!-- header -->
			<?php include "a_side_nav.php"; ?>				<!-- Side-Nav-->
			<?php include "function.php"; ?>				<!-- function-->

      <div class="content-wrapper">
				<div class="page-title">
          <div>
            <h1><i class="fa fa-pie-chart fa-lg"></i> กราฟแสดงงานซ่อมตามประเภทปัญหา</h1>
          </div>
        </div>
				<?
				$date_start=dateFormatDB($_REQUEST['date_start']);
				$date_end=dateFormatDB($_REQUEST['date_end']);
				$id_problem_type=$_REQUEST['id_problem_type'];

        $query = "SELECT problem_type_name, count(id_device)
        FROM detail_repair
        INNER JOIN problem ON detail_repair.id_problem=problem.id_problem
        INNER JOIN problem_type ON problem.id_problem_type=problem_type.id_problem_type
        INNER JOIN repair ON detail_repair.id_repair=repair.id_repair
        WHERE date_s BETWEEN '$date_start' AND '$date_end'
        group by problem_type_name";
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
                                  <td width="20%" height="32" align="center"><strong>ข้อมูลระหว่างวันที่ :  </strong>
                                   <? echo $_GET[date_start] ."  ถึง  ". $_GET[date_end] ?></td>
                                </tr>
                              </table>

                              <div class="container-fluid" style="padding-top:10px;">
                                  <div id="piechart" style="width: 800px; height: 400px;"></div>
                              </div>


									        	</div>
									        </div>
												</div>
                        <center><a class="btn btn-info icon-btn" href="a_report_typeproblem_process.php?date_start=<? echo $_REQUEST['date_start'];?>&date_end=<? echo $_REQUEST['date_end'];?>&id_problem_type=<? echo $id_problem_type;?>" >ย้อนกลับ</a>


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
                ['problem_type_name', 'id_device'],
                <?php
                while($row=mysql_fetch_array($res))
                {
                  echo "['".$row['problem_type_name']."',".$row['count(id_device)']."],";
                }
                ?>
              ]);
              var options = {
                title: 'กราฟแสดงงานซ่อมตามประเภทปัญหา',
                is3D:true,
              };
              var chart = new google.visualization.PieChart(document.getElementById('piechart'));
              chart.draw(data, options);
            }
          </script>



  </body>
</html>
<?php } ?>
