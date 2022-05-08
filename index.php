<?php require_once('./include/pdo_connect.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    <!-- Bootstrap Core Css -->
    <link href="css/bootstrap.css" rel="stylesheet" />

    <!-- Font Awesome Css -->
    <link href="css/font-awesome.min.css" rel="stylesheet" />

	<!-- Bootstrap Select Css -->
    <link href="css/bootstrap-select.css" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="css/app_style.css" rel="stylesheet" />
	
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	
	<style>
	.li-post-group {
		background: #f5f5f5;
		padding: 5px 10px;
		border-bottom: solid 1px #CFCFCF;
		margin-top: 5px;
	}
	.li-post-title {
		border-left: solid 4px #304d49;
		background: #a7d4d2;
		padding: 5px;
		color: #304d49;
	}
	.show-more {
	    background: #10c1b9;
	    width: 100%;
	    text-align: center;
	    padding: 10px;
	    border-radius: 5px;
	    margin: 5px;
	    color: #fff;
	    cursor: pointer;
	    font-size: 20px;
	    display: none;
	    margin: 0px;
    	margin-top: 25px;
	}
	.li-post-desc {
	    line-height: 15px !important;
	    font-size: 12px;
	    box-shadow: inset 0px 0px 5px #7d9c9b;
	    padding: 10px;
	}
	.panel-default {
	    margin-bottom: 100px;
	}
	.post-data-list {
	    max-height: 374px;
	    overflow-y: auto;
	}
	.radio-inline {
	    font-size: 20px;
	    color: #c36928;
	}
	.progress, .progress-bar{ height: 40px; line-height: 40px; display: none; }
	</style>
</head>
<body>
    <div class="all-content-wrapper">
		<section class="container">   
			<div class="form-group custom-input-space has-feedback">
				<div class="page-heading">
					<h3 class="post-title">Importar datos XML a Base de Datos MySQL con AJAX Y PHP </h3>
				</div>
				<div class="page-body clearfix">
					<div class="row">
						<div class="col-md-offset-2 col-md-8">
							<div class="panel panel-default">
								<div class="panel-heading">Importar documento XML a la base de datos:</div>
								<div class="panel-body">
									
									<div class="form-group">
				                        <div class="progress">
				                            <div class="progress-bar progress-bar-primary file-progress" role="progressbar" style="width:0%">0%</div>
				                        </div>

				                        <div class="alert icon-alert with-arrow alert-success form-alter" role="alert">
											<i class="fa fa-fw fa-check-circle"></i>
											<strong> Exitoso ! </strong> <span class="success-message"> </span>
										</div>
										<div class="alert icon-alert with-arrow alert-danger form-alter" role="alert">
											<i class="fa fa-fw fa-times-circle"></i>
											<strong> Nota !</strong> <span class="warning-message"> </span>
										</div>

				                    </div>

									<form method="post" id="import_xml" enctype="multipart/form-data">
								      <div class="form-group">
								       <label>Elegir documento XML</label>
								       <input type="file" name="xml_data" id="xml_data" required />
								      </div>
								      <br />
								      <div class="form-group">
								       <button type="submit" name="btn-submit" id="btn-submit" class="btn btn-success" >Importar documento</button>								   
								      </div>									  									  
            						<br clear="all"><br clear="all">
            							<div id="ruta_archivo">
            							</div>
         							 </div>
								     </form>
								</div>

								<div class="panel panel-default">
								<div class="panel-body">	
            						<center>
            							<h3>Exportar tabla a archivo CSV, XML y JSON con PHP</h3><br clear="all"><br clear="all">
              						</center>
            						<center>
                						<form method="post" action="exportDB/exportcsv.php">
                    						<input type="submit" name="boton" value="Exportar CSV"></input>
                						</form><br>
                						<form method="post" action="exportDB/exportxml.php">
                  							<input type="submit" name="boton" value="Exportar XML"></input>
              							</form><br>
              							<form method="post" action="exportDB/exportjson.php">
                							<input type="submit" name="boton" value="Exportar JSON"></input>
            							</form>
            						</center>									  
            						<br clear="all"><br clear="all">
            							<div id="ruta_archivo">
            							</div>
         							 </div>
								     </form>
								</div>
							</div>

							</div>

							



						</div>
					</div>					
					</div>				
				</div>	
						  
		</section>

		
		
    </div>
	
	<!-- Jquery Core Js -->
    <script src="js/jquery.min.js"></script>

    <!-- Bootstrap Core Js -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Bootstrap Select Js -->
    <script src="js/bootstrap-select.js"></script>
	
	<script>

	$(document).ready(function(){
		$('#import_xml').on('submit', function(e){
			e.preventDefault();

		$.ajax({
			url:"ajax_upload.php",
			method:"POST",
			data: new FormData(this),
			contentType:false,
			cache:false,
			dataType: "json",
			processData:false,
			beforeSend:function(){
				$('.progress, .progress-bar').show();
				$('.file-progress').text('0%');
                $('.file-progress').css('width', '0%');
				$('#btn-submit').attr('disabled','disabled'),
				$('#btn-submit').html(' <i class="fa fa-spinner fa-pulse fa-fw"></i> Procesando...');
			},
			xhr: function () {
                var xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener("progress", function (evt) {
                    if (evt.lengthComputable) {
                        var percentComplete = evt.loaded / evt.total;
                        percentComplete = parseInt(percentComplete * 100);
                        $('.file-progress').text(percentComplete + '%');
                        $('.file-progress').css('width', percentComplete + '%');
                    }
                }, false);
                return xhr;
            },
			success:function(data){
				console.log(data);

				if(data['status'] == "200"){
					$('.alert-danger').hide();
					$('.alert-success').show();
					$('.success-message').html(data['message']);
				}else{
					$('.alert-success').hide();
					$('.alert-danger').show();
					$('.warning-message').html(data['message']);
				}
				
				$('#import_xml')[0].reset();
				$('#btn-submit').attr('disabled', false);
				$('#btn-submit').html('Importar documento');
			}
		});

		});
	});

	function enviar_cad(){
          $.ajax({
            url: "generarcsv.php",
            type: "POST",
            data: "",
            success: function (resp){
                console.log(resp);
                msj=JSON.parse(resp);
                $("#ruta_archivo").html(msj.mensaje+"<br clear='all'>"+"<a href='"+msj.datos+"'><img src='iconoexcel.png' height='50px'></a>");
            }
          });
        }

	
	</script>
</body>
</html>
