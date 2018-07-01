<meta charset="utf-8">
<?php
include"connect.php";
include"inc_css.php";
$serial_number=$_REQUEST['serial_number'];
$device_name=$_REQUEST['device_name'];
$device_category=$_REQUEST['device_category'];
$device_type=$_REQUEST['device_type'];
$status="ใช้งาน";

$id_detail=$_REQUEST['id_detail'];

// เช็คว่ามีข้อมูลนี้อยู่หรือไม่
	$check = "select * from device  where serial_number = '$serial_number' ";
	$result1 = mysql_query($check) or die(mysql_error());
	$num=mysql_num_rows($result1); 
     if($num > 0){
//ถ้ามี username นี้อยู่ในระบบแล้วให้แจ้งเตือน
		 echo "<script>";
		 echo "alert(' มีอุปกรณ์ชิ้นนี้ในระบบแล้ว!');";
		 echo "window.location='a_device_insert.php';";
		 echo "</script>";
 
	}else{
//ถ้าไม่มีก็บันทึกลงฐานข้อมูล
		 $sql = "INSERT INTO device (serial_number,device_name,id_device_category,id_device_type,status_device)
		VALUES ('$serial_number','$device_name','$device_category','$device_type','$status')";

		$objQuery = mysql_query($sql);
 

}
//บันทึกสำเร็จแจ้งเตือนและกระโดดกลับไปหน้าฟอร์ม   ปล.การทำระบบจริงๆ อาจกระโดดไปหน้าอื่นที่เรากำหนด
	if($objQuery){
		if($id_detail==""){ //ถ้า insert โดยคลิ๊กโดยตรง
		?>
	  <script>
	      setTimeout(function() {
	          swal({
	              title: "บันทึกข้อมูลสำเร็จ!!",
	              text: "คลิกปุ่ม \"OK\" เพื่อรับทราบ",
	              type: "success",
	              confirmButtonText: "OK"
	          }, function() {
	              window.location = "a_manage_device.php";
	          }, 1000);
	      });
	  </script>
	  <?php
	}else{ //ถ้า insert โดยผ่านหน้าประเมิน
		?>
	  <script>
	      setTimeout(function() {
	          swal({
	              title: "บันทึกข้อมูลสำเร็จ!!",
	              text: "คลิกปุ่ม \"OK\" เพื่อรับทราบ",
	              type: "success",
	              confirmButtonText: "OK"
	          }, function() {
	              window.location.href = "a_evalue.php?id_detail=<?=$id_detail?>";
	          }, 1000);
	      });
	  </script>
	<?php
		}
	} else{
//ถ้าบันทึกไม่สำเร็จแสดงข้อความ Error และกระโดดกลับไปหน้าฟอร์ม
		    echo "<script type='text/javascript'>";
				echo "alert('Error!');";
				echo "window.location='a_manage_device.php';";
			echo "</script>";
	  }
	  
	  
 ?>

<script src="js/sweetalert.min.js"></script>
