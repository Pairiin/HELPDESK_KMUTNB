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
    <td width="291" align="center"><h3>รายงานสรุปการแจ้งซ่อมตามประเภทผู้ใช้</h3></td>
  </tr>
  <tr>
    <td height="27" align="center"><span class="style2"><strong>ข้อมูลระหว่างวันที่ :  </strong> <?=$_GET[date_start]?> ถึง <?=$_GET[date_end]?></span></td>
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
		<td width="1%" height="40" align="center"><strong>ลำดับ</strong></td>
		<td width="7%" height="32" align="center"><strong>รหัสการซ่อม</strong></td>
		<td width="7%" height="32" align="center"><strong>ชื่อผู้แจ้ง</strong></td>
		<td width="7%" height="32" align="center"><strong>วันที่แจ้งซ่อม</strong></td>
		<td width="7%" height="32" align="center"><strong>ชื่ออุปกรณ์</strong></td>
		<td width="7%" height="32" align="center"><strong>ประเภทอุปกรณ์</strong></td>
		<td width="7%" height="32" align="center"><strong>ประเภทผู้ใช้งาน</strong></td>
  </tr>


  <tr>
    <?php
		$sql="SELECT * FROM REPAIR INNER JOIN detail_repair ON repair.id_repair = detail_repair.id_repair INNER JOIN status ON detail_repair.id_status=status.id_status INNER JOIN device ON detail_repair.id_device = device.id_device INNER JOIN device_type ON device.id_device_type=device_type.id_device_type INNER JOIN user_status ON repair.id_user_status=user_status.id_user_status WHERE date_s BETWEEN '$date_start' AND '$date_end' AND user_status.id_user_status='$_REQUEST[id_user_status]'";
    $result = mysql_query($sql);
    $i = 1;
    while($objResult =mysql_fetch_array($result)){;
     ?>
      <tr>
				<td height="35" align="center"><?php echo $i; ?></td>
        <td align="center"><?php echo $objResult[id_repair]; ?></td>
        <td align="center"><?php echo $objResult[user_name]; ?></td>
        <td align="center"><?php echo dateToBE($objResult[date_s]); ?></td>
        <td align="center"><?php echo $objResult[device_name]; ?></td>
        <td align="center"><?php echo $objResult[device_type_name]; ?></td>
        <td align="center"><?php echo $objResult[name_user_status]; ?></td>

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
