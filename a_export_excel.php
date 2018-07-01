<?
$connection=mysql_connect("localhost","root","12345678") or die("เชื่อมต่อฐานข้อมูลไม่ได้");
mysql_select_db("helpdesk") or die("ไม่สามารถเลือกฐานข้อมูลได้");
$q="select * from province order by province_id ";
$qr=mysql_query($q);
$row_num=mysql_num_rows($qr);
$col_arr=array("Province ID","Province Name","Province Part");
$col_num=count($col_arr);
header("Pragma: public");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("Content-Type: application/force-download");
header("Content-Type: application/octet-stream");
header("Content-Type: application/download");;
header("Content-Disposition: attachment;filename=data.xls "); 
?>
<?php echo '<?xml version="1.0" encoding="windows-874"?>'; ?>
 
<?php echo'<?mso-application progid="Excel.Sheet"?>';?>
 
<Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet"
 xmlns:o="urn:schemas-microsoft-com:office:office"
 xmlns:x="urn:schemas-microsoft-com:office:excel"
 xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet"
 xmlns:html="http://www.w3.org/TR/REC-html40">
 <Styles>
  <Style ss:ID="Default" ss:Name="Normal">
   <Alignment ss:Vertical="Bottom"/>
   <Borders/>
   <Font x:CharSet="222"/>
   <Interior/>
   <NumberFormat/>
   <Protection/>
  </Style>
 </Styles>
 <Worksheet ss:Name="ข้อมูลจังหวัดในประเทศไทย">
  <Table ss:ExpandedColumnCount="<?=$col_num?>" ss:ExpandedRowCount="<?=$row_num+1?>" x:FullColumns="1"
   x:FullRows="1">
   <Row>
   <?php foreach($col_arr as $key=>$value){ ?>
    <Cell><Data ss:Type="String"><?=$value?></Data></Cell>
    <?php } ?>    
   </Row>
<?php
while($rs=mysql_fetch_array($qr)){
?>   
   <Row>
    <Cell><Data ss:Type="Number"><?=$rs['province_id']?></Data></Cell>
    <Cell><Data ss:Type="String"><?=$rs['province_name']?></Data></Cell>
    <Cell><Data ss:Type="Number"><?=$rs['province_part']?></Data></Cell>      
   </Row>
<?php  }  ?>     
  </Table>
  <WorksheetOptions xmlns="urn:schemas-microsoft-com:office:excel">
   <Selected/>
   <ProtectObjects>False</ProtectObjects>
   <ProtectScenarios>False</ProtectScenarios>
  </WorksheetOptions>
 </Worksheet>
</Workbook>