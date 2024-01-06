<?php include("../../Templates/Header.php"); ?>
<?php include("ActualizaProveedor.php"); ?>

<link rel="stylesheet" href="../../Libs/bootstrap.min.css"/>


<br>
<h1>MODIFICAR PROVEEDOR</h1>
<br>

<div class="container d-flex justify-content-center align-items-center">

    <div class="card col-6">
        <div class="card-header">
            Datos del Proveedor
        </div>
        <div class="card-body">
            <form action="" method="POST" enctype="multipart/form-data">

                <div class="mb-3">
                    <label for="Id" class="form-label fw-bold">ID (No se puede modificar):</label>
                    <input type="text" value="<?php echo $datosProveedor['IdProveedor']?>"
                        class="form-control" name="Id" id="Id" aria-describedby="helpId" placeholder="Id" readonly>
                </div>

                <div class="mb-3">
                    <label for="Nombre" class="form-label fw-bold">Nombre:</label>
                    <input type="text" value="<?php echo $datosProveedor['Nombre']?>"
                        class="form-control" name="Nombre" id="Nombre" aria-describedby="helpId" placeholder="Nombre y Apellido" required>
                </div>

                <div class="mb-3">
                    <label for="Correo" class="form-label fw-bold">Correo:</label>
                    <input type="email" value="<?php echo $datosProveedor['Correo']?>"
                        class="form-control" name="Correo" id="Correo" aria-describedby="helpId" placeholder="Correo">
                </div>

                <div class="mb-3">
                    <label for="Telefono" class="form-label fw-bold">Telefono:</label>
                    <input type="text" value="<?php echo $datosProveedor['Telefono']?>"
                        class="form-control" name="Telefono" id="Telefono" aria-describedby="helpId" placeholder="Telefono">
                </div>
                
                <div class="d-flex justify-content-center mb-1">
                    <button type="submit" class="btn btn-info me-5">Actualizar</button>
                    <a name="" id="" class="btn btn-danger" href="index.php" role="button">Cancelar</a>
                </div>
            </form>
        </div>

        <div class="card-footer text-muted"></div>

    </div>
    
</div>

<br>

<?php include("../../Templates/Footer.php"); ?>