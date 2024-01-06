<link rel="stylesheet" href="../../Libs/bootstrap.min.css"/>
<?php include("../../Templates/Header.php"); ?>
<?php include("ScriptsProductos.php"); ?>

<br>
<h1> PRODUCTOS - DESCUENTOS </h1>
<br>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        Lista de descuentos activos:
        <div class="d-flex">
            <a class="btn btn-success ms-auto" href="EmpezarDescuento.php" role="button">Empezar nuevo descuento</a>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Foto</th>
                        <th scope="col">Codigo</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Descripcion</th>
                        <th scope="col">Precio normal</th>
                        <th scope="col">Precio final</th>
                        <th scope="col">Descuento</th>
                        <th scope="col">Fecha de Inicio</th>
                        <th scope="col">Accion</th>
                    </tr>
                </thead>
                <tbody id="BodyTabla">
                    <!-- Cargamos todos los empleados -->
                    <?php include("ListarDescuentos.php");?>
                </tbody>
                
            </table>
        </div>
    </div>
    <div class="card-footer text-muted d-flex justify-content-end">
        <a name="" id="" class="btn btn-primary" href="index.php" role="button">Regresar</a>
    </div>
</div>


<br>
<?php include("../../Templates/Footer.php"); ?>