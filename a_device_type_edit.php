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
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Help Desk KMUTNB</title>
		<?php include"a_inc_css.php";?>
  </head>

  <body class="sidebar-mini fixed">
    <div class="wrapper">

			<?php include"connect.php";?><!-- connect database -->
			<?php include"a_header.php";?><!-- header -->
			<?php include"a_side_nav.php";?><!-- Side-Nav-->
			<?php include"function.php";?><!-- function-->

			<div class="content-wrapper">
        <div class="page-title">
          <div>
            <h1><i class="fa fa-wrench fa-lg"></i> จัดการประเภทอุปกรณ์</h1>
          </div>
        </div>

				<!-- form add -->

				<div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="row">
                <div class="col-lg-6">

                  <div class="well bs-component">

										<?php
											$sql = "SELECT *
															FROM device_type
															WHERE id_device_type = $_REQUEST[id]";
											$objQuery = mysql_query($sql);
											$objResult = mysql_fetch_array($objQuery);

										?>

                    <form action="a_device_type_edit_process.php"  id="form"  class="form-horizontal" method="post">
                      <fieldset>
                        <legend>แก้ไขประเภทอุปกรณ์</legend>

												<div class="form-group">
                          <label class="col-lg-4 control-label"><font color = "red">* </font>ชื่อประเภทอุปกรณ์</label>
                          <div class="col-lg-8">
                            <input class="form-control" name="device_type_name" id="device_type_name" type="text" placeholder="เช่น อุปกรณ์ส่วนตัว" value="<?=$objResult['device_type_name'];?>">
                          </div>
                        </div>

												<div class="form-group">
                          <label class="col-lg-4 control-label">สถานะ</label>
                          <div class="col-lg-8">
														<select name="status" class="form-control" id="status">

																<?php
																$arrStatus = array("ใช้งาน","ไม่ใช้งาน");

																while($item = current($arrStatus)){
																	if($item == $objResult["status"])
																	{
																		$sel= "selected";
																	}
																	else
																	{
																		$sel = "";
																	}?>
																	<option value="<?php echo $item?>" <?php echo $sel;?>><?php echo $item;?></option>

																	<?php
																	next($arrStatus);    // ถ้าไม่มี next จะติด loop ต้องระวังให้มากๆ และอย่าลืมใส่ parameter ด้วย
																	}
					                      ?>
					                  </select>
                          </div>
                        </div>

                        <div class="form-group">
                          <div class="col-lg-10 col-lg-offset-4">
														<input type="hidden" name="id" value="<?=$_REQUEST['id']?>">
														<button class="btn btn-primary" type="submit">Submit</button>
                            <button class="btn btn-default" type="reset">Cancel</button>
                          </div>
                        </div>
                      </fieldset>
                    </form>
                  </div>
                </div>

              </div>
            </div>
          </div>
			</div>

      </div>
    </div>

		<?php include"a_inc_js.php";?>

		<script type="text/javascript">
			$( document ).ready( function () {
				$( "#form" ).validate( {
					rules: {
						device_type_name: "required"
					},
					messages: {
						device_type_name: "กรุณากรอก ชื่อประเภทอุปกรณ์"
					},
					errorElement: "em",
					errorPlacement: function ( error, element ) {
						// Add the `help-block` class to the error element
						error.addClass( "help-block" );

						// Add `has-feedback` class to the parent div.form-group
						// in order to add icons to inputs
						element.parents( ".col-lg-8" ).addClass( "has-feedback" );

						if ( element.prop( "type" ) === "checkbox" ) {
							error.insertAfter( element.parent( "label" ) );
						} else {
							error.insertAfter( element );
						}

						// Add the span element, if doesn't exists, and apply the icon classes to it.
						if ( !element.next( "span" )[ 0 ] ) {
							$( "<span class='glyphicon glyphicon-remove form-control-feedback'></span>" ).insertAfter( element );
						}
					},
					success: function ( label, element ) {
						// Add the span element, if doesn't exists, and apply the icon classes to it.
						if ( !$( element ).next( "span" )[ 0 ] ) {
							$( "<span class='glyphicon glyphicon-ok form-control-feedback'></span>" ).insertAfter( $( element ) );
						}
					},
					highlight: function ( element, errorClass, validClass ) {
						$( element ).parents( ".col-lg-8" ).addClass( "has-error" ).removeClass( "has-success" );
						$( element ).next( "span" ).addClass( "glyphicon-remove" ).removeClass( "glyphicon-ok" );
					},
					unhighlight: function ( element, errorClass, validClass ) {
						$( element ).parents( ".col-lg-8" ).addClass( "has-success" ).removeClass( "has-error" );
						$( element ).next( "span" ).addClass( "glyphicon-ok" ).removeClass( "glyphicon-remove" );
					}
				} );
			} );
		</script>
  </body>
</html>

<?php } ?>
