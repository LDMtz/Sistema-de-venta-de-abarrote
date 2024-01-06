<?php
    include("../../Conexion.php");
    //PARA ELIMINAR A UN CLIENTE DE LA BASE DE DATOS
    if(isset($_POST['txtID'])){
        $response = array();
        $txtID=(isset($_POST['txtID']))?$_POST['txtID']:"";
        
        //Borrando al CLIENTE de la base de datos
        $query="DELETE FROM Clientes WHERE IdCliente='$txtID'";
        mysqli_query($conexion,$query);

        $response['title'] = '¡Cliente eliminado!';
        $response['success'] = true;
        $response['message'] = 'El cliente con el ID: '.$txtID.', ha sido eliminado correctamente';
    }
    mysqli_close($conexion);
    echo json_encode($response);
?>