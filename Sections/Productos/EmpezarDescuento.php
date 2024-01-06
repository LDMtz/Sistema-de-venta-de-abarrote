<link rel="stylesheet" href="../../Libs/bootstrap.min.css"/>
<?php include("../../Templates/Header.php"); ?>
<?php include("ScriptsProductos.php"); ?>

<br>
<h1> EMPEZAR DESCUENTO </h1>
<br>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <label for="CodigoBarras" class="form-label fw-bold">Código de Barras:</label>
        <input type="text" class="form-control w-25 ms-1" name="CodigoBarras" id="CodigoBarras" 
        aria-describedby="helpId" placeholder="Código de Barras" required>
        <button type="submit" class="btn btn-primary ms-1" onclick="validaProducto();">Buscar</button>
        <button class="btn btn-info text-white ms-auto" onclick="limpiarInputs();">Limpiar Busqueda</button>
    </div>
    <div id="bodyCardDescuento" class="card-body row" hidden>
        <div id="datosProducto" class="col-md-4">
            <!-- AQUI SE VAN A CARGAR LOS DATOS DEL PRODUCTO CON EL AJAX--> 

            
        </div>
        <div class="col-md-1 text-center">
            <div class="vr h-100"></div>
        </div>
        <div class="col-md-7">
            <div class="row mt-2">
                <label class="fw-bold">¿De que forma quieres aplicar el descuento?</label>
                <select id="opcionDescuento" class="form-select" onchange="mostrarFormaDescuento(this);">
                    <option selected value="Ninguno">Elegir...</option>
                    <option value="Porcentaje">Porcentaje de descuento</option>
                    <option value="Cantidad">Cantidad exacta</option>
                </select>
            </div>

            <div class="mt-5" id="inputPorcentaje" hidden>
                <label for="" class="form-label">Porcentaje de descuento:</label>
                <div class="input-group mb-3 w-50">
                    <span class="input-group-text">-</span>
                    <input type="number" step="0.01" value="" onchange="calculaDescuento('Porcentaje',this.value);"
                    class="form-control" name="" id="" placeholder="Porcentaje a descontar" min="0" max="100" required>
                    <span class="input-group-text">%</span>
                    
                </div>
            </div>

            <div class="mt-5" id="inputCantidad" hidden>
                <label for="" class="form-label">Cantidad a descontar:</label>
                <div class="input-group mb-3 w-50">
                    <span class="input-group-text"> - $</span>
                    <input type="number" step="0.01" value="" onchange="calculaDescuento('Cantidad',this.value);"
                    class="form-control" name="" id="" placeholder="Cantidad a descontar" min="0" max=""required>
                </div>
            </div>

            <div class="row mt-5" >
                <div class="col-sm-6">
                    <label class="">Precio normal:</label>
                    <div class="input-group-text">
                        <span class="me-1">$</span>
                        <input id="inputPrecioNormal" class="form-control" type="number" step="0.01" value="" disabled readonly>
                    </div>
                </div>
                
                <div class="col-sm-6">
                    <label class="">Precio con descuento:</label>
                    <div class="input-group-text">
                        <span class="me-1">$</span>
                        <input id="inputPrecioDescuento" class="form-control" type="number" step="0.01"" value="" disabled readonly>
                    </div>
                </div>
                
            </div>

            <div class="w-50 mt-3" id="inputCantidadDescuento" hidden>
                <label class="">Cantidad a descontar:</label>
                <div class="input-group-text">
                    <span class="me-1">$</span>
                    <input id="inputCantidadADescontar" class="form-control" type="number" step="0.01" value="" disabled readonly>
                </div>
            </div>

            <div class="text-center mt-5">
                <button class="btn btn-success text-white ms-auto" onclick="realizarDescuento(inputIdProducto.value,inputCantidadADescontar.value);">Descontar</button>
            </div>
            
        </div>
    </div>

    <div class="card-footer text-muted d-flex justify-content-end">
        <a name="" id="" class="btn btn-primary" href="DescuentoProducto.php" role="button">Regresar</a>
    </div>
</div>


<br>
<?php include("../../Templates/Footer.php"); ?>