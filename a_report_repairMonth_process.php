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

		<title>รายงานสรุปงานซ่อมของแต่ละเดือน</title>

  </head>

  <body class="sidebar-mini fixed">
    <div class="wrapper">
			<?php include "connect.php"; ?>				<!-- connect database -->
			<?php include "a_header.php"; ?>				<!-- header -->
			<?php include "a_side_nav.php"; ?>				<!-- Side-Nav-->
			<?php include "function.php"; ?>				<!-- function-->

			<?
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
            <h1><i class="fa fa-bar-chart fa-lg"></i>รายงานสรุปงานซ่อมของแต่ละเดือน</h1>
          </div>
        </div>
				<?
				$date_start=dateFormatDB($_REQUEST['date_start']);
				$date_end=dateFormatDB($_REQUEST['date_end']);
				$id_problem_type=$_REQUEST['id_problem_type']; ?>

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
			                             <? echo $_GET[month] ?></td>
			                            </tr>
			                          </table>
			                          <table width="100%"  class="table table-bordered table-striped table-hover table-condensed">
																	<tr>
 		                               <td width="1%" height="32" align="center"><strong>ลำดับ</strong></td>
 		                               <td width="7%" height="32" align="center"><strong>รหัสการซ่อม</strong></td>
 		                               <td width="7%" height="32" align="center"><strong>ชื่อผู้แจ้ง</strong></td>
 		                               <td width="7%" height="32" align="center"><strong>วันที่แจ้งซ่อม</strong></td>
 		                               <td width="7%" height="32" align="center"><strong>ชื่ออุปกรณ์</strong></td>
 		                               <td width="7%" height="32" align="center"><strong>ปัญหา</strong></td>
 		                               <td width="7%" height="32" align="center"><strong>ประเภทอุปกรณ์</strong></td>
 		                               <td width="7%" height="32" align="center"><strong>สถานะการซ่อม</strong></td>
 		                             </tr>

			                            <?php
																	$sql="SELECT *
			                                    FROM REPAIR INNER JOIN detail_repair ON repair.id_repair = detail_repair.id_repair
			                                    INNER JOIN STATUS ON detail_repair.id_status = status.id_status
			                                    INNER JOIN device ON detail_repair.id_device = device.id_device
			                                    INNER JOIN device_type ON device.id_device_type = device_type.id_device_type
			                                    WHERE MONTH(date_s ) = $m AND YEAR(date_s)=$date";

			                            $result = mysql_query($sql);
			                            $num1=mysql_num_rows($result);

																	$i = 1;
			                            while($objResult =mysql_fetch_array($result)){
			                             ?>
			                              <tr>
																			<td align="center"><?php echo $i; ?></td>
				                              <td align="center"><?php echo $objResult[id_detail]; ?></td>
				                              <td align="center"><?php echo $objResult[user_display]; ?></td>
				                              <td align="center"><?php echo dateToBE($objResult[date_s]); ?></td>
				                              <td align="center"><?php echo $objResult[device_name]; ?></td>
				                              <td align="center"><?php echo $objResult[problem]; ?></td>
				                              <td align="center"><?php echo $objResult[device_type_name]; ?></td>
				                              <td align="center"><?php echo $objResult[status_name]; ?></td>
			                            <? $i+=1; }?>

			                          </table>
									        	</div>
									        </div>
												</div>
												<center><a class="btn btn-info" href="a_print_repairMonth.php?month=<? echo $month;?>" target="_blank">รายงาน</a>
												<a class="btn btn-success" href="a_chartpie_repairMonth.php?month=<? echo $month;?>" >กราฟ</a></center>

					          </div>
									</div>
								</div>
							</div>
		        </div>
					</form>
				</div>
					<?php include"a_inc_js.php";?>
					<?php
					if($num1<=0){ ?>
						<script>
							 setTimeout(function() {
									 swal({
											 title: "ไม่พบข้อมูลที่ต้องการ!!",
											 text: "คลิกปุ่ม \"OK\" เพื่อรับทราบ",
											 type: "warning",
											 confirmButtonText: "OK"
									 }, function() {
											 window.location = "a_report_repairMonth.php";
									 }, 1000);
							 });
					 </script>
				 <? }?>

  </body>
</html>
<?php } ?>
