<?php
    //PARA ELIMINAR A UN PRODUCTO DE LA BASE DE DATOS
    if(isset($_POST['txtID'])){
        include("../../Conexion.php");
        $response = array();
        $txtID=(isset($_POST['txtID']))?$_POST['txtID']:"";

        //Buscando la foto relacionada con el Empleado para borrarla tambien
        $query="SELECT Foto FROM Productos WHERE IdProducto='$txtID'";
        $resultado=mysqli_query($conexion,$query);

        if($resultado)
        while ($fila = mysqli_fetch_assoc($resultado))
            $registro_recuperado = $fila;
        
        //Borrar la foto
        if($registro_recuperado["Foto"] && $registro_recuperado["Foto"]!=""){
            if(file_exists("Fotos/".$registro_recuperado["Foto"])){
                unlink("Fotos/".$registro_recuperado["Foto"]);
            }
        }
        
        //Borrando al empleado de la base de datos
        $query="DELETE FROM Productos WHERE IdProducto='$txtID'";
        mysqli_query($conexion,$query);

        $response['title'] = '¡Producto eliminado!';
        $response['success'] = true;
        $response['message'] = 'El producto con el ID: '.$txtID.', ha sido eliminado correctamente';
        
        mysqli_close($conexion);
        echo json_encode($response);
    }
?>