<?php
    include("../../Conexion.php");

    //CARGAR EL EMPLEADO EN LOS INPUTS
    if(isset($_GET['txtID'])){
        $txtID=(isset($_GET['txtID']))?$_GET['txtID']:"";

        //Cargando los datos del cliente
        $query="SELECT * FROM Clientes WHERE IdCliente='$txtID'";
        $resultado=mysqli_query($conexion,$query);
        
        if($resultado)
        while ($fila = mysqli_fetch_assoc($resultado))
            $datosCliente = $fila;// Agregar la fila actual
    }

    //Modificamos al cliente
    if ($_POST) {
        // Las claves son iguales, proceder con el registro
        $Nombre = isset($_POST["Nombre"]) ? $_POST["Nombre"] : "";
        $Correo = isset($_POST["Correo"]) ? $_POST["Correo"] : "";
        $Telefono = isset($_POST["Telefono"]) ? $_POST["Telefono"] : "";

        $Id=(isset($_POST['Id'])?$_POST['Id']:"");

        // Query para Actualizar al cliente en la base de datos
        $query = "UPDATE Clientes SET Nombre='$Nombre', Correo='$Correo',Telefono='$Telefono' WHERE IdCliente ='$Id'";
        
        $resultado = mysqli_query($conexion, $query);
        if($resultado){
            echo '<script type="text/javascript">
                swal("¡Cliente acutalizado!", "Esta cliente ha sido actualizado correctamente", "success");
                setTimeout(function(){
                    window.location.href = "index.php";
                }, 1500);
            </script>';
        }
        else{
            echo '<script type="text/javascript">
                swal("¡Ha ocurrido un error!", "Este cliente no se ha podido actualizar, verifica que todos los datos sean correctos", "error");
            </script>';
        }
    }
    mysqli_close($conexion);
?>