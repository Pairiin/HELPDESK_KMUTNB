<?php
  session_start();
	ob_start();

	require_once "mpdf/mpdf.php";
	include_once "connect.php";
	include "function.php";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<html>
<head>
  <META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=UTF-8">
</head>
<body>
<div class=Section2>
<table width="704" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="291" align="center"><h3>รายงานสรุปความพึงพอใจในแต่ละเดือน</h3></td>
  </tr>
  <tr>
    <?php $m=$_REQUEST['month']; ?>
    <td height="27" align="center"><span class="style2">เดือน :  <strong><?=$m?></strong> </span></td>
  </tr>
  <tr>
    <td height="25" align="center"><span class="style2">สำนักคอมพิวเตอร์และเทคโนโลยีสารสนเทศ มหาวิทยาลัยเทคโนโลยีพระจอมเกล้าพระนครเหนือ วิทยาเขตปราจีนบุรี</span></td>
  </tr>
  <tr>
      <td width="20%" height="32" align="center"><strong>เกณฑ์คะแนน :  </strong>  มากที่สุด = 5 , มาก = 4 , พอใช้ = 3 , น้อย = 2 , น้อยที่สุด = 1</td>
  </tr>
</table>

<br>
<?
$date_start=dateFormatDB($_REQUEST['date_start']);
$date_end=dateFormatDB($_REQUEST['date_end']);
$id_problem_type=$_REQUEST['id_problem_type'];

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

<table bordercolor="#424242" width="100%" height="100%" border="1"  align="center" cellpadding="0" cellspacing="0" class="style3">
  <tr bgcolor="#84cdce">
    <td  width="10%"  height="50" align="center"><strong>ลำดับ</strong></td>
    <td  width="45%" height="50" align="center"><strong>หัวข้อ</strong></td>
    <td  width="15%" height="50" align="center"><strong>จำนวนผู้ประเมิน</strong></td>
    <td  width="15%" height="50" align="center"><strong>คะแนนรวม</strong></td>
    <td width="15%" height="50" align="center"><strong>ค่าเฉลี่ยที่ได้</strong></td>
  </tr>
  <tr>
    <?php
		$sql="SELECT DISTINCT detail_satisfaction.id_question, question.question_name ,
          SUM( detail_satisfaction.id_point ) as sum , COUNT(satisfaction.id_repair) as count
          FROM detail_satisfaction
          LEFT JOIN satisfaction ON detail_satisfaction.id_satisfaction = satisfaction.id_satisfaction
          LEFT JOIN question ON detail_satisfaction.id_question = question.id_question
          LEFT JOIN point ON detail_satisfaction.id_point = point.id_point
          WHERE MONTH( date_assessment ) = '$id_month' GROUP BY detail_satisfaction.id_question";

    $result = mysql_query($sql);
    $total=0;
    while($objResult =mysql_fetch_array($result)){;
      $total +=  ($objResult[sum]/$objResult[count]);
      $sum += $objResult[sum];
     ?>
      <tr>
        <td width="25" height="40" align="center"><?php echo $objResult[id_question]; ?></td>
        <td width="20" height="40" align="center"><?php echo $objResult[question_name]; ?></td>
        <td width="25" height="40" align="center"><?php echo $objResult[count]; ?></td>
        <td width="40" height="40" align="center"><?php echo $objResult[sum]; ?></td>
        <td width="30" height="40" align="center"><?php echo number_format(($objResult[sum]/$objResult[count]), 2, '.', ''); ?></td>

    <? $i+=1 ; }?>
  </tr>
  <tr>
      <td width="30" height="40" align="center" colspan="3"><strong>คะแนนรวม</strong></td>
      <td width="40" height="40" align="center"><strong><?php echo $sum ; ?></strong></td>
      <td width="30" height="40" align="center"><strong><?php echo number_format($total, 2, '.', ''); ; ?></strong></td>
  </tr>
</table>
<table width="200" border="0">
  <tbody>
    <tr>
      <td>&nbsp;</td>
    </tr>
  </tbody>
</table>
<?php
 $sql_name =  "SELECT * FROM admin where username ='".$_SESSION['user_admin']."' AND password ='".$_SESSION['pass_admin']."'";
 $result_name = mysql_query($sql_name);
 while ($row_name= mysql_fetch_array($result_name))
			{
 				// echo "<strong>ผู้รายงานข้อมูล" ," : </strong>". $row_name['admin_name']." ".$row_name['admin_lname'];
        echo "<strong>ข้อมูล ณ วันที่</strong>".DateThai(date("Y-m-d"))."";
			}
?>
</div>
</body>
</html>
<?Php
$html = ob_get_contents();
ob_end_clean();
$pdf = new mPDF('th', 'A4-L', '0', 'THSaraban');
$pdf->SetAutoFont();
$pdf->SetDisplayMode('fullpage');
$pdf->WriteHTML($html, 2);
$pdf->Output();         // เก็บไฟล์ html ที่แปลงแล้วไว้ใน MyPDF/MyPDF.pdf ถ้าต้องการให้แสดง
?>
