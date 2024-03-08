<?php
    include_once('../connection/Conexion.php');
    $classes = [
        'UbicacionGeneral',
        'UbicacionEspecifica',
        'Rubros',
        'TiposActivos',
        'Marcas',
        'Paises',
        'Estados',
        'Activo',
        'ActivosEstados',
        'CodigosAntiguos',
        'CodigosNuevos',
        'Facturas',
        'Usuarios',
        'Roles'
    ];
    foreach ($classes as $class) {
        require "../class/$class.php";
    }
    require '../vendor/autoload.php';
    
    
    $msg = 'Usted cuenta con ' . Activos::Total_vista_activos();

    if(isset($_POST['enviar_xls'])){
        Activos::Excel($_FILES['archivo_xls']);
    }
    if(isset($_POST['del_tipos'])){
        Conexion::Eliminar_Tablas();
    }
    
    /**
     *              BOTONES DE ADICION
     */
    if(isset($_POST['btnAddUbicacionGral_1'])){
        Ubicacion_General::Insertar($_POST['des_ubicacion_gral_old'], $_POST['cod_ubicacion_gral_old']);
    }
    if(isset($_POST['btnAddUbicacionGral_2'])){
        Ubicacion_General::Insertar($_POST['des_ubicacion_gral_new'], $_POST['cod_ubicacion_gral_new']);
    }
    if(isset($_POST['btnAddRubro_1'])){
        Rubros::Insertar($_POST['cod_rubro_old'], $_POST['des_rubro_old']);
    }
    if(isset($_POST['btnAddRubro_2'])){
        Rubros::Insertar($_POST['cod_rubro_new'], $_POST['des_rubro_new']);
    }
    if(isset($_POST['btnAddUbicacionEspecifica'])){
        Ubicacion_Especifica::Insertar($_POST['des_ubicacion_esp'], $_POST['cod_ubicacion_esp']);
    }
    if(isset($_POST['btnaddestado'])){
        Estados::Insertar($_POST['des_estado'], $_POST['cod_estado']);
    }
    /**
     *              BOTONES DE ACTIVOS
     */
    if(isset($_POST['addTipo'])){
        TiposActivos::InsertarNuevo($_POST['new_des_tipo']);
    }
    if(isset($_POST['addMarca'])){
        Marcas::InsertarNuevo($_POST['new_des_marca']);
    }
    if(isset($_POST['addPais'])){
        Paises::InsertarNuevo($_POST['new_des_pais']);
    }

    if(isset($_POST['back'])){
        Activos::InsertarNuevoActivo($_POST['activo_tipo'],$_POST['activo_detalles'],$_POST['activo_marca'],$_POST['activo_modelo'],$_POST['activo_serie'],$_POST['activo_pais'],$_POST['activo_anio'],$_POST['activo_valorInicial'],$_POST['activo_valorResidual'],$activo_foto,$_POST['activo_al2021']);
        $id_activo = Activos::UltimoID();
        Activos::Subir_Foto($_FILES['activo_foto'], $id_activo);
        Activos_estados::Insertar($id_activo, $_POST['activo_estado']);
        Codigo_nuevo::Insertar($id_activo, $_POST['NewRubro'], $_POST['NewUbicacionGeneral'], $_POST['NewUbicacionEspecifica'], $_POST['NewCorrelativo']);
        Codigo_antiguo::Insertar($id_activo, $_POST['OldRubro'], $_POST['OldUbicacionGeneral'], $_POST['OldCorrelativo']);
        $factura_foto = Facturas::Subir_foto($_FILES['activo_foto_factura'], $id_activo);
        Facturas::Insertar($_POST['activo_nfactura'], $_POST['activo_factura'], $factura_foto, $id_activo);
        Activos::generador_qr($id_activo);
        header('Location: ../html/tabla_activos.php');
    }
    if(isset($_POST['continue'])){
        Activos::InsertarNuevoActivo($_POST['activo_tipo'],$_POST['activo_detalles'],$_POST['activo_marca'],$_POST['activo_modelo'],$_POST['activo_serie'],$_POST['activo_pais'],$_POST['activo_anio'],$_POST['activo_valorInicial'], $_POST['activo_valorResidual'], $activo_foto, $_POST['activo_al2021']);
        $id_activo = Activos::UltimoID();
        Activos::Subir_Foto($_FILES['activo_foto'], $id_activo);
        Activos_estados::Insertar($id_activo, $_POST['activo_estado']);
        Codigo_nuevo::Insertar($id_activo, $_POST['NewRubro'], $_POST['NewUbicacionGeneral'], $_POST['NewUbicacionEspecifica'], $_POST['NewCorrelativo']);
        Codigo_antiguo::Insertar($id_activo, $_POST['OldRubro'], $_POST['OldUbicacionGeneral'], $_POST['OldCorrelativo']);
        $factura_foto = Facturas::Subir_foto($_FILES['activo_foto_factura'], $id_activo);
        Facturas::Insertar($_POST['activo_nfactura'], $_POST['activo_factura'], $factura_foto, $id_activo);
        Activos::generador_qr($id_activo);
        header('Location: ../html/formulario.php');
    }
    // EXPORTAR A EXCEL
    if (isset($_POST['exportar'])) {
        Activos::ExportarAVistaExcel();
    }
    if(isset($_POST['to'])){
        if($_POST['to'] > 100){
            $msg = 'No se pueden vizulizar mas de 100 activos. Usted cuenta con ' . Activos::TotalActivos() . ' Activos';
        }
        else{
            $msg = 'Usted cuenta con ' . Activos::TotalActivos();
        }
    }


    if (isset($_POST['qr'])) {
        $url = 'qr.php';
    }
    if(isset($_POST['pdf'])){
        $url = 'pdfInRealTime.php';
    }

    $totalPaginas = '';
    $datos = Activos::Ver();
    
    if(isset($_POST['ug_old'])){
        var_dump($_POST['buscador']);
        $datosPagina = Activos::Buscador($_POST['buscador'], $_POST['ug_old']);
    }
    else{
        
        // Número de resultados por página
        $resultadosPorPagina = 75;
    
        // Página actual
        $paginaActual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
    
        // Datos a mostrar (esto podría provenir de una consulta a la base de datos)
        // echo $_POST['s_ug_old'];
        $indiceInicio = ($paginaActual - 1) * $resultadosPorPagina;
        $indiceFinal = $indiceInicio + $resultadosPorPagina;
    
        // Filtra los datos para mostrar solo los de la página actual
        $datosPagina = array_slice($datos, $indiceInicio, $resultadosPorPagina);
        
        $totalRegistros = count($datos);
        $totalPaginas = ceil($totalRegistros / $resultadosPorPagina);
    }
    if(isset($_POST['rubro_old'])){
        $datosPagina = Activos::Buscador($_POST['buscador'], $_POST['rubro_old']);
    }
    if(isset($_POST['corr_old'])){
        $datosPagina = Activos::Buscador($_POST['buscador'], $_POST['corr_old']);
    }
    // CODIGO NUEVO
    if(isset($_POST['ug_new'])){
        $datosPagina = Activos::Buscador($_POST['buscador'], $_POST['ug_new']);
    }
    if(isset($_POST['ue_new'])){
        $datosPagina = Activos::Buscador($_POST['buscador'], $_POST['ue_new']);
    }
    if(isset($_POST['rubro_new'])){
        $datosPagina = Activos::Buscador($_POST['buscador'], $_POST['rubro_new']);
    }
    if(isset($_POST['corr_new'])){
        $datosPagina = Activos::Buscador($_POST['buscador'], $_POST['corr_new']);
    }
    if(isset($_POST['estado'])){
        $datosPagina = Activos::Buscador($_POST['buscador'], $_POST['estado']);
    }
    //ACTIVOS
    if(isset($_POST['buscador']) && strlen($_POST['buscador']) > 2){
            if(isset($_POST['activo'])){
                $datosPagina = Activos::Buscador_texto($_POST['buscador'], $_POST['activo']);
            }
            if(isset($_POST['detalles'])){
                $datosPagina = Activos::Buscador_texto($_POST['buscador'], $_POST['detalles']);
            }
            if(isset($_POST['marca'])){
                $datosPagina = Activos::Buscador_texto($_POST['buscador'], $_POST['marca']);
            }
            if(isset($_POST['modelo'])){
                $datosPagina = Activos::Buscador_texto($_POST['buscador'], $_POST['modelo']);
            }
            if(isset($_POST['serie'])){
                $datosPagina = Activos::Buscador_texto($_POST['buscador'], $_POST['activo']);
            }
            if(isset($_POST['pais'])){
                $datosPagina = Activos::Buscador_texto($_POST['buscador'], $_POST['pais']);
            }
            if(isset($_POST['anio'])){
                $datosPagina = Activos::Buscador_texto($_POST['buscador'], $_POST['anio']);
            }
            if(isset($_POST['empresa_factura'])){
                $datosPagina = Activos::Buscador_texto($_POST['buscador'], $_POST['empresa_factura']);
            }
            if(isset($_POST['nro_factura'])){
                $datosPagina = Activos::Buscador_texto($_POST['buscador'], $_POST['nro_factura']);
            }
            if(isset($_POST['valor_inicial'])){
                $datosPagina = Activos::Buscador_texto($_POST['buscador'], $_POST['valor_inicial']);
            }
            if(isset($_POST['al_2021'])){
                $datosPagina = Activos::Buscador_texto($_POST['buscador'], $_POST['al_2021']);
            }
            if(isset($_POST['valor_residual'])){
                $datosPagina = Activos::Buscador_texto($_POST['buscador'], $_POST['valor_residual']);
            }
            // if(isset($_POST['guardar_cambios'])){
            //     echo 'Se guardaron los cambios';
            // }
    }else{
        $minimo3digitos = 'ingrese minimo 3 caracteres';
    }
    $minimo3digitos = 'ingrese minimo 3 caracteres';

    /**
     * EDITAR DE FORMA PIOLIN
     */
    if(isset($_POST['guardar_cambios'])){
        Activos::Actualizar($_POST);
        $codigo_new = Codigo_nuevo::Buscar($_GET['valor']);
        $codigo_old = Codigo_antiguo::Buscar($_GET['valor']);
        Activos::generador_qr($_GET['valor']);
        if($_POST['editar_ug_new'] !== $codigo_new->id_ubicacion_gral || $_POST['editar_ue_new'] !== $codigo_new->id_ubicacion_esp || $_POST['editar_rubro_new'] !== $codigo_new->id_rubro || $_POST['editar_correlativo_new'] !== $codigo_new->correlativo_nuevo){
            Codigo_nuevo::Actualizar($_POST);
        }
        if ($_POST['editar_ug_old'] !== $codigo_old->id_ubicacion_gral || $_POST['editar_rubro_old'] !== $codigo_old->id_rubro || $_POST['editar_correlativo_old'] !== $codigo_old->correlativo_antiguo) {
            Codigo_antiguo::Actualizar($_POST);
        }
        // header('Location: tabla_activos.php?pagina=1');
    }
    if (isset($_FILES['editar_foto_activo']) && strlen($_FILES['editar_foto_activo']['name']) > 0) {
        echo 'Imagen del activo actualizada correctamente<br>';
        // echo '<pre>';
        // var_dump($_FILES['editar_foto_activo']);
        // echo '</pre>';
        Activos::Actualizar_foto($_FILES['editar_foto_activo'], $_GET['valor']);
    } 
    else if (isset($_FILES['editar_foto_factura']) && strlen($_FILES['editar_foto_factura']['name']) > 0) {
        echo 'Imagen de la factura actualizada correctamente<br>';
        // echo '<pre>';
        // var_dump($_FILES['editar_foto_factura']);
        // echo '</pre>';
        Facturas::Actualizar_foto($_FILES['editar_foto_factura'], $_GET['valor']);
    } else {
        // echo 'No se cambió la imagen del activo ni de la factura<br>';
    }
    if(isset($_POST['verificar'])){
        var_dump($_FILES['']);
        Activos::Verificar($_POST['verificar'],$_POST['id_verificar']);
        header('Location: '.$_SERVER['PHP_SELF']);
    }
    if(isset($_POST['sin_verificar'])){
        Activos::Verificar($_POST['sin_verificar'],$_POST['id_verificar']);
        header('Location: '.$_SERVER['PHP_SELF']);
    }
    if(isset($_POST['log_in'])){
        echo Usuarios::Verificar($_POST);
    }
    if(isset($_POST['crear_usuario'])){
        $dato = (object) $_POST;
        if(strlen($dato->usuario && $dato->password) > 0){
            Usuarios::Insertar($dato);
        }else{
            echo 'Datos vacios';
        }
    }
?>