<script src="../../Libs/JSBarcode.all.min.js"></script>

<?php
    include("../../Templates/Header.php");
    include("ScriptsProductos.php");
    
?>


<link rel="stylesheet" href="../../Libs/bootstrap.min.css"/>

<br>
<h1>SECCION CODIGO DE BARRAS</h1>
<br>

<div class="card">
    <div class="card-header">
        <button type="button" class="btn btn-primary" onclick="buscarCodigo();">Buscar codigo de barras</button>
    </div>
    <div class="card-body" >
        <div id="bodyCardCodigo" class="card-body row" hidden>
            <!-- AQUI SE VAN A CARGAR LOS DATOS DEL PRODUCTO CON EL AJAX-->
            <div id="datosProducto" class="col-md-4">
                
            </div>

            <div class="col-md-1 text-center">
                <div class="vr h-100"></div>
            </div>

            <div id="datosCodigo" class="col-md-7">
                <br>
                <H4>Código de Barras:</H1>
                <div id="barcodeContainer" class="d-flex justify-content-center align-items-center">
                    <canvas id="barcode" class="card"></canvas>
                </div>
                <div class="d-flex justify-content-center mt-5">
                    <button type="button" class="btn btn-info me-5" onclick="descargarCodigoimg();">Descargar</button>
                    <button type="button" class="btn btn-warning" onclick="imprimirCodigoimg();">Imprimir</button>
                </div>

                <form action="ProductoPDF.php" method="post" onsubmit="updateIdProducto()">
                    <H4 class="mt-3">Descargar producto en pdf:</H1>
                    <div class="d-flex justify-content-center">
                        <input id="IdProductoForm" name="IdProductoForm" type="text" value="" hidden>
                        <button type="submit" class="btn btn-success">Generar PDF</button>
                    </div>
                </form>

            </div>
            
        </div>
    </div>
    <div class="card-footer text-muted d-flex justify-content-end">
        <a name="" id="" class="btn btn-primary" href="index.php" role="button">Regresar</a>
    </div>
</div>


<br>
<?php include("../../Templates/Footer.php"); ?>