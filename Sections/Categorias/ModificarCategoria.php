<?php include("../../Templates/Header.php"); ?>
<?php include("ActualizaCategoria.php"); ?>

<link rel="stylesheet" href="../../Libs/bootstrap.min.css"/>


<br>
<h1>MODIFICAR CATEGORIA</h1>
<br>

<div class="container d-flex justify-content-center align-items-center">

    <div class="card col-6">
        <div class="card-header">
            Datos de la Categoria
        </div>
        <div class="card-body">
            <form action="" method="POST" enctype="multipart/form-data">

                <div class="mb-3">
                    <label for="Id" class="form-label fw-bold">ID (No se puede modificar):</label>
                    <input type="text" value="<?php echo $datosCategoria['IdCategoria']?>"
                        class="form-control" name="Id" id="Id" aria-describedby="helpId" placeholder="Id" readonly>
                </div>

                <div class="mb-3">
                    <label for="Nombre" class="form-label fw-bold">Nombre:</label>
                    <input type="text" value="<?php echo $datosCategoria['Nombre']?>"
                        class="form-control" name="Nombre" id="Nombre" aria-describedby="helpId" placeholder="Nombre de la categoria" required>
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