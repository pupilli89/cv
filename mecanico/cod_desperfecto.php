<?php

session_start();

if (isset($_SESSION['user'])) {

    //Datos de fecha
    $versistema = "Mecanicos v1.00";
    $meses = array('ENE', 'FEB', 'MAR', 'ABR', 'MAY', 'JUN', 'JUL', 'AGO', 'SEP', 'OCT', 'NOV', 'DIC');
    $dias = array('LUNES', 'MARTES', 'MIERCOLES', 'JUEVES', 'VIERNES', 'SABADO', 'DOMINGO');
    $dia_sem_actual = $dias[(date("N") * 1) - 1];
    $fec_actual = date("d") . "/" . $meses[date("m") - 1] . "/" . date("Y");


?>


    <!DOCTYPE html>
    <html lang="en">
    <title><?php echo $versistema; ?></title>
    <?php require_once "scripts.php"; ?>
    <link rel="shortcut icon" type="image/x-icon" href="ima/favicon.ico" />
    <link href="css/fa/css/all.css" rel="stylesheet">
    <link href="css/inicio.css" rel="stylesheet">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <style>
        .contenedor {
            position: relative;
            display: inline-block;
            text-align: center;
            border-radius: 1em;
            color: black;
            font-size: 20px;
            cursor: pointer;
        }

        .centrado {
            position: absolute;
            top: 45%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .contenedor:hover {
            opacity: 0.5;
        }

        #nro_orden {
            width: 50px;
        }

        #nro_ordenh {
            width: 35px;
        }

        #fechach,
        #fechasch {
            width: 95px;
        }


        #fecha,
        #hora,
        #fechac,
        #horac {
            width: 95px;
        }

        .contenedor1 {
            position: relative;
            display: inline-block;
            text-align: center;
            border-radius: 1em;
            color: black;
            font-size: 20px;
            cursor: pointer;
        }

        .contenedor1:hover {
            opacity: 0.5;
        }

        .stock:hover {
            opacity: 0.5;
            cursor: pointer;
        }

        .titu {
            float: left;
            font-size: 13px;
            text-align: center;
            align-items: center;
            justify-content: center;
        }

        .fecha,
        .user {
            font-size: 13px;
        }

        .stock,
        .cod_rep,
        .cod_des,
        .logout {
            font-size: 13px;
        }
    </style>
    </head>

    <body>

        <nav class="navbar navbar-expand-sm">
			<div class="container-fluid">
				<ul class="nav navbar-nav">
					<div class="titu">BERNARDINO RIVIADAVIA <br>
						LINEA <?php echo $_SESSION["linea"]; ?>
					</div>
				</ul>
				<ul class="nav navbar-nav mx-auto">
                     <li class="nav-item">
						<a class="nav-link" onclick="inicio();" style="cursor: pointer;">Inicio <span class="fa fa-home"></span></a>
					</li>
					<li class="nav-item">
						<a class="nav-link" onclick="stock();" style="cursor: pointer;">Stock <span class="fa fa-qrcode"></span></a>
					</li>
					<li class="nav-item">
						<a class="nav-link"  onclick="cod_rep();" style="cursor: pointer;">Tipo repaciones <span class="fa fa-chain-broken"></span></a>
					</li>
					<li class="nav-item">
						<a class="nav-link" onclick="salir();" style="cursor: pointer;">Salir <span class="fa fa-power-off"></span></a>
					</li>
				</ul>
				<ul class="nav navbar-nav">
					<span class="navbar-text navbar-right">
						<div class="fecha">
							<?php echo $dia_sem_actual . " " . $fec_actual; ?>
						</div>
						<div class="user">
							<i class="fa fa-user-circle" aria-hidden="true"></i>
							Usuario:<?php echo  $_SESSION["user"]; ?>
						</div>
					</span>
				</ul>
			</div>
		</nav><br>

        <!-- Para ingresar datos a cod desperfectos -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <caption>
                        <button class="btn btn-primary" data-toggle="modal" data-target="#miModal" style="cursor: pointer;">
                            Generar codigo de desperfecto
                        </button>
                    </caption>
                </div>
            </div>
        </div><br>

        <div id="tablaDatatable"></div>

        <div class="modal fade" id="miModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Cargar nuevo codigo de desperfecto</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Nuevo codigo de repacion:</label>
                                <input type="text" class="form-control" id="recipient-name">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary"id="guardarnuevo" data-dismiss="modal">Guardar</button>
                    </div>
                </div>
            </div>
        </div>
    </body>

    </html>
<?php

} else {
    header("location:index.php");
}
?>

<script>

	$(document).ready(function(){ //muestro la tabla

		$('#tablaDatatable').load('tabla.php');

        $('#guardarnuevo').click(function() { //Inicio funcion para agregar internos
			if ($('#recipient-name').val() == "") {
				alertify.alert("Debes agregar una descripcion");
				return false;
			}

			cadena = "nuevo=" + $('#recipient-name').val();

			$.ajax({
				type: "POST",
				url: "procesos/agregarcod.php",
				data: cadena,
				success: function(r) {
                        if (r == 1) {
						alertify.success("Agregado con exito");
						setTimeout(() => {
							window.location = "cod_desperfecto.php";
						}, 2000);

					} else {
						alertify.alert("Error al cargar", "Verifique sus datos ");
					}
				}
			});
		}); //cierro funcion para agregar internos



		
});


    function inicio() {

        window.location = "inicio.php";
    }

    function salir() {
        window.location = "index.php";
    }

    function cod_rep (){
        window.location = "cod_reparacion.php";
    }

    function stock() {
		window.location = "stock.php";
	}

</script>