<?php
    include("../../Conexion.php");
    //PARA ELIMINAR A UN PRODUCTO DE LA BASE DE DATOS
    if(isset($_POST['txtID'])){
        $txtID=(isset($_POST['txtID']))?$_POST['txtID']:"";
        
        //Borrando al empleado de la base de datos
        $query="DELETE FROM Producto_Descuento WHERE IdDescuento='$txtID'";
        mysqli_query($conexion,$query);

        $response['title'] = '¡Descuento terminado!';
        $response['success'] = true;
        $response['message'] = 'Se ha terminado este descuento';
    }
    mysqli_close($conexion);
    echo json_encode($response);
?>