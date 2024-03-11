<?php include '../templates/header.php' ?>
<?php
    require '../request/botones.php';
?>
    <link rel="stylesheet" href="../css/tabla_activos8.css">
    <form action="tabla_activos.php?pagina=1" method="post" class="contenedor">
    <div class="cabecera">
        <div class="buscador">
            <div class="header-buscador">
                <input type="search" id="buscador" placeholder="<?= $minimo3digitos ?>" class="input" name="buscador">
                <a href="tabla_activos.php">Reiniciar busqueda 🔁</a>
                <div class="pagination">
                    <a href="tabla_activos.php?pagina=<?= (array_key_exists('pagina', $_GET))? $_GET['pagina'] - 1: 1; ?>" class="n_page">◀</a>
                    Pág. <?= (array_key_exists('pagina', $_GET))? $_GET['pagina']: 1; ?> de <?= $totalPaginas ?> 
                    <a href="tabla_activos.php?pagina=<?= (array_key_exists('pagina', $_GET))? $_GET['pagina'] + 1: 1; ?>" class="n_page">▶</a>
                </div>
            </div>
        </div>
    </div>
    <div class="tabla">
        <table id="miTabla">
            <thead>
                <tr>
                    <th colspan="5" class="codigo">CODIGO ANTIGUO</th>
                    <th colspan="4" class="codigo">CODIGO NUEVO</th>
                </tr>
                <tr>
                    <th class="old">id</th>
                    <th class="old"><button type="submit" name="ug_old" value="codigo_ubicacion_gral_old" class="old"></button></th>
                    <th class="old"><button type="submit" name="ug_old" value="codigo_ubicacion_gral_old" class="old">U.G.</button></th>
                    <th class="old"><button type="submit" name="rubro_old" value="codigo_rubro_old" class="old">RUB.</button></th>
                    <th class="old"><button type="submit" name="corr_old" value="correlativo_antiguo" class="old">COR.</button></th>

                    <th class="new"><button type="submit" name="ug_new" value="codigo_ubicacion_gral_new" class="new">U.G.</button></th>
                    <th class="new"><button type="submit" name="ue_new" value="codigo_ubicacion_esp" class="new">U.E.</button></th>
                    <th class="new"><button type="submit" name="rubro_new" value="codigo_rubro_new" class="new">RUB.</button></th>
                    <th class="new"><button type="submit" name="corr_new" value="correlativo_nuevo" class="new">COR.</button></th>

                    <th><button type="submit" name="activo" value="des_tipo" class="">Activos</button></th>
                    <th><button type="submit" name="detalles" value="detalles" class="">Detalles</button></th>
                    <th><button type="submit" name="marca" value="des_marca" class="">Marca</button></th>
                    <th><button type="submit" name="modelo" value="modelo" class="">Modelo</button></th>
                    <th><button type="submit" name="serie" value="serie" class="">Serie</button></th>
                    <th><button type="submit" name="pais" value="des_pais" class="">Pais</button></th>
                    <th><button type="submit" name="anio" value="año_compra" class="">Año</button></th>

                    <th><button type="submit" name="empresa_factura" value="empresa_factura" class="">Empresa Factura</button></th>
                    <th><button type="submit" name="nro_factura" value="nro_factura" class="">Nro Factura</button></th>
                    <th><button type="submit" name="estado" value="codigo_estado" class="">Estado</button></th>
                    <th><button type="submit" name="valor_inicial" value="valor_inicial" class="">Valor inicial</button></th>
                    <th><button type="submit" name="al_2021" value="al_2021" class="">Al 2021</button></th>
                    <th><button type="submit" name="valor_residual" value="valor_recidual" class="">Valor residual</button></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($datosPagina as $row): ?>
                    <tr ondblclick="<?= ($_SESSION['rol'] === 3 )? '' : 'redirigirAScript(this)'; ?>" style="cursor: pointer;">
                        <td id="id_activo"><?php echo $row->id_activo ?></td>
                        <td>
                            <?php if($row->verificado === 0):?>
                            <form action="tabla_activos.php?pagina=1" method="post" style="display: flex;">
                                <input type="text" name="id_verificar" value="<?= $row->id_activo ?>" hidden readonly>
                                <button type="submit" name="verificar" value="1">❌</button>
                            </form>
                            <?php elseif($row->verificado === 1):?>
                                <form action="tabla_activos.php?pagina=1" method="post" style="display: flex;">
                                    <input type="text" name="id_verificar" value="<?= $row->id_activo ?>" hidden readonly>
                                <button type="submit" name="sin_verificar" value="0">✅</button>
                            </form>
                            <?php endif?>
                        </td>
                        <td class="cod_old" id="codigo_ubicacion_gral_old"><?= (is_null($row->codigo_ubicacion_gral_old)) ? '':  Codigo_antiguo::Buscar_para_editar($row->id_activo)->codigo_ubicacion_gral ?></td>
                        <td class="cod_old" id="codigo_rubro_old"><?= (is_null(Codigo_antiguo::Buscar_para_editar($row->id_activo))) ? '':  Codigo_antiguo::Buscar_para_editar($row->id_activo)->codigo_rubro ?></td>
                        <td class="cod_old" id="correlativo_old"><?= (is_null(Codigo_antiguo::Buscar_para_editar($row->id_activo))) ? '': Codigo_antiguo::Buscar_para_editar($row->id_activo)->correlativo_antiguo ?></td>

                        <td class="cod_new" id="codigo_ubicacion_gral_new"><?= (is_null(Codigo_antiguo::Buscar_para_editar($row->id_activo))) ? '': Codigo_nuevo::Buscar_para_editar($row->id_activo)->codigo_ubicacion_gral ?></td>
                        <td class="cod_new" id="codigo_ubicacion_esp_new"><?= (is_null(Codigo_antiguo::Buscar_para_editar($row->id_activo))) ? '': Codigo_nuevo::Buscar_para_editar($row->id_activo)->codigo_ubicacion_esp ?></td>
                        <td class="cod_new" id="codigo_rubro_new"><?= (is_null(Codigo_antiguo::Buscar_para_editar($row->id_activo))) ? '': Codigo_nuevo::Buscar_para_editar($row->id_activo)->codigo_rubro ?></td>
                        <td class="cod_new" id="correlativo_new"><?= (is_null(Codigo_antiguo::Buscar_para_editar($row->id_activo))) ? '': Codigo_nuevo::Buscar_para_editar($row->id_activo)->correlativo_nuevo ?></td>

                        <td id="des_tipo" class="activos"><?= $row->des_tipo ?></td>
                        <td id="detalles" class="details"><?= $row->detalles ?></td>
                        <td id="des_marca" style="white-space: nowrap;"><?= $row->des_marca ?></td>
                        <td id="modelo" style="white-space: nowrap;"><?= $row->modelo ?></td>
                        <td id="serie" style="white-space: nowrap;"><?= $row->serie ?></td>
                        <td id="des_pais" style="white-space: nowrap;"><?= $row->des_pais ?></td>
                        <td id="año_compra" style="white-space: nowrap;"><?= $row->año_compra ?></td>

                        <td id="empresa_factura"><?= $row->empresa_factura ?></td>
                        <td id="nro_factura">Nro.<?= $row->nro_factura ?></td>
                        <td id="codigo_estado"><?= $row->codigo_estado ?></td>
                        <td id="valor_inicial"><?= $row->valor_inicial ?></td>
                        <td id="al_2021"><?= $row->al_2021 ?></td>
                        <td id="valor_recidual"><?= $row->valor_recidual ?></td>
                    </tr>
                <?php endforeach;?>
            </tbody>
            <tfoot>
                <tr>
                    <th>id</th>
                    <th class="old"><button type="submit" name="ug_old" value="codigo_ubicacion_gral_old" class="old">U.G.</button></th>
                    <th class="old"><button type="submit" name="rubro_old" value="codigo_rubro_old" class="old">RUB.</button></th>
                    <th class="old"><button type="submit" name="corr_old" value="correlativo_antiguo" class="old">COR.</button></th>
                    
                    <th class="new"><button type="submit" name="ug_new" value="codigo_ubicacion_gral_new" class="new">U.G.</button></th>
                    <th class="new"><button type="submit" name="ue_new" value="codigo_ubicacion_esp" class="new">U.E.</button></th>
                    <th class="new"><button type="submit" name="rubro_new" value="codigo_rubro_new" class="new">RUB.</button></th>
                    <th class="new"><button type="submit" name="corr_new" value="correlativo_nuevo" class="new">COR.</button></th>
                    
                    <th><button type="submit" name="activo" value="des_tipo" class="">Activos</button></th>
                    <th><button type="submit" name="detalles" value="detalles" class="">Detalles</button></th>
                    <th><button type="submit" name="marca" value="des_marca" class="">Marca</button></th>
                    <th><button type="submit" name="modelo" value="modelo" class="">Modelo</button></th>
                    <th><button type="submit" name="serie" value="serie" class="">Serie</button></th>
                    <th><button type="submit" name="pais" value="des_pais" class="">Pais</button></th>
                    <th><button type="submit" name="anio" value="año_compra" class="">Año</button></th>
                    
                    <th><button type="submit" name="empresa_factura" value="empresa_factura" class="">Empresa Factura</button></th>
                    <th><button type="submit" name="nro_factura" value="nro_factura" class="">Nro Factura</button></th>
                    <th><button type="submit" name="estado" value="codigo_estado" class="">Estado</button></th>
                    <th><button type="submit" name="valor_inicial" value="valor_inicial" class="">Valor inicial</button></th>
                    <th><button type="submit" name="al_2021" value="al_2021" class="">Al 2021</button></th>
                    <th><button type="submit" name="valor_residual" value="valor_recidual" class="">Valor residual</button></th>
                </tr>
            </tfoot>
        </table>
    </div>
    
    </form>

    <script src="../js/BuscadorSQL3.js"></script>

    <script>
        alert(`
        A) Cambios
            1. Ruta de imagenes de activos a => D:/inventario_img
            2. Ruta de imagenes de facturas a => D:/inventario_img
            3. Ruta de imagenes de qr a => D:/inventario_img
        B) Pendientes
            1. Arreglar y optimizar el buscador
            2. Arreglar la salida de pdf de activos y Excel
            3. Solucionar el bug en el movimiento de pantallas de las flechas
        C) Propuestas
            1. Mover todo el proyecto al disco D: o a otra unidad
        `);
        document.getElementById('buscador').addEventListener('input', function() {
            var valorBusqueda = this.value;
            localStorage.setItem('valorBusqueda', valorBusqueda);
            });

            window.addEventListener('load', function() {
            var valorGuardado = localStorage.getItem('valorBusqueda');
            if (valorGuardado) {
                document.getElementById('buscador').value = valorGuardado;
            }
        });
    </script>
<!-- </body>
</html> -->