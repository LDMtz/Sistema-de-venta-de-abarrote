<?php
    include("../../Conexion.php");

    //CARGAR LA CATEGORIA EN LOS INPUTS
    if(isset($_GET['txtID'])){
        $txtID=(isset($_GET['txtID']))?$_GET['txtID']:"";

        //Cargando los datos del cliente
        $query="SELECT * FROM Categorias WHERE IdCategoria='$txtID'";
        $resultado=mysqli_query($conexion,$query);
        
        if($resultado)
        while ($fila = mysqli_fetch_assoc($resultado))
            $datosCategoria = $fila;// Agregar la fila actual
    }

    //Modificamos al cliente
    if ($_POST) {
        // Las claves son iguales, proceder con el registro
        $Nombre = isset($_POST["Nombre"]) ? $_POST["Nombre"] : "";

        $Id=(isset($_POST['Id'])?$_POST['Id']:"");

        // Query para Actualizar al cliente en la base de datos
        $query = "UPDATE Categorias SET Nombre='$Nombre' WHERE IdCategoria ='$Id'";
        
        $resultado = mysqli_query($conexion, $query);

        if($resultado){
            echo '<script type="text/javascript">
                swal("¡Categoria acutalizada!", "Esta categoria ha sido actualizada correctamente", "success");
                setTimeout(function(){
                    window.location.href = "index.php";
                }, 1500);
            </script>';
        }
        else{
            echo '<script type="text/javascript">
                swal("¡Ha ocurrido un error!", "Esta categoria no se ha podido actualizar, verifica que todos los datos sean correctos", "error");
            </script>';
        }
    }
    mysqli_close($conexion);
?>