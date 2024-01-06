<?php
    include("../../Conexion.php");
    //PARA ELIMINAR A UN USUARIO DE LA BASE DE DATOS
    if(isset($_POST['txtID'])){
        $response = array();
        $txtID=(isset($_POST['txtID']))?$_POST['txtID']:"";

        //Buscando la foto relacionada con el Empleado para borrarla tambien
        $query="SELECT Foto FROM Empleados WHERE IdEmpleado='$txtID'";
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
        $query="DELETE FROM Empleados WHERE IdEmpleado='$txtID'";
        mysqli_query($conexion,$query);

        $response['title'] = '¡Empleado eliminado!';
        $response['success'] = true;
        $response['message'] = 'El empleado con el ID: '.$txtID.', ha sido eliminado correctamente';
    }
    mysqli_close($conexion);
    echo json_encode($response);
?>