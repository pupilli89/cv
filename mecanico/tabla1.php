<?php

require_once "php/conexion.php";

$conexion = conexion();

// lleno la tabla

$obj = new conectar();

$conexion1 = $obj->conexion();

$sql1 = "SELECT *  from cod_reparacion";

mysqli_query($conexion1, "SET NAMES 'utf8'");

$result = mysqli_query($conexion1, $sql1);

?>


<div class="modal fade" id="modalEditar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modiciar codigo de Repacion</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                <div class="form-group">
                        <input type="text" class="form-control" id="recipient-name8" hidden>
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Familia:</label>
                        <input type="text" class="form-control" id="recipient-name5">
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Codigo:</label>
                        <input type="text" class="form-control" id="recipient-name6">
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Descripcion:</label>
                        <input type="text" class="form-control" id="recipient-name7">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="btnActualizar" data-dismiss="modal">Guardar</button>
            </div>
        </div>
    </div>
</div>

<div>
    <table class="table table-hover table-condensed table-bordered table-sm" id="iddatatable1" style="background-color: #E1F9F4 ">
        <thead style="background-color: #0062a3;color: white; font-weight: bold;">
            <tr>
                <td>Famila</td>
                <td>Codigo</td>
                <td>Descripcion</td>
                <td>Modificar</td>
                <td>Eliminar</td>

            </tr>
        </thead>
        <tbody>
            <?php if (isset($result)) {
                while ($mostrar = mysqli_fetch_row($result)) {

                    $datos = $mostrar[0] . "||" .
                        $mostrar[1] . "||" .
                        $mostrar[2] . "||" .
                        $mostrar[3];
            ?>
                    <tr>
                        <td><?php echo $mostrar[2] ?></td>
                        <td><?php echo $mostrar[1] ?></td>
                        <td><?php echo $mostrar[3] ?></td>

                        <td style="text-align: center;">
                            <span class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalEditar" onclick="agregaform('<?php echo $datos; ?>')">
                                <span class="fa fa-pencil-square-o"></span>
                            </span>
                        </td>
                        <td style="text-align: center;">
                            <span class="btn btn-danger btn-sm" onclick="eliminarDatos('<?php echo $mostrar[0]; ?>')">
                                <span class="fa fa-trash"></span>
                            </span>
                        </td>
                    </tr>
            <?php
                }
            }
            ?>
        </tbody>
    </table>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('#iddatatable1').DataTable();
    });

    $('#btnActualizar').click(function(){
			
			actualizaDatos();
		});


    $('#iddatatable1').dataTable({

        "pageLength": 50,
        "paging": true,
        "order": [
            [2, "asc"]
        ],
        "info": false,
        "searching": true,
        language: {
            "emptyTable": "Sin codigo",
            "search": "Buscar:",
            "paginate": {
                "first": "Primero",
                "last": "Último",
                "next": "Siguiente",
                "previous": "Anterior",
            },

        }
    });

    function eliminarDatos(idcarga) {
        alertify.confirm('Eliminar Codigo repacion', '¿Seguro de eliminar este codigo de operacion?', function() {

            $.ajax({
                type: "POST",
                data: "idcarga=" + idcarga,
                url: "procesos/eliminarcodrepa.php",
                success: function(r) {
                    if (r == 1) {
                        $('#tablaDatatable1').load('tabla1.php');
                        alertify.success("Eliminado con exito");
                    } else {
                        alertify.error("No se pudo eliminar");
                    }
                }
            });

        }, function() {

        });
    }

    function actualizaDatos(){

        fam = $('#recipient-name5').val();
        cod = $('#recipient-name6').val();
        desc = $('#recipient-name7').val();
        id = $('#recipient-name8').val();


        cadena = "familia=" + fam +
            "&codigo=" + cod +
            "&id=" + id +
            "&descripcion=" + desc;

        $.ajax({
            type: "POST",
            url: "procesos/actualizarrep.php",
            data: cadena,
            success: function(r) {
                if (r == 1) {
                    $('#tablaDatatable1').load('tabla1.php');
                    alertify.success("Actualizacion correcta");
                } else {
                    alertify.alert("Actualizar", "Fallo la carga");
                }
            }
        });
    }


    function agregaform(datos) { //Funcion para obtener los datos en el formulario de act

        d = datos.split('||');

        $('#recipient-name5').val(d[2]);
        $('#recipient-name6').val(d[1]); 
        $('#recipient-name7').val(d[3]); 
        $('#recipient-name8').val(d[0]);
    }


</script>