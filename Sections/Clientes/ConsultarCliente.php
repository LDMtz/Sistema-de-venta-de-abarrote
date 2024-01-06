<?php include("ScriptsClientes.php"); ?>
<link rel="stylesheet" href="../../Libs/bootstrap.min.css"/>
<?php include("../../Templates/Header.php"); ?>

<br>
<h1>CONSULTAR CLIENTES</h1>
<br>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
            
        <label class="me-2 mb-0 col-4">Lista de Clientes:</label>
    
        <label class="me-2 mb-0">Por:</label>
            <select class="form-select form-select-sm me-2" id="tipo_dato" name="tipo_dato" required>
                <option value="IdCliente">Id del Cliente</option>
                <option value="Nombre">Nombre</option>
                <option value="Correo">Correo</option>
                <option value="Telefono">Telefono</option>
                <option value="FechaRegistro">Fecha de Registro</option>
            </select>
            <label class="me-2 mb-0 form-label">Dato:</label>
            <input type="text" class="form-control me-2" id="dato" name="dato"
                aria-describedby="helpId" placeholder="Introduzca el dato" required>
            <a class="btn btn-info text-white" role="button"
            onclick="consultaPorDato($('#tipo_dato').val(),$('#dato').val());return false;">Buscar</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table" id="tabConsulta">
            <thead>
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Correo</th>
                    <th scope="col">Telefono</th>
                    <th scope="col">Fecha de Registro</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody id="BodyTabla">
            </tbody>

            </table>
            
        </div>
    </div>
    <div class="card-footer text-muted d-flex justify-content-end">
        <a name="" id="" class="btn btn-primary" href="index.php" role="button">Regresar</a>
    </div>
</div>

<br>
<p><strong>Nota:</strong> En la opcion de consulta por <strong class="info-color">Fecha</strong>, el dato ingresado debe ser igual al 
    del registro, es decir, <em class="example-color">"2023-10-12"</em> usando el mismo formato.
     <br>
     Mientras que en las demás opciones si se pueden usar abreviaciones y además de que no distingue mayusculas o minusculas.
</p>

<br>
<?php include("../../Templates/Footer.php"); ?>