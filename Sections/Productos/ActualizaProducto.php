
<?php
    include("../../Conexion.php");
    

    //CARGAR EL PRODUCTO EN LOS INPUTS
    if(isset($_GET['txtID'])){
        $txtID=(isset($_GET['txtID']))?$_GET['txtID']:"";

        //Cargando los datos del producto
        $query="SELECT * FROM Productos WHERE IdProducto='$txtID'";
        $resultado=mysqli_query($conexion,$query);
        
        if($resultado)
        while ($fila = mysqli_fetch_assoc($resultado))
            $datosProducto = $fila;// Agregar la fila actual

        //Cargando los proveedores
        $query="SELECT * FROM Proveedores";
        $resultado=mysqli_query($conexion,$query);
        if($resultado)
        while ($fila = mysqli_fetch_assoc($resultado))
            $listaProveedores[] = $fila;

        //Cargando las categorias
        $query="SELECT * FROM Categorias";
        $resultado=mysqli_query($conexion,$query);
        if($resultado)
        while ($fila = mysqli_fetch_assoc($resultado))
            $listaCategorias[] = $fila;
    }

    //Modificamos al empleado
    if ($_POST) {
        $CodigoBarras = isset($_POST["CodigoBarras"]) ? $_POST["CodigoBarras"] : "";
        $Nombre = isset($_POST["Nombre"]) ? $_POST["Nombre"] : "";
        $Descripcion = isset($_POST["Descripcion"]) ? $_POST["Descripcion"] : "";
        $IdCategoria = isset($_POST["IdCategoria"]) ? $_POST["IdCategoria"] : "";
        $Foto = isset($_FILES["Foto"]["name"]) ? $_FILES["Foto"]["name"] : "";
        $IdProveedor = isset($_POST["IdProveedor"]) ? $_POST["IdProveedor"]:"";
        $PrecioCompra = isset($_POST["PrecioCompra"]) ? $_POST["PrecioCompra"]:"";
        $PrecioVenta = isset($_POST["PrecioVenta"]) ? $_POST["PrecioVenta"]:"";
        $Estado = isset($_POST["Estado"]) ? $_POST["Estado"]:"";

        $Id=(isset($_POST['Id'])?$_POST['Id']:"");

        //Cambiandole el nombre a la foto fecha+nombre, por si hay repetidos
        $fecha_foto=new DateTime();
        $nombre_foto=($Foto!='')?$fecha_foto->getTimestamp()."_".$_FILES["Foto"]["name"]:"";
        $tmp_foto=$_FILES["Foto"]["tmp_name"];
        //Actualizando solo la foto
        if($tmp_foto!=''){
            //Buscando la foto relacionada con el Producto para borrarl la antigua, en caso de actualizar foto
            $querySelectFoto="SELECT Foto FROM Productos WHERE IdProducto='$txtID'";
            $resultado=mysqli_query($conexion,$querySelectFoto);
            if($resultado)
            while ($fila = mysqli_fetch_assoc($resultado))
                $registro_recuperado = $fila;
            
            if($registro_recuperado["Foto"] && $registro_recuperado["Foto"]!=""){
                if(file_exists("Fotos/".$registro_recuperado["Foto"])){
                    unlink("Fotos/".$registro_recuperado["Foto"]);
                }
            }

            move_uploaded_file($tmp_foto,"./Fotos/".$nombre_foto);
            //Actualizar solo la foto
            $queryFoto = "UPDATE Productos SET Foto='$nombre_foto' WHERE IdProducto ='$Id'";
            mysqli_query($conexion, $queryFoto);
        }

        

        // Query para Actualizar al producto en la base de datos
        $query = "UPDATE Productos SET CodigoBarras='$CodigoBarras', Nombre='$Nombre',Descripcion='$Descripcion',
                        IdCategoria='$IdCategoria',IdProveedor='$IdProveedor',Estado='$Estado', PrecioCompra='$PrecioCompra',
                        PrecioVenta='$PrecioVenta' WHERE IdProducto ='$Id'";
        
        $resultado = mysqli_query($conexion, $query);
        if($resultado){
            echo '<script type="text/javascript">
                swal("¡Producto Acutalizado!", "Este producto ha sido actualizado correctamente", "success");
                setTimeout(function(){
                    window.location.href = "index.php";
                }, 1500);
            </script>';
        }
        else{
            echo '<script type="text/javascript">
                swal("¡Ha ocurrido un error!", "Este producto no se ha podido actualizar, verifica que todos los datos sean correctos", "error");
            </script>';
        }
    }
    mysqli_close($conexion);
    
?>

