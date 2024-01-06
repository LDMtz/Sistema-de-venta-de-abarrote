<?php
    include("../../Conexion.php");

    //CARGAR EL EMPLEADO EN LOS INPUTS
    if(isset($_GET['txtID'])){
        $txtID=(isset($_GET['txtID']))?$_GET['txtID']:"";

        //Cargando los datos del empleado
        $query="SELECT * FROM Empleados WHERE IdEmpleado='$txtID'";
        $resultado=mysqli_query($conexion,$query);
        
        if($resultado)
        while ($fila = mysqli_fetch_assoc($resultado))
            $datosEmpleado = $fila;// Agregar la fila actual

        //Cargando los roles
        $query="SELECT * FROM Rol";
        $resultado=mysqli_query($conexion,$query);

        if($resultado)
        while ($fila = mysqli_fetch_assoc($resultado))
            $listaRoles[] = $fila;
    }

    //Modificamos al empleado
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

            $Id=(isset($_POST['Id'])?$_POST['Id']:"");

            //Cambiandole el nombre a la foto fecha+nombre, por si hay repetidos
            $fecha_foto=new DateTime();
            $nombre_foto=($Foto!='')?$fecha_foto->getTimestamp()."_".$_FILES["Foto"]["name"]:"";
            $tmp_foto=$_FILES["Foto"]["tmp_name"];
            //Actualizando solo la foto
            if($tmp_foto!=''){
                //Buscando la foto relacionada con el Empleado para borrarl la antigua, en caso de actualizar foto
                $querySelectFoto="SELECT Foto FROM Empleados WHERE IdEmpleado='$txtID'";
                $resultado=mysqli_query($conexion,$querySelectFoto);
                if($resultado)
                while ($fila = mysqli_fetch_assoc($resultado))
                    $registro_recuperado = $fila;
                
                if($registro_recuperado["Foto"] && $registro_recuperado["Foto"]!=""){
                    if(file_exists("Fotos/".$registro_recuperado["Foto"])){
                        unlink("Fotos/".$registro_recuperado["Foto"]);
                    }
                }

                move_uploaded_file($tmp_foto,"./Fotos/".$nombre_foto);
                //Actualizar solo la foto
                $queryFoto = "UPDATE Empleados SET Foto='$nombre_foto' WHERE IdEmpleado ='$Id'";
                mysqli_query($conexion, $queryFoto);
            }

            

            // Query para Actualizar al empleado en la base de datos
            $query = "UPDATE Empleados SET Nombre='$Nombre', Correo='$Correo',Telefono='$Telefono',
                            Clave='$Clave',IdRol='$Rol',Estado='$Estado'
                            WHERE IdEmpleado ='$Id'";
            
            $resultado = mysqli_query($conexion, $query);
            if($resultado){
                echo '<script type="text/javascript">
                    swal("Empleado Acutalizado!", "Este empleado ha sido actualizado correctamente", "success");
                    setTimeout(function(){
                        window.location.href = "index.php";
                    }, 1500);
                </script>';
            }
            else{
                echo '<script type="text/javascript">
                    swal("¡Ha ocurrido un error!", "Este empleado no se ha podido actualizar, verifica que todos los datos sean correctos", "error");
                </script>';
            }
        } else {
            // Las claves no coinciden, mostrar un mensaje de error
            echo '<script type="text/javascript">
                swal("¡Error en las contraseñas!", "Ambas contraseñas deben coincidir", "error");
            </script>';
        }
    }
    mysqli_close($conexion);
?>