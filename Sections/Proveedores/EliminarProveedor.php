<?php
    include("../../Conexion.php");
    //PARA ELIMINAR A UN PROVEEDOR DE LA BASE DE DATOS
    if(isset($_POST['txtID'])){
        $txtID=(isset($_POST['txtID']))?$_POST['txtID']:"";

        $response = array();
        
        //Borrando al CLIENTE de la base de datos
        $query="DELETE FROM Proveedores WHERE IdProveedor='$txtID'";
        mysqli_query($conexion,$query);

        $response['title'] = '¡Proveedor eliminado!';
        $response['success'] = true;
        $response['message'] = 'El proveedor con el ID: '.$txtID.', ha sido eliminado correctamente';
    }
    mysqli_close($conexion);
    echo json_encode($response);
?>