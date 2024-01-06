<?php
    include("../../Templates/Header.php");
    include("ScriptsVentas.php");

?>

<link rel="stylesheet" href="../../Libs/bootstrap.min.css"/>

<br>
<h1>SECCION VENTAS</h1>
<br>

<div class="card ">

    <div class="card-body row m-1">

        <div class="col-md-8 m-1">

            <div class="row">
                    <div class="card border border-info border-3 p-0">
                        <div class="card-header border-secondary p-2 d-flex align-items-center">
                            <img class="img-fluid me-2" src="../../Resources/Icons/icon-codigo-barras.svg" alt="iconClientes" style="max-height: 35px;">
                            <h6 class="m-0">Buscar producto:</h6>
                        </div>
                        <div class="row m-1 mb-0">
                            <div class="col-md-4">
                                <label class="form-label">Buscar por:</label>
                                <select class="form-select w-100 rounded border border-dark" id="selectBuscarPor">
                                    <option value="CodigoBarras">Código de barras</option>
                                    <option value="Nombre">Nombre del producto</option>
                                    <option value="Categoria">Categoria</option>
                                    <option value="Proveedor">Proveedor</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-2">
                                <label class="form-label">Dato:</label>
                                <div class="input-group mb-1">
                                    <input type="text" class="form-control border border-dark" placeholder="Buscar producto" id="datoBusquedaProducto">
                                    <button class="btn btn-outline-secondary border border-dark bg-info" onclick="mostrarModalProductos();">
                                        <img src="../../Resources/Icons/icon-buscar.svg" alt="iconBuscar" class="" style="max-height: 20px;">
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div id="dataProductoSeleccionado" hidden>
                            <div class="ms-3 me-3">
                                <hr>
                            </div>

                            <div class="container mb-3 mt-1 ms-3">
                                <div class="row">
                                    <input id="inputPSId" type="text" disabled hidden>
                                    <input id="inputPSExistencias" type="number" disabled hidden>
                                    <div class="col-md-1 d-flex justify-content-center align-items-center border">
                                        <img id="inputPSFoto" src="" style="max-height: 60px;">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="fw-bold">Nombre:</label>
                                        <input id="inputPSNombre" type="text" class="form-control" placeholder="Nombre" readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="fw-bold">Precio venta:</label>
                                        <input id="inputPSPrecioVenta" type="text" class="form-control" placeholder="Precio venta" readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="fw-bold">Descuento:</label>
                                        <input id="inputPSDescuento" type="text" class="form-control" placeholder="Descuento" readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="fw-bold" >Cantidad:</label>
                                        <input id="inputPSCantidad" type="number" class="form-control" placeholder="Cantidad">
                                    </div>
                                    <div class="col-md-2 mt-1">
                                        <button class="btn btn-success w-75 h-100" type="button" onclick="agregarAlCarrito();">
                                            <img src="../../Resources/Icons/icon-add.svg" alt="Icono Agregar" class="img-fluid" style="max-height: 30px;">
                                            Agregar
                                        </button>
                                    </div>

                                </div>
                            </div>

                        </div>
                        

                        
                    </div>

            </div>

            <!-- Segunda fila -->
            <div class="row mt-3">
                <div class="card col border border-info border-3 p-0">
                    <div class="card-header border-secondary p-2 d-flex align-items-center">
                        <img class="img-fluid me-2" src="../../Resources/Icons/icon-carrito.svg" alt="iconClientes" style="max-height: 35px;">
                        <h6 class="m-0">Carrito de compras</h6>
                    </div>

                    <div class="table-responsive ms-1 me-1">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="text-nowrap text-center" scope="col">Num</th>
                                    <th class="text-nowrap text-center" scope="col">Foto</th>
                                    <th class="text-nowrap text-center" scope="col">Producto</th>
                                    <th class="text-nowrap text-center" scope="col">Cantidad</th>
                                    <th class="text-nowrap text-center" scope="col">Precio venta</th>
                                    <th class="text-nowrap text-center" scope="col">Descuento</th>
                                    <th class="text-nowrap text-center" scope="col">Subtotal</th>
                                    <th class="text-nowrap text-center" scope="col">Btn</th>
                                </tr>
                            </thead>
                            <tbody id="BodyTabla">
                                <!-- Cargamos todos los empleados -->
                                <?php include("ListarCarrito.php");?>
                            </tbody>
                            
                        </table>
                    </div>

                    <div class="card-footer border-secondary p-2 bg-white d-flex align-items-center">
                        <h6 class="m-0">Descuento Total </h6>
                        <input id="inputDescTotal" type="text" class="form-control w-25 ms-1" placeholder="" readonly>
                        <h6 class="m-0 ms-5">Total </h6>
                        <input id="inputTotal" type="text" class="form-control w-25 ms-1" placeholder="" readonly>


                        <div class="ms-auto">
                            <button type="button" class="btn btn-warning" onclick="vaciarCarrito();">Vaciar carrito</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md m-1">
        <div class="row">
            <div class="card col border border-info border-3 p-0">
                <div class="card-header border-secondary p-2 d-flex align-items-center">
                    <img class="img-fluid me-2" src="../../Resources/Icons/icon-venta.svg" alt="iconClientes" style="max-height: 35px;">  
                    <h6 class="m-0">Datos de la venta</h6>
                </div>
                <div class="container mt-3">
                    <label class="fw-bold">Cajero que atiende:</label>
                    <div class="input-group mb-3">
                        <input id="inputEmpleado" data-id-empleado="<?php echo $_SESSION['IdEmpleado']; ?>" type="text" class="form-control" value="<?php echo $_SESSION['Nombre']; ?>" readonly>
                    </div>

                    <label class="fw-bold">Cliente:</label>
                    <div class="input-group mb-3">
                        <input id="inputCliente" type="text" class="form-control" placeholder="Publico General" readonly>
                        <button class="btn btn-outline-secondary bg-primary" type="button" onclick="mostrarModalClientes();">
                            <img src="../../Resources/Icons/icon-clientes.svg" alt="iconBuscar" class="" style="max-height: 25px;">
                        </button>
                    </div>
                    <input id="inputIDClienteHidden" type="text" value="-1" disabled hidden>

                    <div class="container mb-3 mt-1 ps-0">
                        <div class="row">
                            <div class="col-md-6">
                                <label class="fw-bold">Comprobante:</label>
                                <select id="selectTipoDoc" type="text" class="form-control" placeholder="" readonly>
                                    <option value="Ticket">Ticket</option>
                                    <option value="Factura">Factura</option>
                                </select>
                                
                            </div>
                            <div class="col-md-6">
                                <label class="fw-bold">Id Caja:</label>
                                <input id="inputIdCaja" readonly type="text" class="form-control" placeholder="" value="<?php echo $_SESSION['IdCaja']; ?>">
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>



            <!-- Segunda fila -->
            <div class="row mt-3">
                <div class="card col border border-info border-3 p-0">
                    <div class="card-header border-secondary p-2 d-flex align-items-center">
                        <img class="img-fluid me-2" src="../../Resources/Icons/icon-cash.svg" alt="iconClientes" style="max-height: 35px;">
                        <h6 class="m-0">Realizar venta</h6>
                    </div>

                    <div class="container mt-3">
                        
                        <div class="input-group mb-0">
                            <input id="totalPagar" type="text" class="form-control text-center" placeholder="" readonly disabled>
                        </div>
                        <div class="text-center">
                            <label class="fw-bold">Total a pagar</label>
                        </div>
                        
                        <hr>

                        <div class="container mb-1 mt-3 ps-0">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="fw-bold">Paga con:</label>
                                    <input id="inputPagaCon" onchange="calculaCambio(this.value);" type="number" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label class="fw-bold">Cambio:</label>
                                    <input id="inputCambio" type="text" class="form-control" readonly>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="text-center">
                            <button id="btnTerminarVenta" type="button" class="btn btn-success" onclick="validarVenta();" disabled>
                                <img src="../../Resources/Icons/icon-check.svg" alt="Imagen Check" style="max-height: 30px;"> Terminar venta
                            </button>
                        </div>



                    </div>
                    <br>
                </div>
            </div>
        </div>


    </div>
</div>

<br>
<?php include("../../Templates/Footer.php"); ?>

