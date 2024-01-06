<?php
    include("../../Conexion.php");
    //PARA ELIMINAR UNA CATEGORIA DE LA BASE DE DATOS
    if(isset($_POST['txtID'])){
        $response = array();
        
        $txtID=(isset($_POST['txtID']))?$_POST['txtID']:"";
        
        //Borrando al CLIENTE de la base de datos
        $query="DELETE FROM Categorias WHERE IdCategoria='$txtID'";
        mysqli_query($conexion,$query);

        $response['title'] = '¡Categoria eliminada!';
        $response['success'] = true;
        $response['message'] = 'La categoria con el ID: '.$txtID.', ha sido eliminada correctamente';
    }
    mysqli_close($conexion);
    echo json_encode($response);
?>