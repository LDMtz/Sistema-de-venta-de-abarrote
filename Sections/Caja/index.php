<?php
    include("../../Templates/Header.php");
    include("ScriptsCaja.php");
?>

<link rel="stylesheet" href="../../Libs/bootstrap.min.css"/>

<br>
<h1>SECCION CAJA</h1>
<br>

<div class="card ">

    <div class="card-header d-flex justify-content-between align-items-center">

    </div>

    <div class="card-body row m-1">

        <div class="col-md card m-1" id="datosCaja">
            <!-- Cargamos los datos de la caja -->
        </div>

        <div class="col-md-7 card m-1 p-0">
            <div class="card border-0">
                <div class="card-header">

                <div class="">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="radioGroup" id="radioMovimientos" value="">
                        <label class="form-check-label" for="radioMovimientos">Movimientos de la caja actual</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="radioGroup" id="radioHistorial" value="">
                        <label class="form-check-label" for="radioHistorial">Historial de cajas</label>
                    </div>
                </div>


                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table" id="tablaCaja">
                            <!-- Aqui vamos a cargar el contenido de la tabla -->
                        </table>
                    </div>
                </div>
                
            </div>
        </div>

    </div>
</div>

<br>
<?php include("../../Templates/Footer.php"); ?>

<script>
    $(document).ready(function(){
        validarCaja();
    });

</script>