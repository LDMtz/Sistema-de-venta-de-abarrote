<?php
    include("../../Conexion.php");
    
    //PARA ELIMINAR A UN PRODUCTO DE LA BASE DE DATOS

    $response = array();

    if($_POST){
        $txtID=(isset($_POST['txtID']))?$_POST['txtID']:"";
        $Descuento=(isset($_POST['txtDescuento']))?$_POST['txtDescuento']:"";

        if($Descuento == ""){
            $response['title'] = '¡No se ha podido empezar el descuento!';
            $response['success'] = false;
            $response['message'] = 'Asegurate de no dejar ningun campo vacio';
            echo json_encode($response);
            return 0;
        }
        //Registrando el descuento a la Base de Datos
        $query="INSERT INTO Producto_Descuento (IdProducto,Descuento)
        VALUES ('$txtID','$Descuento')";
        $resultado = mysqli_query($conexion,$query);

        if($resultado){
            $response['title'] = '¡Haz iniciado un nuevo descuento!';
            $response['success'] = true;
            $response['message'] = 'El descuento se ha realizado con exito';
        }

    }
    mysqli_close($conexion);
    echo json_encode($response);
?>