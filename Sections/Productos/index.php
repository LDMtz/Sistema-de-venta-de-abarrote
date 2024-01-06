<?php
    include("../../Templates/Header.php");
    include("ScriptsProductos.php");
?>

<link rel="stylesheet" href="../../Libs/bootstrap.min.css"/>

<br>
<h1>SECCION PRODUCTOS</h1>
<br>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        Lista de Productos
        <div class="d-flex">
            <a class="btn btn-info me-2 text-white" href="ConsultarProducto.php" role="button">Consultar producto</a>
            <a class="btn btn-dark me-2 text-white" href="CodigoBarras.php" role="button">Codigo de Barras</a>
            <a class="btn btn-primary me-2 text-white" href="DescuentoProducto.php" role="button">Descuentos</a>
            <a class="btn btn-success ms-auto" href="RegistrarProducto.php" role="button">Agregar un nuevo producto</a>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Foto</th>
                        <th scope="col">Código de Barras</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Descripcion</th>
                        <th scope="col">Existencias</th>
                        <th scope="col">Precio Compra</th>
                        <th scope="col">Precio Venta</th>
                        <th scope="col">Categoria</th>
                        <th scope="col">Proveedor</th>
                        <th scope="col">Estado</th>
                        <th scope="col">Fecha de Registro</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody id="BodyTabla">
                    <!-- Cargamos todos los empleados -->
                    <?php include("ListarProductos.php");?>
                </tbody>
                
            </table>
        </div>
        
    </div>
</div>

<br>
<?php include("../../Templates/Footer.php"); ?>