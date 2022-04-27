<?php

session_start();

if (isset($_SESSION['user'])) {

    //Datos de fecha
    $versistema = "Mecanicos v1.00";
    $meses = array('ENE', 'FEB', 'MAR', 'ABR', 'MAY', 'JUN', 'JUL', 'AGO', 'SEP', 'OCT', 'NOV', 'DIC');
    $dias = array('LUNES', 'MARTES', 'MIERCOLES', 'JUEVES', 'VIERNES', 'SABADO', 'DOMINGO');
    $dia_sem_actual = $dias[(date("N") * 1) - 1];
    $fec_actual = date("d") . "/" . $meses[date("m") - 1] . "/" . date("Y");

    //Fecha y hora actual para la base de datos
	$hora = new DateTime();
	$hora->setTimezone(new DateTimeZone('America/Argentina/Buenos_Aires'));
	$prueba = $hora->format("H:i:s");
	$prueba2 = $hora->format("Y-m-d");


    //Obtengo datos para llenar los select
	function conexion()
	{
		return $conexion = mysqli_connect('127.0.0.1', 'planero', 'sys05510245', 'planillas63');
	}
	$conexion = conexion();

    mysqli_query($conexion,"SET NAMES 'utf8'");

	$sql = "SELECT * FROM fam_stock";
	$result = mysqli_query($conexion, $sql);

?>

    <!DOCTYPE html>
    <html lang="en">
    <title><?php echo $versistema; ?></title>
    <?php require_once "scripts.php"; ?>
    <link rel="shortcut icon" type="image/x-icon" href="ima/favicon.ico" />
    <link href="css/fa/css/all.css" rel="stylesheet">
    <link href="css/inicio.css" rel="stylesheet">
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
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
						<a class="nav-link" onclick="cod_rep();" style="cursor: pointer;">Tipo repaciones <span class="fa fa-wrench"></span></a>
					</li>
					<li class="nav-item">
						<a class="nav-link" onclick="desperfecto();" style="cursor: pointer;">Desperfectos <span class="fa fa-chain-broken"></span></a>
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
                            Cargar nuevo producto
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
                        <h5 class="modal-title">Cargar Stock</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Familia:</label>
							<select id="fam">
								<?php
								while ($row1 = mysqli_fetch_array($result)) {
									echo '<option value="' . $row1['id'] . '">' . $row1['desc'] . '</option>';
                                   
								}
								?>
							</select>
                            </div>
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Codigo:</label>
                                <input type="text" class="form-control" id="codigo">
                            </div>
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Descripcion:</label>
                                <input type="text" class="form-control" id="Descripcion">
                            </div>
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Cantidad:</label>
                                <input type="text" class="form-control" id="Cantidad">
                            </div>
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">C.H.A.S </label>
                                <input type="checkbox" id="chas" value="1">
                            </div>
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">precio:</label>
                                <input type="text" class="form-control" id="precio">
                            </div>
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Proveedor:</label>
                                <input type="text" class="form-control" id="Proveedor">
                            </div>
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Nro factura:</label>
                                <input type="text" class="form-control" id="nro">
                            </div>
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Fecha:</label>
                                <input type="text" class="form-control" id="Fecha" value="<?php echo $prueba2;?>" disabled>
                            </div>
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Despachante:</label>
                                <input type="text" class="form-control" id="Despachante" value="<?php echo  $_SESSION["user"]; ?>" disabled>
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
        <div id="tablaDatatable"></div>
    </body>

    </html>
<?php

} else {
    header("location:index.php");
}
?>

<script>

$(document).ready(function(){ //muestro la tabla

$('#tablaDatatable').load('tablastock.php');

$('#guardarnuevo').click(function() { //Inicio funcion para agregar internos
            if ($('#codigo').val() == "") {
				alertify.alert("Error al Agregar","Debe poner un codigo");
				return false;
			}
			if ($('#fam').val() == "") {
				alertify.alert("Error al Agregar","Debe poner una familia");
				return false;
			}
            if ($('#Descripcion').val() == "") {
				alertify.alert("Error al Agregar","Debe poner una Descripcion");
				return false;
			}
			if ($('#Cantidad').val() == "") {
				alertify.alert("Error al Agregar","Debe poner una Cantidad");
				return false;
			}
            if ($('#precio').val() == "") {
				alertify.alert("Error al Agregar","Debe poner un precio");
				return false;
			}
			if ($('#Proveedor').val() == "") {
				alertify.alert("Error al Agregar","Debe poner un Proveedor");
				return false;
			}
            if ($('#nro').val() == "") {
				alertify.alert("Error al Agregar","Debe poner un numero de factura");
				return false;
			}

			cadena = "codigo=" + $('#codigo').val() +
				"&fam=" + $('#fam').val() +
                "&Descripcion=" + $('#Descripcion').val() +
				"&Cantidad=" + $('#Cantidad').val() +
				"&chas=" + $('#chas').val() +
				"&precio=" + $('#precio').val() +
				"&Proveedor=" + $('#Proveedor').val() +
				"&nro=" + $('#nro').val() +
                "&Despachante=" + $('#Despachante').val() +
				"&Fecha=" + $('#Fecha').val();

			$.ajax({
				type: "POST",
				url: "procesos/agregarstock.php",
				data: cadena,
				success: function(r) {
                        if (r == 1) {
						alertify.success("Agregado con exito");
                        $('#tablaDatatable').load('tablastock.php');
					} else {
						alertify.alert("Error al agregar", "Verifique sus datos ");
                        $('#tablaDatatable').load('tablastock.php');
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

</script>