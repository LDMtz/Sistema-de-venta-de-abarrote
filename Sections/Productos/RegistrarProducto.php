<?php include("../../Templates/Header.php"); ?>
<?php
    include("../../Conexion.php");

    //Cargando las categorias en una lista para el combo box
    $query="SELECT IdCategoria,Nombre FROM Categorias";
    $resultado=mysqli_query($conexion,$query);
    if($resultado)
        while ($fila = mysqli_fetch_assoc($resultado))
            $listaCategorias[] = $fila;

    //Cargando los proveedores en una lista para el combo box
    $query="SELECT IdProveedor,Nombre FROM Proveedores";
    $resultado=mysqli_query($conexion,$query);
    if($resultado)
        while ($fila = mysqli_fetch_assoc($resultado))
            $listaProveedores[] = $fila;

    // Registramos al empleado en la bd
    if ($_POST) {
        $query="SELECT * FROM Productos WHERE CodigoBarras='{$_POST["CodigoBarras"]}'";
        $validacion=mysqli_query($conexion,$query);
        if(mysqli_num_rows($validacion) > 0){ //Si hay un producto con el mismo codigo de barras
            echo '<script type="text/javascript">
                swal("¡No se pudo registrar el producto!", "Ya existe un producto con este mismo codigo de barras, ingresa uno que sea valido.", "error");
            </script>';
        }
        else{
            $CodigoBarras = isset($_POST["CodigoBarras"]) ? $_POST["CodigoBarras"] : "";
            $Nombre = isset($_POST["Nombre"]) ? $_POST["Nombre"] : "";
            $Descripcion = isset($_POST["Descripcion"]) ? $_POST["Descripcion"] : "";
            $IdCategoria = isset($_POST["IdCategoria"]) ? $_POST["IdCategoria"] : "";
            $IdProveedor = isset($_POST["IdProveedor"]) ? $_POST["IdProveedor"] : "";
            $PrecioCompra = isset($_POST["PrecioCompra"]) ? $_POST["PrecioCompra"]:"";
            $PrecioVenta = isset($_POST["PrecioVenta"]) ? $_POST["PrecioVenta"]:"";
            $Foto = isset($_FILES["Foto"]["name"]) ? $_FILES["Foto"]["name"] : "";
            $Estado = isset($_POST["Estado"]) ? $_POST["Estado"]:"";
            $Existencias = isset($_POST["Existencias"]) ? $_POST["Existencias"]:"";

            //Cambiandole el nombre a la foto fecha+nombre, por si hay repetidos
            $fecha_foto=new DateTime();
            $nombre_foto=($Foto!='')?$fecha_foto->getTimestamp()."_".$_FILES["Foto"]["name"]:"";
            $tmp_foto=$_FILES["Foto"]["tmp_name"];
            //Guardandola en la carpeta Fotos de productos
            if($tmp_foto!=''){
                move_uploaded_file($tmp_foto,"./Fotos/".$nombre_foto);
            }else{
                // Si no se ha subido una foto, copiamos la foto predeterminada desde la carpeta "Images"
                $fotoPredeterminada = "../../Resources/Images/default-producto.png"; // Ruta donde esta la foto predeterminada
                $nombre_foto=$fecha_foto->getTimestamp()."_defaultCopy.png";
                $destino = "./Fotos/" . $nombre_foto; // Ruta de destino para la foto predeterminada
                copy($fotoPredeterminada, $destino);
            }

            // Query para insertar en la base de datos
            $query = "INSERT INTO Productos (CodigoBarras,Nombre,Descripcion,Existencias,PrecioCompra,PrecioVenta,IdCategoria,IdProveedor,Estado,Foto)
                        VALUES ('$CodigoBarras','$Nombre','$Descripcion','$Existencias','$PrecioCompra','$PrecioVenta','$IdCategoria','$IdProveedor','$Estado','$nombre_foto')";
            
            mysqli_query($conexion, $query);
            echo '<script type="text/javascript">
                swal("¡Producto registrado!", "Haz registrado con exito este producto", "success");
                setTimeout(function(){
                    window.location.href = "index.php";
                }, 1500);
            </script>';
        }
        
    }
    mysqli_close($conexion);
?>



<link rel="stylesheet" href="../../Libs/bootstrap.min.css"/>

<br>
<h1>REGISTRAR PRODUCTO</h1>
<br>

<div class="container d-flex justify-content-center align-items-center">

    <div class="card w-75 h-75">
        <div class="card-header">
            Datos del Producto
        </div>
        <div class="card-body">
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-6">
                        
                        <div class="mb-3">
                        <label for="CodigoBarras" class="form-label fw-bold">Código de Barras:</label>
                        <input type="text"
                            class="form-control" name="CodigoBarras" id="CodigoBarras" aria-describedby="helpId" placeholder="Código de Barras" required>
                        </div>

                        <div class="mb-3">
                        <label for="Nombre" class="form-label fw-bold">Nombre:</label>
                        <input type="text"
                            class="form-control" name="Nombre" id="Nombre" aria-describedby="helpId" placeholder="Nombre del producto" required>
                        </div>

                        <div class="mb-3">
                        <label for="Descripcion" class="form-label fw-bold">Descripción:</label>
                        <input type="text"
                            class="form-control" name="Descripcion" id="Descripcion" aria-describedby="helpId" placeholder="Descripción del producto">
                        </div>

                        <div class="mb-3">
                            <label for="IdCategoria" class="form-label fw-bold">Categoría:</label>
                            <select class="form-select form-select-sm" name="IdCategoria" id="IdCategoria">
                                <?php foreach ($listaCategorias as $registro){?>
                                    <option value="<?php echo $registro['IdCategoria']?>">
                                        <?php echo $registro['Nombre']?>
                                    </option>
                                <?php }?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="IdProveedor" class="form-label fw-bold">Proveedor:</label>
                            <select class="form-select form-select-sm" name="IdProveedor" id="IdProveedor">
                                <?php foreach ($listaProveedores as $registro){?>
                                    <option value="<?php echo $registro['IdProveedor']?>">
                                        <?php echo $registro['Nombre']?>
                                    </option>
                                <?php }?>
                            </select>
                        </div>

                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="PrecioCompra" class="form-label fw-bold">Precio Compra:</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text">$</span>
                                <input type="number" step="0.01"
                                class="form-control" name="PrecioCompra" id="PrecioCompra" aria-describedby="helpId" placeholder="Precio de compra" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="PrecioVenta" class="form-label fw-bold">Precio Venta:</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text">$</span>
                                <input type="number" step="0.01"
                                class="form-control" name="PrecioVenta" id="PrecioVenta" aria-describedby="helpId" placeholder="Precio de venta" required>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                        <label for="Existencias" class="form-label fw-bold">Existencia inicial:</label>
                        <input type="number"
                            class="form-control" name="Existencias" id="Existencias" aria-describedby="helpId" placeholder="Existencias">
                        </div>

                        <div class="mb-3">
                        <label for="Foto" class="form-label fw-bold">Foto:</label>
                        <input type="file"
                            class="form-control" name="Foto" id="Foto" aria-describedby="helpId" placeholder="Foto">
                        </div>

                        <div class="mb-3">
                            <label for="Estado" class="form-label fw-bold">Estado:</label>
                            <select class="form-select form-select-sm" name="Estado" id="Estado">
                                <option value="1">Activo</option>
                                <option value="0">Inactivo</option>
                            </select>
                        </div>
                        
                        

                    </div>
                    
                    <div class="d-flex justify-content-center mb-1">
                            <button type="submit" class="btn btn-success me-5">Registrar</button>
                            <a name="" id="" class="btn btn-danger" href="index.php" role="button">Cancelar</a>
                    </div>

                </div>
                
            </form>
        </div>

        <div class="card-footer text-muted"></div>

    </div>
    
</div>

<br>

<?php include("../../Templates/Footer.php"); ?>