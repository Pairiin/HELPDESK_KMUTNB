<?php session_start();?>
<!DOCTYPE html>
<html>
<head>
    <title>Help Desk KMUTNB</title>
	  <?php include"inc_css.php";?>
</head>

<style>
	th {
		background-color: #d9edf7;
	}

	.modal {
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    padding-top: 60px;
}

/* Modal Content/Box */
.modal-content {
    background-color: #fefefe; /*color block*/
    margin: 5% auto 15% auto; /* 5% from the top, 15% from the bottom and centered */
    border: 1px solid #888;
    width: 40%; /* Could be more or less, depending on screen size */
}
</style>

<body style="background-color:#E0EEEE">
	<?php
	include"connect.php";
	include"header.php";
	include"function.php";
	?>

	<!-- modal login -->
  <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h3 class="modal-title">Login</h3>
        </div>
        <form action="login_process.php" method="post">
          <div class="modal-body">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username" placeholder="Enter username"  style="height:40px;margin:8px 0px;" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" style="height:40px;margin:8px 0px;">
            </div>
          </div>
          <div class="modal-footer">
              <input type="submit" class="btn btn-info" value="Login" />
              <button class="btn btn-danger" data-dismiss="modal">Close</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!--close modal login -->

    <div class="container" style="padding-top:10px;">

       <div class="row">
				 <div class="col-md-12">
					   <div class="card">
					     <h3 class="card-title">ปัญหาที่เกิดขึ้นบ่อยและแนวทางการแก้ปัญหา (FAQ : Frequency Asked Questions)</h3>

							 <li style="font-size: 18px;">ปัญหาที่เกิดขึ้นบ่อย 5 อันดับแรก</li><br>
					     <?php
							 $i=1;
							 $strSQL = "SELECT dr.id_problem,p.problem_name,p.solution_problem,COUNT(dr.id_problem) as count_problem
													FROM detail_repair dr
													INNER JOIN problem p ON dr.id_problem=p.id_problem
													GROUP BY dr.id_problem
													ORDER BY count_problem DESC LIMIT 0,5";

							 $objQuery = mysql_query($strSQL) or die ("Error Query [".$strSQL."]");
							 echo '<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">';
							 while ($objResult = mysql_fetch_array($objQuery)) {
									?>

									  <div class="panel panel-default">
									    <div class="panel-heading" role="tab" id="heading<?=$i?>">
									      <h4 class="panel-title">
									        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?=$i?>" aria-expanded="false" aria-controls="collapse<?=$i?>">
									          <?=$i.". ".$objResult['problem_name']." (เกิดขึ้นจำนวน ".$objResult['count_problem']." ครั้ง)"?>
									        </a>
									      </h4>
									    </div>
									    <div id="collapse<?=$i?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading<?=$i?>">
									      <div class="panel-body">
													<?=$objResult['solution_problem']?>
									      </div>
									    </div>
									  </div>

								<?
									$i++;
								}
								echo '</div>';
							 ?>


							 <li style="font-size: 18px;">ปัญหาที่เกิดขึ้นบ่อย 3 อันดับแรก ของประเภทปัญหา ด้านซอฟต์แวร์</li><br>
               <?php
							 $i=1;
							 $strSQL_sw = "SELECT p.problem_name,pt.problem_type_name,p.solution_problem,COUNT(dr.id_problem) as count_problem 
														FROM detail_repair dr 
														LEFT JOIN problem p ON dr.id_problem=p.id_problem 
														LEFT JOIN problem_type pt ON p.id_problem_type=pt.id_problem_type 
														WHERE pt.id_problem_type = 2 GROUP BY p.id_problem_type,p.id_problem 
														ORDER BY count_problem DESC LIMIT 0,3";

							 $objQuery_sw = mysql_query($strSQL_sw) or die ("Error Query [".$strSQL_sw."]");
							 echo '<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">';
							 while ($objResult_sw = mysql_fetch_array($objQuery_sw)) {
									?>

									  <div class="panel panel-default">
									    <div class="panel-heading" role="tab" id="heading_sw<?=$i?>">
									      <h4 class="panel-title">
									        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse_sw<?=$i?>" aria-expanded="false" aria-controls="collapse_sw<?=$i?>">
													<?=$i.". ".$objResult_sw['problem_name']." (เกิดขึ้นจำนวน ".$objResult_sw['count_problem']." ครั้ง)"?>
									        </a>
									      </h4>
									    </div>
									    <div id="collapse_sw<?=$i?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading_sw<?=$i?>">
									      <div class="panel-body">
													<?=$objResult_sw['solution_problem']?>
									      </div>
									    </div>
									  </div>

								<?
									$i++;
								}
								echo '</div>';
							 ?>


							 <li style="font-size: 18px;">ปัญหาที่เกิดขึ้นบ่อย 3 อันดับแรก ของประเภทปัญหา ด้านฮาร์ดแวร์</li><br>
					     <?php
							 $i=1;
							 $strSQL_hw = "SELECT p.problem_name,pt.problem_type_name,p.solution_problem,COUNT(dr.id_problem) as count_problem
													FROM detail_repair dr
													LEFT JOIN problem p ON dr.id_problem=p.id_problem
													LEFT JOIN problem_type pt ON p.id_problem_type=pt.id_problem_type
													WHERE pt.id_problem_type = 1
													GROUP BY p.id_problem_type,p.id_problem
													ORDER BY count_problem DESC LIMIT 0,3";

							 $objQuery_hw = mysql_query($strSQL_hw) or die ("Error Query [".$strSQL_hw."]");
							 echo '<div class="panel-group" id="accordion_hw" role="tablist" aria-multiselectable="true">';
							 while ($objResult_hw = mysql_fetch_array($objQuery_hw)) {
									?>

									  <div class="panel panel-default">
									    <div class="panel-heading" role="tab" id="heading_hw<?=$i?>">
									      <h4 class="panel-title">
									        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion_hw" href="#collapse_hw<?=$i?>" aria-expanded="false" aria-controls="collapse_hw<?=$i?>">
													<?=$i.". ".$objResult_hw['problem_name']." (เกิดขึ้นจำนวน ".$objResult_hw['count_problem']." ครั้ง)"?>
									        </a>
									      </h4>
									    </div>
									    <div id="collapse_hw<?=$i?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading_hw<?=$i?>">
									      <div class="panel-body">
													<?=$objResult_hw['solution_problem']?>
									      </div>
									    </div>
									  </div>

								<?
									$i++;
								}
								echo '</div>';
							 ?>
					   </div>
					 </div>

				 </div>
       </div>
			</div>

			<?php include"inc_js.php";?>
</body>
</html>
