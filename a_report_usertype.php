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
		$user=$_SESSION['user_admin'];
?>
<!DOCTYPE html>
<html>
<head>
	<title>รายงานสรุปการแจ้งซ่อมตามประเภทผู้ใช้</title>
	<?php include "a_inc_css.php"; ?>
	<?php include "a_inc_js.php"; ?>

	<script>
			$(document).ready(function () {
					$('#datepicker1').datepicker({
							format: 'dd/mm/yyyy',
							todayBtn: true,
							language: 'th', //เปลี่ยน label ต่างของ ปฏิทิน ให้เป็น ภาษาไทย   (ต้องใช้ไฟล์ bootstrap-datepicker.th.min.js นี้ด้วย)
							thaiyear: true //Set เป็นปี พ.ศ.
					}).datepicker("setDate", "0"); //กำหนดเป็นวันปัจุบัน


					$('#datepicker2').datepicker({
							format: 'dd/mm/yyyy',
							todayBtn: true,
							language: 'th', //เปลี่ยน label ต่างของ ปฏิทิน ให้เป็น ภาษาไทย   (ต้องใช้ไฟล์ bootstrap-datepicker.th.min.js นี้ด้วย)
							thaiyear: true //Set เป็นปี พ.ศ.
					}).datepicker("setDate", "0");
			});
	</script>
</head>

  <body class="sidebar-mini fixed">
    <div class="wrapper">
			<?php include "connect.php"; ?>				<!-- connect database -->
			<?php include "a_header.php"; ?>				<!-- header -->
			<?php include "a_side_nav.php"; ?>				<!-- Side-Nav-->
			<?php include "function.php"; ?>				<!-- function-->

			<form action="a_report_usertype_process.php" method="GET">
      <div class="content-wrapper">
				<div class="page-title">
					<div>
						<h1>
							<i class="fa fa-bar-chart fa-lg"></i>รายงานสรุปการแจ้งซ่อมตามประเภทผู้ใช้</h1>
					</div>
				</div>
				<?php
				$sql_status = "SELECT *
											FROM user_status
											ORDER BY id_user_status ASC";
				$obj_status = mysql_query($sql_status) or die ("Error Query [".$sql_status."]");
				?>
				<div class="row">
					<div class="col-md-12">
						<div class="card">

		          <div class="bs-component">
								<div class="panel panel-info" >
										<div class="container-fluid" style="padding-top:10px;">
								          <strong>กรุณาเลือกรายการที่ต้องการ </strong>
								          <br><br>
								          <div class="table-responsive">
															<table class="table table-striped">
								              <tr>
								                <td><strong>ข้อมูลวันที่ :</strong></td>
								                <td colspan="2">
								                    <div class="input-group date">
								                        <input type="text" name="date_start" class="datepicker form-control" id="datepicker1" data-date-format="dd/mm/yyyy" style="width:200px">
								                    </div>
								                </td>
								                <td><strong>ถึง:</strong></td>
								                <td colspan="2">
								                    <div class="input-group date">
								                        <input type="text" name="date_end" class="datepicker form-control" id="datepicker2" data-date-format="dd/mm/yyyy" style="width:200px">
								                    </div>
								                </td>
								              </tr>
															<tr>
								                <td ><strong>สถานะ :</strong></td>
								                <td colspan="5">
								                  <select name="id_user_status" class="form-control" id="id_status" type="hidden" style="width:300px">
								                    <option value=""><-- กรุณาเลือก --></option>
								                      <?php
								                      while($result_status= mysql_fetch_array($obj_status))
								                      {
								                      ?>
								                      <option value="<?php echo $result_status["id_user_status"];?>"><?php echo $result_status["name_user_status"];?></option>
								                      <?php
								                      }
								                      ?>
								                  </select>
								                </td>
								            </tr>
								          </table>
								        </div>
								        </div>
											</div>
									<center><button type="submit" class="btn btn-success btn-sm">ค้นหารายงาน</button></center>
			          </div>
							</div>
						</div>
					</div>
	        </div>
				</form>
			</div>

  </body>
</html>

<?php } ?>
