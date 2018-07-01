<meta charset="utf-8">
<?php
include"connect.php";
include"inc_css.php";

$device_type_name=$_REQUEST['device_type_name'];
$status="ใช้งาน";

$sql = "INSERT INTO device_type (device_type_name,status)
VALUES ('$device_type_name','$id_status')";

$objQuery = mysql_query($sql);

if($objQuery)
{
	?>
  <script>
      setTimeout(function() {
          swal({
              title: "บันทึกข้อมูลสำเร็จ!!",
              text: "คลิกปุ่ม \"OK\" เพื่อรับทราบ",
              type: "success",
              confirmButtonText: "OK"
          }, function() {
              window.location.href = "a_manage_device_type.php";
          }, 1000);
      });
  </script>
  <?
}
else
{
	echo "Error Save [".$sql."]";
}
?>
<script src="js/sweetalert.min.js"></script>
