<?php
    include("ScriptsProveedores.php");
    include("../../Templates/Header.php");
?>

<link rel="stylesheet" href="../../Libs/bootstrap.min.css"/>

<br>
<h1>SECCION PROVEEDORES</h1>
<br>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        Lista de Proveedores
        <div class="d-flex">
            <a class="btn btn-info me-2 text-white" href="ConsultarProveedor.php" role="button">Consultar proveedor</a>
            <a class="btn btn-success ms-auto" href="RegistrarProveedor.php" role="button">Agregar un nuevo registro</a>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Correo</th>
                        <th scope="col">Telefono</th>
                        <th scope="col">Fecha de Registro</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody id="BodyTabla">
                    <!-- Cargamos todos los empleados -->
                    <?php include("ListarProveedores.php");?>
                </tbody>
                
            </table>
        </div>
        
    </div>
</div>

<br>
<?php include("../../Templates/Footer.php"); ?>