<?php include("../../Templates/Header.php"); ?>
<?php
    include("../../Conexion.php");

    //Cargando el como box Rol
    $query="SELECT * FROM Rol";
    $resultado=mysqli_query($conexion,$query);

    if($resultado)
        while ($fila = mysqli_fetch_assoc($resultado))
            $listaRoles[] = $fila;

    // Registramos al empleado en la bd
    if ($_POST) {
        // Verificar que las claves sean iguales
        if ($_POST["Clave"] === $_POST["ClaveOk"]) {
            // Las claves son iguales, proceder con el registro
            $Nombre = isset($_POST["Nombre"]) ? $_POST["Nombre"] : "";
            $Correo = isset($_POST["Correo"]) ? $_POST["Correo"] : "";
            $Telefono = isset($_POST["Telefono"]) ? $_POST["Telefono"] : "";
            $Clave = isset($_POST["Clave"]) ? $_POST["Clave"] : "";
            $Foto = isset($_FILES["Foto"]["name"]) ? $_FILES["Foto"]["name"] : "";
            $Rol = isset($_POST["IdRol"]) ? $_POST["IdRol"]:"";
            $Estado = isset($_POST["Estado"]) ? $_POST["Estado"]:"";

            //Cambiandole el nombre a la foto fecha+nombre, por si hay repetidos
            $fecha_foto=new DateTime();
            $nombre_foto=($Foto!='')?$fecha_foto->getTimestamp()."_".$_FILES["Foto"]["name"]:"";
            $tmp_foto=$_FILES["Foto"]["tmp_name"];
            //Guardandola en la carpeta Fotos de empleados
            if($tmp_foto!=''){
                move_uploaded_file($tmp_foto,"./Fotos/".$nombre_foto);
            }else{
                // Si no se ha subido una foto, copiamos la foto predeterminada desde la carpeta "Images"
                $fotoPredeterminada = "../../Resources/Images/default-user.png"; // Ruta donde esta la foto predeterminada
                $nombre_foto=$fecha_foto->getTimestamp()."_defaultCopy.png";
                $destino = "./Fotos/" . $nombre_foto; // Ruta de destino para la foto predeterminada
                copy($fotoPredeterminada, $destino);
            }

            // Query para insertar en la base de datos
            $query = "INSERT INTO Empleados (Nombre,Correo,Telefono,Clave,Foto,IdRol,Estado)
                        VALUES ('$Nombre','$Correo','$Telefono','$Clave','$nombre_foto','$Rol','$Estado')";
            
            mysqli_query($conexion, $query);

            echo '<script type="text/javascript">
                swal("¡Empleado registrado!", "Haz registrado con exito a este empleado", "success");
                setTimeout(function(){
                    window.location.href = "index.php";
                }, 1500);
            </script>';
            
        } else {
            // Las claves no coinciden
            echo '<script type="text/javascript">
                swal("¡Error en las contraseñas!", "Ambas contraseñas deben coincidir", "error");
            </script>';
        }
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
            Datos del Empleado
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

                <div class="mb-3">
                  <label for="Clave" class="form-label fw-bold">Contraseña:</label>
                  <input type="password"
                    class="form-control" name="Clave" id="Clave" aria-describedby="helpId" placeholder="Contraseña" required>
                </div>

                <div class="mb-3">
                  <label for="ClaveOk" class="form-label fw-bold">Confirmar Contraseña:</label>
                  <input type="password"
                    class="form-control" name="ClaveOk" id="ClaveOk" aria-describedby="helpId" placeholder="Contraseña" required>
                </div>

                <div class="mb-3">
                  <label for="Foto" class="form-label fw-bold">Foto:</label>
                  <input type="file"
                    class="form-control" name="Foto" id="Foto" aria-describedby="helpId" placeholder="Foto">
                </div>

                <div class="mb-3">
                    <label for="IdRol" class="form-label fw-bold">Rol:</label>
                    <select class="form-select form-select-sm" name="IdRol" id="IdRol">
                        <?php foreach ($listaRoles as $registro){?>
                            <option value="<?php echo $registro['IdRol']?>">
                                <?php echo $registro['NombreRol']?>
                            </option>
                        <?php }?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="Estado" class="form-label fw-bold">Estado:</label>
                    <select class="form-select form-select-sm" name="Estado" id="Estado">
                        <option value="1">Activo</option>
                        <option value="0">Inactivo</option>
                    </select>
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