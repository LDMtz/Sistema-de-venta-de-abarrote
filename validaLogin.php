<?php 
        include("Conexion.php");
        session_start();
        if($_POST){
            $response = array();

            $Empleado=(isset($_POST['Id']))?$_POST['Id']:"";
            $Password=(isset($_POST['password']))?$_POST['password']:"";

            $query="SELECT *, count(*) as n_empleados FROM Empleados WHERE IdEmpleado='$Empleado' AND Clave='$Password'";
            $resultado=mysqli_query($conexion,$query); 

            $query2 = "SELECT IdCaja FROM Caja WHERE Estado = 1";
            $resultado_caja = mysqli_query($conexion, $query2);

            if ($resultado_caja) {
                $fila_caja = mysqli_fetch_assoc($resultado_caja);
                if ($fila_caja != "") {
                    $_SESSION['IdCaja'] = $fila_caja['IdCaja'];
                }
                else{
                    $_SESSION['IdCaja'] = "No hay caja activa";
                }
            }
            

            if($resultado)
                while ($fila = mysqli_fetch_assoc($resultado))
                    $registro= $fila;

            if($registro["n_empleados"]>0){

                //Datos del usuario activo
                $_SESSION['IdEmpleado']=$registro["IdEmpleado"];
                $_SESSION['Nombre']=$registro["Nombre"];
                $_SESSION['Foto']=$registro["Foto"];
                $_SESSION['carritoV'] = array();
                $_SESSION['descuentoCarritoV'] = 0;
                $_SESSION['totalCarritoV'] = 0;

                $response['title'] = '¡Correcto!';
                $response['message'] = '¡Haz iniciado sesión correctamente!';
                $response['type'] = "success";
                $response['success'] = true;

            }
            else{
                $response['title'] = 'Error!';
                $response['message'] = '¡El usuario o la contraseña son incorrectos!';
                $response['type'] = "error";
                $response['success'] = false;
            }
            echo json_encode($response);
        }
        mysqli_close($conexion);
    ?>