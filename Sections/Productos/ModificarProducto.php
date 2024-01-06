<link rel="stylesheet" href="../../Libs/bootstrap.min.css"/>
<?php include("../../Templates/Header.php"); ?>
<?php include("ActualizaProducto.php"); ?>
<br>
<h1>MODIFICAR PRODUCTO</h1>
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
                        <input type="text" value="<?php echo $datosProducto['CodigoBarras']?>"
                            class="form-control" name="CodigoBarras" id="CodigoBarras" aria-describedby="helpId" placeholder="Código de Barras" required>
                        </div>

                        <div class="mb-3">
                            <label for="Nombre" class="form-label fw-bold">Nombre:</label>
                            <input type="text" value="<?php echo $datosProducto['Nombre']?>"
                            class="form-control" name="Nombre" id="Nombre" aria-describedby="helpId" placeholder="Nombre del producto" required>
                        </div>

                        <div class="mb-3">
                        <label for="Descripcion" class="form-label fw-bold">Descripción:</label>
                        <input type="text" value="<?php echo $datosProducto['Descripcion']?>"
                            class="form-control" name="Descripcion" id="Descripcion" aria-describedby="helpId" placeholder="Descripción del producto">
                        </div>

                        <div class="mb-3">
                            <label for="IdCategoria" class="form-label fw-bold">Categoría:</label>
                            <select class="form-select form-select-sm" name="IdCategoria" id="IdCategoria">
                                <?php foreach ($listaCategorias as $registroCategorias){?>
                                <option <?php echo ($datosProducto['IdCategoria']==$registroCategorias['IdCategoria'])?"selected":"" ?> value="<?php echo $registroCategorias['IdCategoria']?>" > 
                                    <?php echo $registroCategorias['Nombre']?>
                                </option>
                                <?php }?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="IdProveedor" class="form-label fw-bold">Proveedor:</label>
                            <select class="form-select form-select-sm" name="IdProveedor" id="IdProveedor">
                                <?php foreach ($listaProveedores as $registroProveedores){?>
                                <option <?php echo ($datosProducto['IdProveedor']==$registroProveedores['IdProveedor'])?"selected":"" ?> value="<?php echo $registroProveedores['IdProveedor']?>" > 
                                    <?php echo $registroProveedores['Nombre']?>
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
                                <input type="number" step="0.01" value="<?php echo $datosProducto['PrecioCompra']?>"
                                class="form-control" name="PrecioCompra" id="PrecioCompra" aria-describedby="helpId" placeholder="Precio de compra" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="PrecioVenta" class="form-label fw-bold">Precio Venta:</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text">$</span>
                                <input type="number" step="0.01" value="<?php echo $datosProducto['PrecioVenta']?>"
                                class="form-control" name="PrecioVenta" id="PrecioVenta" aria-describedby="helpId" placeholder="Precio de venta" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="Foto" class="form-label fw-bold">Foto Actual:</label>
                            <br>
                            <img width="100" 
                                    src="<?php echo 'Fotos/'.$datosProducto['Foto']?>" 
                                    class="rounded" 
                                    alt="FotoProducto">
                            <?php echo $datosProducto['Foto']?>
                            <br><br>

                            <input type="file" value=""
                                class="form-control" name="Foto" id="Foto" aria-describedby="helpId" placeholder="Foto">
                        </div>

                        <div class="mb-3">
                            <label for="Estado" class="form-label fw-bold">Estado:</label>
                            <select class="form-select form-select-sm" name="Estado" id="Estado">
                                <option <?php echo ($datosProducto['Estado']==1)?"selected":"" ?> value="1" >Activo</option> // 1 = Activo
                                <option <?php echo ($datosProducto['Estado']==0)?"selected":"" ?> value="0">Inactivo</option> //0 = Inactivo
                            </select>
                        </div>
                        
                        <input type="hidden" value="<?php echo $datosProducto['IdProducto']?>"name="Id" id="Id">

                    </div>
                    
                    <div class="d-flex justify-content-center mb-1">
                        <button type="submit" class="btn btn-info me-5">Actualizar</button>
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