<?php

require_once "php/conexion.php";

$conexion = conexion();

// lleno la tabla

$obj = new conectar();

$conexion1 = $obj->conexion();

$sql1 = "SELECT * from stock inner join fam_stock on stock.fam=fam_stock.id";


mysqli_query($conexion1,"SET NAMES 'utf8'");

$result = mysqli_query($conexion1, $sql1);

?>

<div>
    <table class="table table-hover table-condensed table-bordered table-sm" id="iddatatablestock" style="background-color: #E1F9F4 ">
        <thead style="background-color: #0062a3;color: white; font-weight: bold;">
            <tr>
                <td>Famila</td>
                <td>Codigo</td>
                <td>Descripcion</td>
                <td>C.H.A.S</td>
                <td>Cantidad</td>
                <td>Precio</td>
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
                        <td><?php echo $mostrar[12] ?></td>
                        <td><?php echo $mostrar[1] ?></td>
                        <td><?php echo $mostrar[2] ?></td>
                        <td><?php echo $mostrar[6] ?></td>
                        <td><?php echo $mostrar[3] ?></td>
                        <td><?php echo $mostrar[4] ?></td>

                        <td style="text-align: center;">
                            <span class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalEditar" onclick="agregaform('<?php echo $datos ?>')">
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
        $('#iddatatablestock').DataTable();
    });


    $('#iddatatablestock').dataTable({

        "pageLength": 50,
        "paging": false,
        "order": [
            [2, "asc"]
        ],
        "info": false,
        "searching": true,
        language: {
            "emptyTable": "Sin stock",
            search: 'Buscar'
        }
    });

    function eliminarDatos(idcarga) {
        alertify.confirm('Eliminar producto', '¿Seguro de eliminar este producto?', function() {

            $.ajax({
                type: "POST",
                data: "idcarga=" + idcarga,
                url: "procesos/eliminarstock.php",
                success: function(r) {
                    if (r == 1) {
                        alertify.success("Eliminado con exito");
                        $('#tablaDatatable').load('tablastock.php');
                    } else {
                        alertify.error("No se pudo eliminar");
                    }
                }
            });

        }, function() {

        });
    }
</script>