<?php
    session_start();
    include("../../Conexion.php");

    $response = array();
    if(isset($_POST['monto_apertura'])){
        $montoApertura=(isset($_POST['monto_apertura']))?$_POST['monto_apertura']:"";

        if($montoApertura != ""){ // Si el post contiene algo
            $query = "INSERT INTO Caja (Estado,MontoActual,EmpleadoApertura, MontoApertura)
            VALUES (1,'$montoApertura','{$_SESSION['IdEmpleado']}','$montoApertura')";
            mysqli_query($conexion,$query);

            $query2 ="SELECT IdCaja FROM Caja WHERE Estado = 1";
            $resultado=mysqli_query($conexion,$query2);
            if($resultado){
                $fila_caja = mysqli_fetch_assoc($resultado);   
                $_SESSION['IdCaja'] = $fila_caja['IdCaja'];

                $query = "INSERT INTO Movimiento_Caja (IdCaja,TipoMov,MontoMov, EmpleadoMov)
                VALUES ('{$_SESSION['IdCaja']}',1,'$montoApertura',{$_SESSION['IdEmpleado']})";
                mysqli_query($conexion,$query);
            }

            $response['success'] = true;
            $response['title'] = '¡Caja abierta';
            $response['message'] = 'Haz abierto la caja correctamente';
            $response['type'] = 'success';

        }else{ //Si el post esta vacio
            $response['success'] = false;
            $response['title'] = '¡Error al abrir la caja';
            $response['message'] = 'Debes ingresar una cantidad en el monto de apertura';
            $response['type'] = 'error';
        }
    }
    
    echo json_encode($response);
    mysqli_close($conexion);
?>

