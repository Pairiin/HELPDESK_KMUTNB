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
	<title>รายงานสรุปความพึงพอใจในแต่ละเดือน</title>
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

			<form action="a_satisfaction_process.php" method="GET">
      <div class="content-wrapper">
				<div class="page-title">
					<div>
						<h1>
							<i class="fa fa-bar-chart fa-lg"></i>รายงานสรุปความพึงพอใจในแต่ละเดือน</h1>
					</div>
				</div>
        <?
        $month = array('มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม');

        $sql_question = "SELECT *
                      FROM question
                      ORDER BY id_question ASC";
        $obj_question = mysql_query($sql_question) or die ("Error Query [".$sql_question."]");
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
    						                <td width="20%"><strong>เดือน :</strong></td>
    						                <td width="30%">
    						                  <select name="month" class="form-control" id="month" type="hidden" style="width:300px">
    						                    <option value=""><-- กรุณาเลือก --></option>
                                    <?php

                                    $i = 0;
                                    while ($i < count($month)) {
                                       $a = $month[$i];
                                       echo "<option value='$a'>$a</option>";
                                       $i++;
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
