<?php include '../templates/header.php' ?>
<?php require '../request/botones.php' ?>

    <link rel="stylesheet" href="../css//formulario2.css">
    <form action="" method="post" enctype="multipart/form-data" id="miFormulario" >
        <header>
            CODIGO ANTIGUO
        </header>
        <div class="campo">
            <!-- UBICACION GENERAL -->
            <div class="dato">
                <label for="">UBICACION GENERAL</label>
                <div>
                    <!-- <a href="ubicacion_general.php" class="add">lista</a> -->
                    <select name="OldUbicacionGeneral" id="" class="pdd">
                        <option value="<?= Ubicacion_General::Ultimo_dato()->id_ubicacion_gral ?>"><?= Ubicacion_General::Ultimo_dato()->codigo_ubicacion_gral . ' ' . Ubicacion_General::Ultimo_dato()->des_ubicacion_gral ?></option>
                        <?php foreach(Ubicacion_General::Ver() as $row): ?>
                            <option value="<?= $row->id_ubicacion_gral ?>"><?= $row->codigo_ubicacion_gral . ' ' . $row->des_ubicacion_gral ?></option>
                        <?php endforeach;?>
                    </select>
                    <label for="addUbicacionGral" class="add">+</label>
                </div>
                <input type="checkbox" name="ubg" id="addUbicacionGral" class="chk">
                <div>
                    <input type="number" name="cod_ubicacion_gral_old" id="" style="width: 50px;" placeholder="codigo">
                    <input type="text" name="des_ubicacion_gral_old" id="">
                    <button type="submit" class="add" name="btnAddUbicacionGral_1">Agregar</button>
                </div>
            </div>
            
            <!-- RUBROS -->
            <div class="dato">
                <label for="">RUBRO</label>
                <div>
                    <select name="OldRubro" id="" class="pdd">
                        <option value="<?= Rubros::Ultimo_dato()->id_rubro ?>"><?= Rubros::Ultimo_dato()->codigo_rubro . ' ' . Rubros::Ultimo_dato()->des_rubro ?></option>
                        <?php foreach(Rubros::Ver() as $row): ?>
                            <option value="<?= $row->id_rubro ?>"><?= $row->codigo_rubro . $row->des_rubro ?></option>
                        <?php endforeach;?>
                    </select>
                    <label for="addRubro" class="add">+</label>
                </div>
                <input type="checkbox" name="ar" id="addRubro" class="chk">
                <div>
                    <input type="number" name="cod_rubro_old" id="" style="width: 50px;" placeholder="codigo">
                    <input type="text" name="des_rubro_old" id="">
                    <button type="submit" class="add" name="btnAddRubro_1">Agregar</button>
                </div>
            </div>

            <!-- CODIGO CORRELATIVO -->
            <div class="dato">
                <label for="">CODIGO CORRELATIVO</label>
                <input type="text" name="OldCorrelativo" id="" class="pdd" placeholder="" value="S/C">
            </div>
        </div>
        <header>
            CODIGO NUEVO
        </header>
        <div class="campo">

            <!-- UBICACION GENERAL - CODIGO NUEVO -->
            <div class="dato">
                <label for="">UBICACION GENERAL</label>
                <div>
                    <!-- <a href="ubicacion_general.php" class="add">lista</a> -->
                    <select name="NewUbicacionGeneral" id="" class="pdd">
                        <option value="<?= Ubicacion_General::Ultimo_dato()->id_ubicacion_gral ?>"><?= Ubicacion_General::Ultimo_dato()->codigo_ubicacion_gral . ' ' . Ubicacion_General::Ultimo_dato()->des_ubicacion_gral ?></option>
                        <?php foreach(Ubicacion_General::Ver() as $row): ?>
                            <option value="<?= $row->id_ubicacion_gral ?>"><?= $row->codigo_ubicacion_gral . $row->des_ubicacion_gral ?></option>
                            <?php endforeach;?>
                        </select>
                        <label for="addUbiGral" class="add">+</label>
                </div>
                <input type="checkbox" name="ubg" id="addUbiGral" class="chk">
                <div>
                    <input type="number" name="cod_ubicacion_gral_new" id="" style="width: 50px;" placeholder="codigo">
                    <input type="text" name="des_ubicacion_gral_new" id="">
                    <button type="submit" class="add" name="btnAddUbicacionGral_2">Agregar</button>
                </div>
            </div>

            <!-- UBICACION ESPECIFICA - CODIGO NUEVO -->
            <div class="dato">
                <label for="">UBICACION ESPECIFICA</label>
                <div>
                    <select name="NewUbicacionEspecifica" id="" class="pdd">
                        <option value="<?= Ubicacion_Especifica::Ultimo_dato()->id_ubicacion_esp ?>"><?= Ubicacion_Especifica::Ultimo_dato()->codigo_ubicacion_esp . ' ' . Ubicacion_Especifica::Ultimo_dato()->des_ubicacion_esp ?></option>
                        <?php foreach(Ubicacion_Especifica::Ver() as $row): ?>
                            <option value="<?= $row->id_ubicacion_esp ?>"><?= $row->codigo_ubicacion_esp . $row->des_ubicacion_esp ?></option>
                        <?php endforeach;?>
                    </select>
                    <label for="addUbicacionEsp" class="add">+</label>
                </div>
                <input type="checkbox" name="" id="addUbicacionEsp" class="chk">
                <div>
                    <input type="number" name="cod_ubicacion_esp" id="" style="width: 50px;" placeholder="codigo">
                    <input type="text" name="des_ubicacion_esp" id="">
                    <button type="submit" class="add" name="btnAddUbicacionEspecifica">Agregar</button>
                </div>
            </div>

            <!-- RUBRO - CODIGO NUEVO -->
            <div class="dato">
                <label for="">RUBRO</label>
                <div>
                    <select name="NewRubro" id="" class="pdd">
                        <option value="<?= Rubros::Ultimo_dato()->id_rubro ?>"><?= Rubros::Ultimo_dato()->codigo_rubro . ' ' . Rubros::Ultimo_dato()->des_rubro ?></option>
                        <?php foreach(Rubros::Ver() as $row): ?>
                            <option value="<?= $row->id_rubro ?>"><?= $row->codigo_rubro . $row->des_rubro ?></option>
                        <?php endforeach;?>
                    </select>
                    <label for="addRubrOld" class="add">+</label>
                </div>
                <input type="checkbox" name="ar" id="addRubrOld" class="chk">
                <div>
                    <input type="number" name="cod_rubro_new" id="" style="width: 50px;" placeholder="codigo">
                    <input type="text" name="des_rubro_new" id="">
                    <button type="submit" class="add" name="btnAddRubro_2">Agregar</button>
                </div>
            </div>

            <!-- CODIGO CORRELATIVO - CODIGO NUEVO -->
            <div class="dato">
                <label for="">CODIGO CORRELATIVO</label>
                <input type="text" name="NewCorrelativo" id="" class="pdd" placeholder="CODIGO CORRELATIVO" value="S/C">
            </div>
        </div>

        <!-- ============================================ ACTIVO ============================================ -->
        <header>
            ACTIVO
        </header>
        <div class="campo campo-activo">

            <!-- TIPO DE ACTIVO -->
            <div class="dato">
                <label for="">ACTIVO</label>
                <div>
                    <select name="activo_tipo" id="" class="pdd">
                        <option value="<?= TiposActivos::Ultimo_dato()->id_tipo ?>"><?=TiposActivos::Ultimo_dato()->des_tipo ?></option>
                        <?php foreach(TiposActivos::Ver() as $row): ?>
                            <option value="<?= $row->id_tipo ?>"><?= $row->des_tipo ?></option>
                        <?php endforeach;?>
                    </select>
                    <label for="addActivo" class="add">+</label>
                </div>
                <input type="checkbox" name="" id="addActivo" class="chk">
                <div>
                    <input type="text" name="new_des_tipo" id="">
                    <button type="submit" class="add" name="addTipo">Agregar</button>
                </div>
            </div>
            
            <!-- DETALLES -->
            <div class="dato1" style="margin-top: 20px;">
                <label for="">DETALLES</label>
                <textarea name="activo_detalles" id="" cols="30" rows="10" placeholder="Detalles" class="pdd"></textarea>
            </div>
            <br>
            <!-- FOTO DE ACTIVO -->
            <div class="dato">
                <label for="">AGREGAR IMAGEN DE ACTIVO</label>
                <div>
                    <input type="file" name="activo_foto" id="" class="add">
                </div>
            </div>

            <div class="activo">

                <!-- MARCA -->
                <div class="dato">
                    <label for="">MARCA</label>
                    <div>
                        <select name="activo_marca" id="" class="pdd">
                        <option value="<?= Marcas::Ultimo_dato()->id_marca ?>"><?= Marcas::Ultimo_dato()->des_marca ?></option>
                            <?php foreach(Marcas::Ver() as $row): ?>
                                <option value="<?= $row->id_marca ?>"><?= $row->des_marca ?></option>
                            <?php endforeach;?>
                        </select>
                        <label for="addMarca" class="add">+</label>
                    </div>
                    <input type="checkbox" name="" id="addMarca" class="chk">
                    <div>
                        <input type="text" name="new_des_marca" id="">
                        <button type="submit" class="add" name="addMarca">Agregar</button>
                    </div>
                </div>

                <!-- MODELO -->
                <div class="dato">
                    <label for="">MODELO</label>
                    <input type="search" name="activo_modelo" id="" class="pdd" placeholder="MODELO" value="sin modelo">
                </div>

                <!-- SERIE -->
                <div class="dato">
                    <label for="">SERIE</label>
                    <input type="search" name="activo_serie" id="" class="pdd" placeholder="SERIE" value="sin serie">
                </div>

                <!-- PAIS -->
                <div class="dato">
                    <label for="">PAIS</label>
                    <div>
                        <select name="activo_pais" id="" class="pdd">
                        <option value="<?= Paises::Ultimo_dato()->id_pais ?>"><?= Paises::Ultimo_dato()->des_pais ?></option>
                            <?php foreach(Paises::Ver() as $row): ?>
                                <option value="<?= $row->id_pais ?>"><?= $row->des_pais ?></option>
                            <?php endforeach;?>
                        </select>
                        <label for="addPais" class="add">+</label>
                    </div>
                    <input type="checkbox" name="" id="addPais" class="chk">
                    <div>
                        <input type="text" name="new_des_pais" id="">
                        <button type="submit" class="add" name="addPais">Agregar</button>
                    </div>
                </div>

                <!-- AÑO -->
                <div class="dato">
                    <label for="">FECHA DE INGRESO</label>
                    <input type="date" name="activo_anio" id="" class="pdd" placeholder="AÑO" value="<?= date('Y-m-d') ?>">
                </div>
            </div>
        </div>
        <header>
            FACTURA
        </header>
        <div class="campo">
            <div class="dato">
                <label for="">EMPRESA FACTURA</label>
                <input type="text" name="activo_factura" id="" placeholder="EMPRESA FACTURA" class="pdd" value="sin empresa">
            </div>      
            <div class="dato">
                <label for="">NRO FACTURA</label>
                <input type="text" name="activo_nfactura" id="" placeholder="NRO FACTURA" class="pdd" value="000">
            </div>
            <!-- FOTO DE FACTURA -->
            <div class="dato">
                <label for="">AGREGAR FOTO DE FACTURA</label>
                <input type="file" name="activo_foto_factura" id="" class="add">
            </div>
        </div>
        <div class="campo">
            <!-- ESTADOS -->
            <div class="dato">
                <label for="">ESTADO</label>
                <div>
                    <select name="activo_estado" id="" class="pdd">
                        <option value="<?= Estados::Ultimo_dato()->id_estado ?>"><?= Estados::Ultimo_dato()->codigo_estado . ' ' . Estados::Ultimo_dato()->des_estado ?></option>
                        <?php foreach(Estados::Ver() as $row): ?>
                            <option value="<?= $row->id_estado ?>"><?= $row->codigo_estado . $row->des_estado ?></option>
                        <?php endforeach;?>
                    </select>
                    <label for="addEstado" class="add">+</label>
                </div>
                <input type="checkbox" name="" id="addEstado" class="chk">
                <div>
                    <input type="number" name="cod_estado" id="" style="width: 50px;" placeholder="codigo">
                    <input type="text" name="des_estado" id="" placeholder="nombre del estado">
                    <button type="submit" class="add" name="btnaddestado">Agregar</button>
                </div>
            </div>

            <!-- VALOR INCIAL -->
            <div class="dato">
                <label for="">VALOR INICIAL</label>
                <input type="number" name="activo_valorInicial" id="" placeholder="VALOR INICIAL" class="pdd" step="0.01" value="0.00">
            </div>

            <!-- AL 2021 -->
            <div class="dato">
                <label for="">AL 2021</label>
                <input type="number" name="activo_al2021" id="" placeholder="VALOR RESIDUAL" class="pdd" step="0.01" value="0.00">
            </div>

            <!-- VALOR RESIDUAL -->
            <div class="dato">
                <label for="">VALOR RESIDUAL</label>
                <input type="number" name="activo_valorResidual" id="" placeholder="VALOR RESIDUAL" class="pdd" step="0.01" value="0.00">
            </div>

        </div>
        <div class="botones">
            <button type="submit" name="back" value="r_back" class="btn_register">REGISTRAR</button>
            <button type="submit" name="continue" value="r_continue" class="btn_register">AGREGAR NUEVO</button>
        </div>
    </form>
    <script>
    // Para inputs y textarea
    document.getElementById('miFormulario').addEventListener('input', function(event) {
        if (event.target.tagName === 'INPUT' || event.target.tagName === 'TEXTAREA') {
            var nombreCampo = event.target.name;
            var valorCampo = event.target.value;
            localStorage.setItem(nombreCampo, valorCampo);
        }
    });

    // Para selects
    document.getElementById('miFormulario').addEventListener('change', function(event) {
        if (event.target.tagName === 'SELECT') {
            var nombreCampo = event.target.name;
            var valorCampo = event.target.value;
            localStorage.setItem(nombreCampo, valorCampo);
        }
    });

    window.addEventListener('load', function() {
        var form = document.getElementById('miFormulario');
        
        // Restaurar los valores de los campos del formulario
        for (var i = 0; i < form.elements.length; i++) {
            var element = form.elements[i];
            if (element.name) {
                var valorGuardado = localStorage.getItem(element.name);
                if (valorGuardado !== null) {
                    element.value = valorGuardado;
                }
            }
        }
    });

    window.addEventListener('unload', function() {
        // Al salir de la página, eliminar los datos almacenados
        var form = document.getElementById('miFormulario');
        for (var i = 0; i < form.elements.length; i++) {
            var element = form.elements[i];
            if (element.name) {
                localStorage.removeItem(element.name);
            }
        }
    });
</script>