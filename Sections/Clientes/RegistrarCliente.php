<?php include("../../Templates/Header.php"); ?>
<?php
    include("../../Conexion.php");

    // Registramos al cliente en la bd
    if ($_POST) {
        // Las claves son iguales, proceder con el registro
        $Nombre = isset($_POST["Nombre"]) ? $_POST["Nombre"] : "";
        $Correo = isset($_POST["Correo"]) ? $_POST["Correo"] : "";
        $Telefono = isset($_POST["Telefono"]) ? $_POST["Telefono"] : "";

        // Query para insertar en la base de datos
        $query = "INSERT INTO Clientes (Nombre,Correo,Telefono)
                    VALUES ('$Nombre','$Correo','$Telefono')";
        
        mysqli_query($conexion, $query);
        echo '<script type="text/javascript">
                swal("¡Cliente registrado!", "Haz registrado con exito a este cliente", "success");
                setTimeout(function(){
                    window.location.href = "index.php";
                }, 1500);
            </script>';
    }
    mysqli_close($conexion);
?>

<link rel="stylesheet" href="../../Libs/bootstrap.min.css"/>


<br>
<h1>REGISTRAR EMPLEADO</h1>
<br>

<div class="container d-flex justify-content-center align-items-center">

    <div class="card col-6">
        <div class="card-header">
            Datos del Cliente
        </div>
        <div class="card-body">
            <form action="" method="POST" enctype="multipart/form-data">

                <div class="mb-3">
                <label for="Nombre" class="form-label fw-bold">Nombre:</label>
                <input type="text"
                    class="form-control" name="Nombre" id="Nombre" aria-describedby="helpId" placeholder="Nombre y Apellido" required>
                </div>

                <div class="mb-3">
                <label for="Correo" class="form-label fw-bold">Correo:</label>
                <input type="email"
                    class="form-control" name="Correo" id="Correo" aria-describedby="helpId" placeholder="Correo">
                </div>

                <div class="mb-3">
                  <label for="Telefono" class="form-label fw-bold">Telefono:</label>
                  <input type="text"
                    class="form-control" name="Telefono" id="Telefono" aria-describedby="helpId" placeholder="Telefono">
                </div>
                
                <div class="d-flex justify-content-center mb-1">
                    <button type="submit" class="btn btn-success me-5">Registrar</button>
                    <a name="" id="" class="btn btn-danger" href="index.php" role="button">Cancelar</a>
                </div>
            </form>
        </div>

        <div class="card-footer text-muted"></div>

    </div>
    
</div>

<br>

<?php include("../../Templates/Footer.php"); ?>