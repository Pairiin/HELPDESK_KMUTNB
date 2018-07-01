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

<table width="704" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="291" align="center"><h3>รายงานสรุปงานซ่อมของแต่ละเดือน</h3></td>
  </tr>
  <tr>
    <td height="27" align="center"><span class="style2"><strong>ข้อมูลงานซ่อมของเดือน :  </strong> <?=$month?></span></td>
  </tr>
  <tr>
    <td height="25" align="center"><span class="style2">สำนักคอมพิวเตอร์และเทคโนโลยีสารสนเทศ มหาวิทยาลัยเทคโนโลยีพระจอมเกล้าพระนครเหนือ วิทยาเขตปราจีนบุรี</span></td>
  </tr>
</table>

<br>
<?
$date_start=dateFormatDB($_REQUEST['date_start']);
$date_end=dateFormatDB($_REQUEST['date_end']);
$id_problem_type=$_REQUEST['id_problem_type']; ?>



<table bordercolor="#424242" width="100%" height="100%" border="1"  align="center" cellpadding="0" cellspacing="0" class="style3">
  <tr bgcolor="#84cdce">
		<td width="5%" height="40" align="center"><strong>ลำดับ</strong></td>
		<td width="7%" height="32" align="center"><strong>รหัสการซ่อม</strong></td>
		<td width="15%" height="32" align="center"><strong>ชื่อผู้แจ้ง</strong></td>
		<td width="7%" height="32" align="center"><strong>วันที่แจ้งซ่อม</strong></td>
		<td width="7%" height="32" align="center"><strong>สถานะการซ่อม</strong></td>
		<td width="20%" height="32" align="center"><strong>ชื่ออุปกรณ์</strong></td>
		<td width="20%" height="32" align="center"><strong>ปัญหา</strong></td>
		<td width="5%" height="32" align="center"><strong>ประเภทอุปกรณ์</strong></td>
  </tr>


  <tr>
    <?php
		$sql="SELECT *
            FROM REPAIR INNER JOIN detail_repair ON repair.id_repair = detail_repair.id_repair
            INNER JOIN STATUS ON detail_repair.id_status = status.id_status
            INNER JOIN device ON detail_repair.id_device = device.id_device
            INNER JOIN device_type ON device.id_device_type = device_type.id_device_type
            WHERE MONTH(date_s ) = $m AND YEAR(date_s)=$date";
    $result = mysql_query($sql);
    $i = 1;
    while($objResult =mysql_fetch_array($result)){;
     ?>
      <tr>
				<td height="35" align="center"><?php echo $i; ?></td>
	      <td align="center"><?php echo $objResult[id_detail]; ?></td>
	      <td align="center"><?php echo $objResult[user_display]; ?></td>
	      <td align="center"><?php echo dateToBE($objResult[date_s]); ?></td>
	      <td align="center"><?php echo $objResult[status_name]; ?></td>
	      <td align="center"><?php echo $objResult[device_name]; ?></td>
	      <td align="center"><?php echo $objResult[problem]; ?></td>
	      <td align="center"><?php echo $objResult[device_type_name]; ?></td>

    <? $i+=1 ; }?>
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
