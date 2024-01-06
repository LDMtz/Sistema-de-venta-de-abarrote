<?php
    include("../../Conexion.php");

    //CARGAR EL PROVEEDOR EN LOS INPUTS
    if(isset($_GET['txtID'])){
        $txtID=(isset($_GET['txtID']))?$_GET['txtID']:"";

        //Cargando los datos del proveedor
        $query="SELECT * FROM Proveedores WHERE IdProveedor='$txtID'";
        $resultado=mysqli_query($conexion,$query);
        
        if($resultado)
        while ($fila = mysqli_fetch_assoc($resultado))
            $datosProveedor = $fila;// Agregar la fila actual

    }

    //Modificamos al proveedor
    if ($_POST) {
        // Las claves son iguales, proceder con el registro
        $Nombre = isset($_POST["Nombre"]) ? $_POST["Nombre"] : "";
        $Correo = isset($_POST["Correo"]) ? $_POST["Correo"] : "";
        $Telefono = isset($_POST["Telefono"]) ? $_POST["Telefono"] : "";

        $Id=(isset($_POST['Id'])?$_POST['Id']:"");

        // Query para Actualizar al proveedor en la base de datos
        $query = "UPDATE Proveedores SET Nombre='$Nombre', Correo='$Correo',Telefono='$Telefono' WHERE IdProveedor ='$Id'";
        
        $resultado = mysqli_query($conexion, $query);
        if($resultado){
            echo '<script type="text/javascript">
                swal("¡Proveedor acutalizado!", "Esta proveedor ha sido actualizado correctamente", "success");
                setTimeout(function(){
                    window.location.href = "index.php";
                }, 1500);
            </script>';
        }
        else{
            echo '<script type="text/javascript">
                swal("¡Ha ocurrido un error!", "Esta proveedor no se ha podido actualizar, verifica que todos los datos sean correctos", "error");
            </script>';
        }
    }
    mysqli_close($conexion);
?>