<?
	include('connect.php');
	include('inc_css.php');

// INSERT TABLE tb_roomreserv
date_default_timezone_set('Asia/Bangkok');
$date_s= date("Y-m-d");
$time_s=date("H:i:s");

$id_repair = $_REQUEST["id_repair"]; //คำแนะนำ
$gender = $_REQUEST["gender"]; //เพศ
$education = $_REQUEST["education"]; //การศึกษา
$faculty = $_REQUEST["faculty"]; //คณะ
$department = $_REQUEST["department"]; //สาขา
$sugges = $_REQUEST["sugges"]; //คำแนะนำ

//ประเมินความพึงพอใจ
$strSQL = "INSERT INTO satisfaction(id_repair,date_assessment,gender,education,id_faculty,id_department,sugges)
					VALUES ('$id_repair','$date_s','$gender','$education','$faculty','$department','$sugges')";
$objQuery = mysql_query($strSQL);

//อัพเดตสถานะการประเมิน
$strSQL_updateStatus ="UPDATE repair
											SET status_satis = 2
											WHERE id_repair=$id_repair";
$objQuery__updateStatus = mysql_query($strSQL_updateStatus);

if($objQuery){

	//SELECT id_satisfaction
	$strSQL3 = "SELECT id_satisfaction FROM satisfaction ORDER BY id_satisfaction  DESC LIMIT 1";
	$objQuery3 = mysql_query($strSQL3);
	$objResult3 = mysql_fetch_array($objQuery3);

	if(!$objResult3){
		$id_satisfaction  = 1;
	}
	else{
		$id_satisfaction  = $objResult3["id_satisfaction"];
	}
}
else{
	echo "Error Save satisfaction 	 [".$strSQL."]";
}

//SELECT id_satisfaction
	$strSQL4 = "SELECT COUNT(id_question) AS count FROM question";
	$objQuery4 = mysql_query($strSQL4);
	$objResult4 = mysql_fetch_array($objQuery4);

for($i=1;$i<=$objResult4['count'];$i++){
	if($_REQUEST["point".$i] != ""){
		// INSERT TABLE calendar
		$strSQL2 = "INSERT INTO detail_satisfaction  ";
		$strSQL2 .="(id_satisfaction,id_question,id_point) ";
		$strSQL2 .="VALUES ('".$id_satisfaction."','". $i ."','".$_REQUEST["point".$i]."')";
		mysql_query($strSQL2);
		}
	}

?>

<script>
		setTimeout(function() {
				swal({
						title: "บันทึกข้อมูลสำเร็จ!!",
						text: "คลิกปุ่ม \"OK\" เพื่อรับทราบ",
						type: "success",
						confirmButtonText: "OK"
				}, function() {
						window.location = "assessment_show.php?id_repair=<?=$id_repair?>";
				}, 1000);
		});
</script>

<script src="js/sweetalert.min.js"></script>
