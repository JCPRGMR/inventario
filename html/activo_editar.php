<?php include '../templates/header.php' ?>
<?php require '../request/botones.php' ?>
<?php
    // var_dump(Codigo_antiguo::Buscar_para_editar($_GET['valor'])->codigo_ubicacion_gral);
    $id_activo_editar = $_GET['valor'];
    $activo = Activos::BuscarParaEditar($_GET['valor']); 
    $codigo_antiguo = Codigo_antiguo::Buscar_para_editar($_GET['valor']);
    $codigo_nuevo = Codigo_nuevo::Buscar_para_editar($_GET['valor']) ?>

<link rel="stylesheet" href="../css/activo_editar1.css">
<form action="" method="post" class="form_editar" enctype="multipart/form-data">
    <div class="container" style="display: flex; justify-content: center;">
        <div class="container_child">
            <header>DATOS DEL CODIGO ANTIGUO</header>   
            <div>
                <div class="editar_dato">
                    <label for="">UBICACION GENERAL</label>
                    <select name="editar_ug_old" id="">
                        <option hidden value="<?= (is_null($codigo_antiguo))? 15: $codigo_antiguo->id_ubicacion_gral ?>"><?= (is_null($codigo_antiguo))? '': $codigo_antiguo->codigo_ubicacion_gral; ?></option>
                        <?php foreach(Ubicacion_General::Ver() as $row): ?>
                            <option value="<?= $row->id_ubicacion_gral ?>"><?= $row->codigo_ubicacion_gral . ' ' . $row->des_ubicacion_gral ?></option>
                        <?php endforeach;?>
                    </select>
                </div>
                <div class="editar_dato">
                    <label for="">RUBRO</label>
                    <select name="editar_rubro_old" id="">
                        <option hidden value="<?= (is_null($codigo_antiguo))? 16: $codigo_antiguo->id_rubro ?>"><?= (is_null($codigo_antiguo))? '': $codigo_antiguo->codigo_rubro ?></option>
                        <?php foreach(Rubros::Ver() as $row): ?>
                            <option value="<?= $row->id_rubro ?>"><?= $row->codigo_rubro . ' ' . $row->des_rubro ?></option>
                        <?php endforeach;?>
                    </select>
                </div>
                <div class="editar_dato">
                    <label for="">CORRELATIVO ANTIGUO</label>
                    <input type="text" name="editar_correlativo_old" id="" value="<?= (is_null($codigo_antiguo))? 'S/C': $codigo_antiguo->correlativo_antiguo ?>">
                </div>
            </div>
        </div>
                                                    <!-- CODIGO NUEVO -->
        <div class="container_child">
            <header>DATOS DEL CODIGO NUEVO</header>
            <div>
                <div class="editar_dato">
                    <label for="">UBICACION GENERAL</label>
                    <select name="editar_ug_new" id="">
                        <option hidden value="<?= $codigo_nuevo->id_ubicacion_gral ?>"><?= $codigo_nuevo->codigo_ubicacion_gral ?></option>
                        <?php foreach(Ubicacion_General::Ver() as $row): ?>
                            <option value="<?= $row->id_ubicacion_gral ?>"><?= $row->codigo_ubicacion_gral . ' ' . $row->des_ubicacion_gral ?></option>
                        <?php endforeach;?>
                    </select>
                </div>
                <div class="editar_dato">
                    <label for="">UBICACION ESPECIFICA</label>
                    <select name="editar_ue_new" id="">
                        <option hidden value="<?= $codigo_nuevo->id_ubicacion_esp ?>"><?= $codigo_nuevo->codigo_ubicacion_esp ?></option>
                        <?php foreach(Ubicacion_Especifica::Ver() as $row): ?>
                            <option value="<?= $row->id_ubicacion_esp ?>"><?= $row->codigo_ubicacion_esp . ' ' . $row->des_ubicacion_esp ?></option>
                        <?php endforeach;?>
                    </select>
                </div>
                <div class="editar_dato">
                    <label for="">RUBRO</label>
                    <select name="editar_rubro_new" id="">
                        <option hidden value="<?= $codigo_nuevo->id_rubro ?>"><?= $codigo_nuevo->codigo_rubro ?></option>
                        <?php foreach(Rubros::Ver() as $row): ?>
                            <option value="<?= $row->id_rubro ?>"><?= $row->codigo_rubro . ' ' . $row->des_rubro ?></option>
                        <?php endforeach;?>
                    </select>
                </div>
                <div class="editar_dato">
                    <label for="">CORRELATIVO NUEVO</label>
                    <input type="text" name="editar_correlativo_new" id="" value="<?= $activo->correlativo_nuevo ?>">
                </div>
            </div>
        </div>
        <div class="container_child">
            <header>DATOS DEL ACTIVO</header>
            <div>
                <div class="editar_dato">
                    <label for="">ID</label>
                    <input type="text" name="id_activo" id="" value="<?= $activo->id_activo ?>" readonly>
                </div>
                <div class="editar_dato">
                    <label for="">ACTIVO</label>
                    <select name="editar_tipo" id="">
                        <option hidden value="<?= $activo->id_tipo ?>"><?= $activo->des_tipo ?></option>
                        <?php foreach(TiposActivos::Ver() as $row): ?>
                            <option value="<?= $row->id_tipo ?>"><?= $row->des_tipo ?></option>
                        <?php endforeach;?>
                    </select>
                </div>
                <div class="editar_dato">
                    <label for="editar_dato">DETALLES:</label>
                    <textarea name="editar_detalles" id="" cols="30" rows="10"><?= $activo->detalles ?></textarea>
                </div>
                <div class="editar_dato">
                    <label for="">MARCA</label>
                    <select name="editar_marca" id="">
                        <option value="<?= (is_null($activo->id_marca))? 80: $activo->id_marca; ?>"><?= $activo->des_marca ?></option>
                        <?php foreach(Marcas::Ver() as $row): ?>
                            <option value="<?= $row->id_marca ?>"><?=$row->des_marca ?></option>
                        <?php endforeach;?>
                    </select>
                </div>
                <div class="editar_dato">
                    <label for="">MODELO</label>
                    <input type="text" name="editar_modelo" value="<?= $activo->modelo ?>">
                </div>
                <div class="editar_dato">
                    <label for="">SERIE</label>
                    <input type="text" name="editar_serie" value="<?= $activo->serie ?>">
                </div>
                <div class="editar_dato">
                    <label for="">PAIS</label>
                    <select name="editar_pais" id="" class="pdd">
                        <option value="<?= (is_null($activo->id_pais))? 6: $activo->id_pais; ?>"><?= $activo->des_pais ?></option>
                        <?php foreach(Paises::Ver() as $row): ?>
                            <option value="<?= $row->id_pais ?>"><?= $row->des_pais ?></option>
                        <?php endforeach;?>
                    </select>
                </div>
                <div class="editar_dato">
                    <label for="">AÑO DE INGRESO</label>
                    <input type="text" name="editar_anio_compra" id="" value="<?= $activo->año_compra ?>">
                </div>
                <!-- FACTURA -->
                <div class="editar_dato">
                    <label for="">NRO FACTURA</label>
                    <input type="text" name="editar_nro_factura" id="" value="<?= $activo->nro_factura ?>">
                </div>
                <div class="editar_dato">
                    <label for="">EMPRESA DE FACTURA</label>
                    <input type="text" name="editar_empresa_factura" id="" value="<?= $activo->empresa_factura ?>">
                </div>
                <div class="editar_dato">
                    <label for="">CAMBIAR FOTO DE FACTURA</label>
                    <input type="file" name="editar_foto_factura" id="" <?= ($_SESSION['rol'] === 3 )? 'disabled' : ''; ?> >
                    <div class="foto_container">
                        <img src="../img/img_facturas/<?php echo $activo->foto_factura ?>" class="fotos" alt="No se encontro la foto de la factura">
                    </div>
                </div>
                <!-- FIN DE FACTURA -->
                <div class="editar_dato">
                    <label for="">AL 2021</label>
                    <input type="number" name="editar_al_2021" id="" value="<?= (is_null($activo->al_2021))? 0.0: $activo->al_2021; ?>">
                </div>
                <div class="editar_dato">
                    <label for="">VALOR INICIAL</label>
                    <input type="number" name="editar_valor_inicial" id="" value="<?= (is_null($activo->valor_inicial))? 0.0: $activo->valor_inicial; ?>">
                </div>
                <div class="editar_dato">
                    <label for="">VALOR RESIDUAL</label>
                    <input type="number" name="editar_valor_residual" id="" value="<?= (is_null($activo->valor_recidual))? 0.0: $activo->valor_recidual; ?>">
                </div>
                <div class="editar_dato">
                    <label for="">CAMBIAR FOTO DE ACTIVO</label>
                    <input type="file" name="editar_foto_activo" id="" <?= ($_SESSION['rol'] === 3 )? 'disabled' : ''; ?>>
                    <div class="foto_container">
                        <img src="../img/img_activos/<?php echo $activo->foto_activo ?>" class="fotos" alt="No se encontro la foto del activo <?= $activo->foto_activo ?>">
                    </div>
                </div>
                <!-- ESTADO ACTUA -->
                <div class="editar_dato">
                    <label for="">ESTADO</label>
                    <select name="editar_estado" id="" class="pdd">
                        <option value="<?= (isset($activo->id_estado)) ? $activo->id_estado : null; ?>">
                            <?= (isset($activo->id_estado)) ? $activo->id_estado : null; ?>
                        </option>
                        <?php foreach(Estados::Ver() as $row): ?>
                            <option value="<?= $row->id_estado ?>"><?= $row->codigo_estado . $row->des_estado ?></option>
                        <?php endforeach;?>
                    </select>
                </div>
                <!-- FIN DE ESTADO ACTUAL -->
                <div class="QR">
                    <img src="../img/img_qr/<?= $activo->qr ?>" alt="No se genero el QR">
                </div>
            </div>
            <button type="submit" name="guardar_cambios">GUARDAR CAMBIOS</button>
        </div>
    </div>
</form>