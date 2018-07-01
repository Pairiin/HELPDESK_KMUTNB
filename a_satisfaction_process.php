<?php
session_start();
if ($_SESSION['user_admin'] == "") {
    ?>
    <meta http-equiv='refresh' content='0;URL=index.php?id=login'>
    <?
		//exit();
} else {
    ?>
<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>รายงานสรุปความพึงพอใจในแต่ละเดือน</title>
    <?php include "a_inc_css.php"; ?>


    </head>
     <body class="sidebar-mini fixed">
       <div class="wrapper">

        <?php include "connect.php"; ?><!-- connect database -->
        <?php include "a_header.php"; ?><!-- header -->
        <?php include "a_side_nav.php"; ?><!-- Side-Nav-->
        <?php include "function.php"; ?><!-- function-->
        <?php

        $m=$_REQUEST['month'];
        $id_question=$_REQUEST['id_question'];

        if($m=="มกราคม"){
          $id_month="1";
        }
        elseif ($m=="กุมภาพันธ์") {
          $id_month="2";
        }
        elseif ($m=="มีนาคม") {
          $id_month="3";
        }
        elseif ($m=="เมษายน") {
          $id_month="4 ";
        }
        elseif ($m=="พฤษภาคม") {
          $id_month="5 ";
        }
        elseif ($m=="มิถุนายน") {
          $id_month="6 ";
        }
        elseif ($m=="กรกฎาคม") {
          $id_month="7 ";
        }
        elseif ($m=="สิงหาคม") {
          $id_month="8 ";
        }
        elseif ($m=="กันยายน") {
          $id_month="9";
        }
        elseif ($m=="ตุลาคม") {
          $id_month="10";
        }
        elseif ($m=="พฤศจิกายน") {
          $id_month="11";
        }
        elseif ($m=="ธันวาคม") {
          $id_month="12";
        }
        ?>
        <div class="content-wrapper">
            <div class="page-title">
                <div>
                    <h1><i class="fa fa-bar-chart fa-lg"></i>รายงานสรุปความพึงพอใจในแต่ละเดือน</h1>
                </div>
            </div>
            <div class="row">
              <div class="col-md-11">
                <div class="container-fluid" style="padding-top:10px;">
                    <div class="card">
                  <div class="embed-responsive embed-responsive-16by9">
                  <?
                  $sql= " SELECT DISTINCT detail_satisfaction.id_question, question.question_name ,
                  SUM( detail_satisfaction.id_point ) as sum , COUNT(satisfaction.id_repair) as count
                  FROM detail_satisfaction
                  LEFT JOIN satisfaction ON detail_satisfaction.id_satisfaction = satisfaction.id_satisfaction
                  LEFT JOIN question ON detail_satisfaction.id_question = question.id_question
                  LEFT JOIN point ON detail_satisfaction.id_point = point.id_point
                  WHERE MONTH( date_assessment ) = '$id_month' GROUP BY detail_satisfaction.id_question";
                  $result = mysql_query($sql);
                  $num1=mysql_num_rows($result); ?>
                              <div class="container-fluid" style="padding-top:10px;">
                                  <div class="table-responsive">
                                      <table width="100%" class="table table-bordered table-striped table-hover table-condensed">
                                          <tr>
                                              <td width="20%" height="32" align="center"><strong>ข้อมูลของเดือน :  </strong>
                                                  <? echo $_GET[month] ?></td>
                                          </tr>
                                          <tr>
                                              <td width="20%" height="32" align="center"><strong>เกณฑ์คะแนน :  </strong>  มากที่สุด = 5 , มาก = 4 , พอใช้ = 3 , น้อย = 2 , น้อยที่สุด = 1</td>
                                          </tr>
                                      </table>
                                      <table width="100%"  class="table table-bordered table-striped table-hover table-condensed">
                                      </table>

                                      <table width="100%"  class="table table-bordered table-striped table-hover table-condensed">
                                          <tr>
                                              <td width="10%" height="32" align="center"><strong>ลำดับ</strong></td>
                                              <td width="45%" height="32" align="center"><strong>หัวข้อ</strong></td>
                                              <td width="15%" height="32" align="center"><strong>จำนวนผู้ประเมิน</strong></td>
                                              <td width="15%" height="32" align="center"><strong>คะแนนรวม</strong></td>
                                              <td width="15%" height="32" align="center"><strong>ค่าเฉลี่ยที่ได้</strong></td>
                                          </tr>
                            <?php
                                $total=0;
                                while($objResult =mysql_fetch_array($result)){
                                $total +=  ($objResult[sum]/$objResult[count]);
                                $sum += $objResult[sum];
                                 ?>
                                          <tr>
                                              <td align="center"><?php echo $objResult[id_question]; ?></td>
                                              <td align="center"><?php echo $objResult[question_name]; ?></td>
                                              <td align="center"><?php echo $objResult[count]; ?></td>
                                              <td align="center"><?php echo $objResult[sum]; ?></td>
                                              <td align="center"><?php echo number_format(($objResult[sum]/$objResult[count]), 2, '.', ''); ?></td>
                                          </tr>
                            <?php } ?>
                            <tr>
                                <td align="center" colspan="3"><strong>คะแนนรวม</strong></td>
                                <td align="center"><strong><?php echo $sum ; ?></strong></td>

                                <td align="center"><strong><?php echo number_format($total, 2, '.', ''); ?></strong></td>
                            </tr>
                              </table>
                          </div>
                        </div>
                      <center><a class="btn btn-info" href="a_print_satisfaction.php?month=<? echo $_REQUEST['month'];?>" target="_blank">รายงาน</a>
                      <a class="btn btn-success" href="a_grap_satisfaction.php?month=<? echo $_REQUEST['month'];?>">กราฟ</a></center>
                  </div>
                    </div>
                    </div>
                  </div>
              </div>
            </div>
          </div>
    </div>
    <?php include "a_inc_js.php";?>
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
                 window.location = "a_report_satisfaction.php";
             }, 1000);
         });
     </script>
   <? }?>
   </body>
</html>

<? } ?>
