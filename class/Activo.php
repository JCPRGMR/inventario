<?php
    include '../libqr/barcode.php';
    use PhpOffice\PhpSpreadsheet\IOFactory;
    
    class Activos extends Conexion{

        public static function InsertarNuevoActivo($id_tipo, $detalles, $id_marca, $modelo, $serie, $id_pais, $anio_compra, $valor_inicial, $valor_recidual, $foto, $al_2021){
            try {        
                $sql = "INSERT INTO activos(
                    id_tipo,       
                    detalles,      
                    id_marca,      
                    modelo,        
                    serie,         
                    id_pais,       
                    año_compra,    
                    valor_inicial, 
                    valor_recidual,
                    foto_activo,
                    al_2021,
                    verificado
                )VALUES (?,?,?,?,?,?,?,?,?,?,?, 1)";
                $stmt = Conexion::Abrir()->prepare($sql);
                $stmt->bindParam(1, $id_tipo, PDO::PARAM_INT);
                $stmt->bindParam(2, $detalles, PDO::PARAM_STR);
                $stmt->bindParam(3, $id_marca, PDO::PARAM_INT);
                $stmt->bindParam(4, $modelo, PDO::PARAM_STR);
                $stmt->bindParam(5, $serie, PDO::PARAM_STR);
                $stmt->bindParam(6, $id_pais, PDO::PARAM_INT);
                $stmt->bindParam(7, $anio_compra, PDO::PARAM_STR);
                $stmt->bindParam(8, $valor_inicial, PDO::PARAM_STR);
                $stmt->bindParam(9, $valor_recidual, PDO::PARAM_STR);
                $stmt->bindParam(10, $foto, PDO::PARAM_STR);
                $stmt->bindParam(11, $al_2021, PDO::PARAM_STR);
                $stmt->execute();
                echo 'Todo piola';
            } catch (PDOException $th) {
                echo 'Porfavor no deje campos vacios en activos';
            }
        }
        public static function Insertar_desde_excel($dato){
            try {
                $id_tipo = TiposActivos::Buscar_ID($dato[7]);
                $id_marca = Marcas::Buscar_ID($dato[9]);
                $id_pais = Paises::Buscar_ID($dato[12]);
                $fecha_php = date('Y-m-d', strtotime('1899-12-30 +' . $dato[13] . ' days'));
                // echo $fecha_php;

                $sql = "INSERT INTO activos (
                    id_tipo,
                    detalles,
                    id_marca,
                    modelo,
                    serie,
                    id_pais,
                    año_compra,
                    valor_inicial,
                    valor_recidual,
                    al_2021,
                    verificado
                )VALUES(?,?,?,?,?,?,?,?,?,?,0)";
                $stmt = Conexion::Abrir()->prepare($sql);
                $stmt->bindParam(1, $id_tipo, PDO::PARAM_INT);
                $stmt->bindParam(2, $dato[8], PDO::PARAM_STR);
                $stmt->bindParam(3, $id_marca, PDO::PARAM_INT);
                $stmt->bindParam(4, $dato[10], PDO::PARAM_STR);
                $stmt->bindParam(5, $dato[11], PDO::PARAM_STR);
                $stmt->bindParam(6, $id_pais, PDO::PARAM_INT);
                $stmt->bindParam(7, $fecha_php, PDO::PARAM_STR);
                $stmt->bindParam(8, $dato[17], PDO::PARAM_STR);
                $stmt->bindParam(9, $dato[18], PDO::PARAM_STR);
                $stmt->bindParam(10, $dato[19], PDO::PARAM_STR);
                $stmt->execute();
            } catch (PDOException $th) {
                echo $th->getMessage();
            }
        }
        public static function Excel($file){
            $funcion = new self();
            $file = $file['tmp_name'];
            if (!empty($file) && is_uploaded_file($file)) {

                $hoja_de_trabajo = IOFactory::load($file)->getActiveSheet();

                $ColumnLetter = $funcion->UCFormat();

                $data = [];

                $heightRow = $hoja_de_trabajo->getHighestRow();

                for($row = 4; $row <= $heightRow; $row++){
                    $rowData = [];
                    foreach ($ColumnLetter as $column) {
                        $rowData[] = $hoja_de_trabajo->getCell($column . $row)->getValue();
                    }
                    $data[] = $rowData;
                }
                //FOREACH INSERTAR DATOS ESCALABLES 
                foreach($data as $celda){
                    $ubicacion_general_1 = $celda[0];
                    $rubro_1 = $celda[1];
                    
                    $ubicacion_general_2 = $celda[3];
                    $ubicacion_especifica = $celda[4];
                    $rubro_2 = $celda[5];

                    $tipo = $celda[7];
                    $marca = $celda[9];
                    $pais = $celda[12];
                    $estado = $celda[16];

                    Ubicacion_General::Existe_desde_excel($ubicacion_general_1) && Ubicacion_General::InsertarDeExcel($ubicacion_general_1);
                    Rubros::Existe_desde_Excel($rubro_1) && Rubros::InsertarDeExcel($rubro_1);
                    
                    Ubicacion_General::Existe_desde_excel($ubicacion_general_2) && Ubicacion_General::InsertarDeExcel($ubicacion_general_2);
                    Ubicacion_Especifica::Existe_desde_excel($ubicacion_especifica) && Ubicacion_Especifica::InsertarDeExcel($ubicacion_especifica);
                    Rubros::Existe_desde_Excel($rubro_2) && Rubros::InsertarDeExcel($rubro_2);

                    TiposActivos::Buscar_ID($tipo);
                    Marcas::Buscar_ID($marca);
                    Paises::Buscar_ID($pais);
                    Estados::Buscar_desde_Excel($estado) && Estados::InsertarDeExcel($estado);
                }
                // //SUBIR ACTIVOS
                foreach($data as $casilla){
                    self::Insertar_desde_excel($casilla);
                    $id_activo = self::UltimoID();
                    Activos_estados::Insertar($id_activo, $casilla[16]);
                    Codigo_antiguo::Insertar($id_activo, $casilla[1], $casilla[0], $casilla[2]);
                    Codigo_nuevo::Insertar($id_activo, $casilla[5], $casilla[3], $casilla[4], $casilla[6]);
                    self::generador_qr($id_activo);
                }
                header('Location: ../html/tabla_activos.php');
            }else{
                echo 'Error al subir el archivo';
            }
        }
        public static function UltimoID(){
            try {
                $sql = "SELECT id_activo FROM activos ORDER BY id_activo DESC LIMIT 1";
                $stmt = Conexion::Abrir()->prepare($sql);
                $stmt->execute();
                return $stmt->fetchColumn();
            } catch (PDOException $th) {
                return $th->getMessage();
            }
        }
        public function UCFormat(){
            $rango = range('A', 'Z'); 
            $size_rango = count($rango);
            $rango[$size_rango] = 'ZZ';
            return $rango;
        }
        
        public static function VerPDF($from, $to){
            try {
                $sql = "SELECT * FROM vista_activos WHERE id_activo >= $from AND id_activo <= $to";
                $stmt = Conexion::Abrir()->prepare($sql);
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_OBJ);
            } catch (PDOException $th) {
                echo $th->getMessage();
            }
        }
        public static function pdfQR($from, $to){
            try {
                $sql = "SELECT * FROM vista_activos WHERE id_activo >= $from AND id_activo <= $to";
                $stmt = Conexion::Abrir()->prepare($sql);
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_OBJ);
            } catch (PDOException $th) {
                echo $th->getMessage();
            }
        }
        public static function BuscarParaEditar($id){
            $sql = "SELECT 
            id_activo,
            MAX(id_ubicacion_gral_old) AS id_ubicacion_gral_old,
            MAX(codigo_ubicacion_gral_old) AS codigo_ubicacion_gral_old,
            MAX(id_rubro_old) AS id_rubro_old,
            MAX(codigo_rubro_old) AS codigo_rubro_old,
            MAX(correlativo_antiguo) AS correlativo_antiguo,
            MAX(id_ubicacion_gral_new) AS id_ubicacion_gral_new,
            MAX(codigo_ubicacion_gral_new) AS codigo_ubicacion_gral_new,
            MAX(id_ubicacion_esp) AS id_ubicacion_esp,
            MAX(codigo_ubicacion_esp) AS codigo_ubicacion_esp,
            MAX(id_rubro_new) AS id_rubro_new,
            MAX(codigo_rubro_new) AS codigo_rubro_new,
            MAX(correlativo_nuevo) AS correlativo_nuevo,
            MAX(id_tipo) AS id_tipo,
            MAX(des_tipo) AS des_tipo,
            MAX(detalles) AS detalles,
            MAX(id_marca) AS id_marca,
            MAX(foto_factura) AS foto_factura,
            MAX(foto_activo) AS foto_activo,
            MAX(des_marca) AS des_marca,
            MAX(modelo) AS modelo,
            MAX(serie) AS serie,
            MAX(id_pais) AS id_pais,
            MAX(des_pais) AS des_pais,
            MAX(año_compra) AS año_compra,
            MAX(empresa_factura) AS empresa_factura,
            MAX(nro_factura) AS nro_factura,
            MAX(id_estado) AS id_estado,
            MAX(codigo_estado) AS codigo_estado,
            MAX(valor_inicial) AS valor_inicial,
            MAX(al_2021) AS al_2021,
            MAX(valor_recidual) AS valor_recidual,
            MAX(verificado) AS verificado,
            MAX(foto_factura) AS foto_factura,
            MAX(foto_activo) AS foto_activo,
            MAX(des_estado) AS des_estado,
            MAX(qr) AS qr
        FROM vista_activos 
        where id_activo = ? 
        GROUP BY id_activo 
        ORDER BY id_activo DESC";
            $stmt = Conexion::Abrir()->prepare($sql);
            $stmt->bindParam(1, $id, PDO::PARAM_INT);
            $stmt->execute();
            $resultados = $stmt->fetchObject();
            return $resultados;
        }
        public static function Buscar($id){
            $sql = "SELECT 
            id_activo,
            MAX(id_ubicacion_gral_old) AS id_ubicacion_gral_old,
            MAX(codigo_ubicacion_gral_old) AS codigo_ubicacion_gral_old,
            MAX(id_rubro_old) AS id_rubro_old,
            MAX(codigo_rubro_old) AS codigo_rubro_old,
            MAX(correlativo_antiguo) AS correlativo_antiguo,
            MAX(id_ubicacion_gral_new) AS id_ubicacion_gral_new,
            MAX(codigo_ubicacion_gral_new) AS codigo_ubicacion_gral_new,
            MAX(id_ubicacion_esp) AS id_ubicacion_esp,
            MAX(codigo_ubicacion_esp) AS codigo_ubicacion_esp,
            MAX(id_rubro_new) AS id_rubro_new,
            MAX(codigo_rubro_new) AS codigo_rubro_new,
            MAX(correlativo_nuevo) AS correlativo_nuevo,
            MAX(id_tipo) AS id_tipo,
            MAX(des_tipo) AS des_tipo,
            MAX(detalles) AS detalles,
            MAX(id_marca) AS id_marca,
            MAX(des_marca) AS des_marca,
            MAX(modelo) AS modelo,
            MAX(serie) AS serie,
            MAX(id_pais) AS id_pais,
            MAX(des_pais) AS des_pais,
            MAX(año_compra) AS año_compra,
            MAX(empresa_factura) AS empresa_factura,
            MAX(nro_factura) AS nro_factura,
            MAX(codigo_estado) AS codigo_estado,
            MAX(valor_inicial) AS valor_inicial,
            MAX(al_2021) AS al_2021,
            MAX(valor_recidual) AS valor_recidual,
            MAX(verificado) AS verificado,
            MAX(foto_factura) AS foto_factura,
            MAX(foto_activo) AS foto_activo,
            MAX(des_estado) AS des_estado
        FROM vista_activos 
        where id_activo = ? 
        GROUP BY id_activo 
        ORDER BY id_activo DESC";
            $stmt = Conexion::Abrir()->prepare($sql);
            $stmt->bindParam(1, $id, PDO::PARAM_INT);
            $stmt->execute();
            $resultados = $stmt->fetchAll(PDO::FETCH_OBJ);
            return $resultados;
        }
        public static function generador_qr($id){
            $qr = new barcode_generator();
            $styles = 'style="fill:#000; stroke:none;"';
        
            // Busca el activo
            // $codigo_antiguo = Codigo_antiguo::Buscar_para_editar($id);
            $Codigo_nuevo = Codigo_nuevo::Buscar_para_editar($id);
            $datos = self::Buscar($id);
        
            if (!empty($datos)) {
                $datos = $datos[0]; // Tomamos el primer objeto del array
        
                $svg = $qr->render_svg(
                    "qr",
                    " Tipo: " . $datos->des_tipo . "\n" .
                    " Marca: " . $datos->des_marca . "\n" .
                    " Pais: " . $datos->des_pais . "\n".
                    " ==== CODIGO NUEVO ====" .
                    " Correlativo: " . (!is_null($Codigo_nuevo) ? sprintf("%02d", $Codigo_nuevo->correlativo_nuevo) : '') . "\n" .
                    " Ubicacion general: " . (!is_null($Codigo_nuevo) ? sprintf("%02d", $Codigo_nuevo->codigo_ubicacion_gral) : '') . "\n" .
                    " Ubicacion especifica: " . (!is_null($Codigo_nuevo) ? sprintf("%02d", $Codigo_nuevo->codigo_ubicacion_esp) : '') . "\n" .
                    " Rubro: " . (!is_null($Codigo_nuevo) ? sprintf("%02d", $Codigo_nuevo->codigo_rubro) : '') . "\n"
                    ,$styles
                );                
        
                $carpetaDestino = '../img/img_qr';
        
                $nombreArchivo = $datos->id_activo . '.svg';
        
                $rutaCompletaArchivo = $carpetaDestino . '/' . $nombreArchivo;
        
                file_put_contents($rutaCompletaArchivo, $svg);
        
                if (file_exists($rutaCompletaArchivo)) {
                    // Actualiza la base de datos con el nombre del archivo
                    $sql = "UPDATE activos SET qr = ? WHERE id_activo = ?";
                    $stmt = Conexion::Abrir()->prepare($sql);
                    $stmt->bindParam(1, $nombreArchivo, PDO::PARAM_STR);
                    $stmt->bindParam(2, $id, PDO::PARAM_INT);
                    $stmt->execute();
                    return $nombreArchivo;
                } else {
                    echo 'No se pudo guardar el archivo SVG.';
                }
            } else {
                echo 'No se encontraron datos para generar el QR.';
            }
        }
        public static function Subir_foto($file, $id_activo){
            $file_temp = $file['tmp_name'];
            $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
            $destino = '../img/img_activos/';
            $nombre_img = $id_activo . '.' . $extension;
            move_uploaded_file($file_temp, $destino.$nombre_img);
            try {
                $sql = "UPDATE activos SET foto_activo = ? WHERE id_activo = ?";
                $stmt = Conexion::Abrir()->prepare($sql);
                $stmt->bindParam(1, $nombre_img, PDO::PARAM_STR);
                $stmt->bindParam(2, $id_activo, PDO::PARAM_INT);
                $stmt->execute();
                return $nombre_img;
            } catch (PDOException $th) {
                echo $th;
            }
            return $nombre_img;
        }
        public static function Actualizar_foto($file, $id_activo) {
            $file_temp = $file['tmp_name'];
            $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
            $destino = '../img/img_activos/';
        
            $foto_factura = Activos::BuscarParaEditar($id_activo)->foto_factura;
            // Eliminar espacios en blanco y obtener los últimos 2 caracteres
            $id_activo_modificado = trim($id_activo, ' ');
        
            // Formar el nuevo nombre de la imagen
            $nombre_img = $id_activo_modificado . '.' . $extension;
        
            // Mover el archivo
            move_uploaded_file($file_temp, $destino . $nombre_img);
        
            try {
                // Actualizar la base de datos
                $sql = "UPDATE facturas SET foto_factura = ? WHERE id_activo = ?; UPDATE activos SET foto_activo = ? WHERE id_activo = ?";
                $stmt = Conexion::Abrir()->prepare($sql);
                $stmt->bindParam(1, $foto_factura, PDO::PARAM_STR);
                $stmt->bindParam(2, $id_activo, PDO::PARAM_INT);
                $stmt->bindParam(3, $nombre_img, PDO::PARAM_STR);
                $stmt->bindParam(4, $id_activo, PDO::PARAM_INT);
                $stmt->execute();
        
                return $nombre_img;
            } catch (PDOException $th) {
                echo $th;
            }
        
            return $nombre_img;
        }
        
        public static function ExportarAVistaExcel() {
            try {
                // Conecta a la base de datos y ejecuta la consulta
                $sql = "SELECT * FROM vista_activos ORDER BY id_activo DESC";
                $stmt = Conexion::Abrir()->prepare($sql);
                $stmt->execute();
                $data = $stmt->fetchAll(PDO::FETCH_OBJ);
        
                // Crea un nuevo objeto Spreadsheet
                $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        
                // Selecciona la hoja activa
                $sheet = $spreadsheet->getActiveSheet();
        
                // Encabezados de las columnas

                $sheet->setCellValue('A2', 'CODIGO ANTIGUO');
                $sheet->setCellValue('D2', 'CODIGO NUEVO');
                $sheet->setCellValue('A3', 'UG');
                $sheet->setCellValue('B3', 'Rub');
                $sheet->setCellValue('C3', 'Corr.');
                $sheet->setCellValue('D3', 'UG');
                $sheet->setCellValue('E3', 'UE');
                $sheet->setCellValue('F3', 'RUB');
                $sheet->setCellValue('G3', 'Cod corr.');
                $sheet->setCellValue('H3', 'ACTIVO');
                $sheet->setCellValue('I3', 'DETALLES');
                $sheet->setCellValue('J3', 'MARCA');
                $sheet->setCellValue('K3', 'MODELO');
                $sheet->setCellValue('L3', 'SERIE');
                $sheet->setCellValue('M3', 'PAIS');
                $sheet->setCellValue('N3', 'AÑO');
                $sheet->setCellValue('O3', 'EMPRESA FACTURA');
                $sheet->setCellValue('P3', 'FACTURA');
                $sheet->setCellValue('Q3', 'ESTADO');
                $sheet->setCellValue('R3', 'VALOR INICIAL');
                $sheet->setCellValue('S3', 'AL 2021');
                $sheet->setCellValue('T3', 'VALOR RESIDUAL');
                // Agrega más encabezados según tus columnas
        
                // Llena los datos desde la base de datos
                $row = 4;
                foreach ($data as $row_data) {
                    $sheet->setCellValue('A' . $row,  (is_null($row_data->codigo_ubicacion_gral_old)) ? '': sprintf("%02d",  $row_data->codigo_ubicacion_gral_old));
                    $sheet->setCellValue('B' . $row,  (is_null($row_data->codigo_rubro_old)) ? '': sprintf("%02d",  $row_data->codigo_rubro_old));
                    $sheet->setCellValue('C' . $row,  (is_null($row_data->correlativo_antiguo)) ? '': sprintf("%02d",  $row_data->correlativo_antiguo));
                    $sheet->setCellValue('D' . $row,  sprintf("%04d",  $row_data->codigo_ubicacion_gral_new) );
                    $sheet->setCellValue('E' . $row,  sprintf("%04d",  $row_data->codigo_ubicacion_esp) );
                    $sheet->setCellValue('F' . $row,  sprintf("%04d",  $row_data->codigo_rubro_new) );
                    $sheet->setCellValue('G' . $row,  sprintf("%04d",  $row_data->correlativo_nuevo) );

                    $sheet->setCellValue('H' . $row, $row_data->des_tipo);
                    $sheet->setCellValue('I' . $row, $row_data->detalles);
                    $sheet->setCellValue('J' . $row, $row_data->des_marca);
                    $sheet->setCellValue('K' . $row, $row_data->modelo);
                    $sheet->setCellValue('L' . $row, $row_data->serie);
                    $sheet->setCellValue('M' . $row, $row_data->des_pais);
                    $sheet->setCellValue('N' . $row, $row_data->año_compra);

                    $sheet->setCellValue('O' . $row, $row_data->empresa_factura);
                    $sheet->setCellValue('P' . $row, $row_data->nro_factura);
                    $sheet->setCellValue('Q' . $row, $row_data->codigo_estado);
                    $sheet->setCellValue('R' . $row, $row_data->valor_inicial);
                    $sheet->setCellValue('S' . $row, $row_data->al_2021);
                    $sheet->setCellValue('T' . $row, $row_data->valor_recidual);
                    $sheet->setCellValue('U' . $row, $row_data->id_activo);
                    $row++;
                }
        
                // Crea un objeto Writer para Excel (XLSX)
                $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        
                // Define el nombre del archivo de salida
                $filename = 'exported_data.xlsx';
        
                // Establece las cabeceras para forzar la descarga del archivo
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename="' . $filename . '"');
                header('Cache-Control: max-age=0');
        
                // Escribe el archivo Excel en la salida
                $writer->save('php://output');
                exit;
            } catch (PDOException $th) {
                echo $th->getMessage();
            }
        }
        public static function Idmenor(){
            try {
                $sql = "SELECT MIN(id_activo) FROM vista_activos";
                $stmt = Conexion::Abrir()->prepare($sql);
                $stmt->execute();
                return $stmt->fetchColumn();
            } catch (PDOException $th) {
                echo $th->getMessage();
            }
        }
        public static function TotalActivos(){
            try {
                $sql = "SELECT COUNT(*) from activos";
                $stmt = Conexion::Abrir()->prepare($sql);
                $stmt->execute();
                return $stmt->fetchColumn();
            } catch (PDOException $th) {
                echo $th->getMessage();
            }
        }
        public static function BuscadorAutomatico($dato){
            try {
                $sql = "SELECT * FROM vista_activos WHERE id_activo = ? OR des_tipo LIKE ? OR detalles LIKE ? OR des_marca LIKE ?";
                $stmt = Conexion::Abrir()->prepare($sql);
                $datoCadena = "%$dato%";
                $stmt->bindParam(1, $dato, PDO::PARAM_STR);
                $stmt->bindParam(2, $datoCadena, PDO::PARAM_STR);
                $stmt->bindParam(3, $datoCadena, PDO::PARAM_STR);
                $stmt->bindParam(4, $datoCadena, PDO::PARAM_STR);
                $stmt->execute();
                $res = $stmt->fetchAll(PDO::FETCH_OBJ);
                if(!empty($res)){
                    return json_encode($res); // Enviar los resultados como JSON
                } else {
                    return false;
                }
            } catch (PDOException $th) {
                echo $th;
            }
        }
        
        public static function Ver(){
            try {
                $sql = "SELECT
                id_activo,
                MAX(codigo_ubicacion_gral_old) AS codigo_ubicacion_gral_old,
                MAX(codigo_rubro_old) AS codigo_rubro_old,
                MAX(correlativo_antiguo) AS correlativo_antiguo,
                MAX(codigo_ubicacion_gral_new) AS codigo_ubicacion_gral_new,
                MAX(codigo_ubicacion_esp) AS codigo_ubicacion_esp,
                MAX(codigo_rubro_new) AS codigo_rubro_new,
                MAX(correlativo_nuevo) AS correlativo_nuevo,
                MAX(des_tipo) AS des_tipo,
                MAX(detalles) AS detalles,
                MAX(des_marca) AS des_marca,
                MAX(modelo) AS modelo,
                MAX(serie) AS serie,
                MAX(des_pais) AS des_pais,
                MAX(año_compra) AS año_compra,
                MAX(empresa_factura) AS empresa_factura,
                MAX(nro_factura) AS nro_factura,
                MAX(codigo_estado) AS codigo_estado,
                MAX(valor_inicial) AS valor_inicial,
                MAX(al_2021) AS al_2021,
                MAX(valor_recidual) AS valor_recidual,
                MAX(verificado) AS verificado
            FROM vista_activos
            GROUP BY id_activo
            ORDER BY id_activo DESC;
            ";
                $stmt = Conexion::Abrir()->prepare($sql);
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_OBJ);
            } catch (PDOException $th) {
                echo $th->getMessage();
            }
        }
        public static function Total_vista_activos(){
            try {
                $sql = "SELECT COUNT(*) AS total FROM vista_activos";
                $stmt = Conexion::Abrir()->prepare($sql);
                $stmt->execute();
                
                // Obtener el resultado como un array asociativo
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                
                // Extraer el valor 'total' del resultado
                $totalCount = $result['total'];
        
                // Devolver el total de registros
                return $totalCount;
            } catch (PDOException $th) {
                // Registrar o manejar la excepción de manera apropiada
                error_log($th->getMessage());
                // Puedes optar por relanzar la excepción o devolver un mensaje de error
                return "Se produjo un error al obtener el conteo total.";
            }
        }
        
        public static function Buscador($dato, $campo){
            try {
                $sql = "SELECT
                id_activo,
                MAX(codigo_ubicacion_gral_old) AS codigo_ubicacion_gral_old,
                MAX(codigo_rubro_old) AS codigo_rubro_old,
                MAX(correlativo_antiguo) AS correlativo_antiguo,
                MAX(codigo_ubicacion_gral_new) AS codigo_ubicacion_gral_new,
                MAX(codigo_ubicacion_esp) AS codigo_ubicacion_esp,
                MAX(codigo_rubro_new) AS codigo_rubro_new,
                MAX(correlativo_nuevo) AS correlativo_nuevo,
                MAX(des_tipo) AS des_tipo,
                MAX(detalles) AS detalles,
                MAX(des_marca) AS des_marca,
                MAX(modelo) AS modelo,
                MAX(serie) AS serie,
                MAX(des_pais) AS des_pais,
                MAX(año_compra) AS año_compra,
                MAX(empresa_factura) AS empresa_factura,
                MAX(nro_factura) AS nro_factura,
                MAX(codigo_estado) AS codigo_estado,
                MAX(valor_inicial) AS valor_inicial,
                MAX(al_2021) AS al_2021,
                MAX(valor_recidual) AS valor_recidual,
                MAX(verificado) AS verificado
            FROM vista_activos WHERE " . $campo . " = ? 
                GROUP BY id_activo
                ORDER BY id_activo DESC";
                $stmt = Conexion::Abrir()->prepare($sql);
                $stmt->bindParam(1, $dato, PDO::PARAM_STR);
                
                if($stmt->execute()){
                    return $stmt->fetchAll(PDO::FETCH_OBJ); 
                } else {
                    echo 'Error en la ejecución de la consulta.';
                    return array(); // O puedes devolver false u otro valor que indique un error
                }
            } catch (PDOException $th) {
                echo $th->getMessage();
                return array(); // O puedes devolver false u otro valor que indique un error
            }
        }
        public static function Buscador_texto($texto, $campo){
            try {
                    $sql = "SELECT
                id_activo,
                MAX(codigo_ubicacion_gral_old) AS codigo_ubicacion_gral_old,
                MAX(codigo_rubro_old) AS codigo_rubro_old,
                MAX(correlativo_antiguo) AS correlativo_antiguo,
                MAX(codigo_ubicacion_gral_new) AS codigo_ubicacion_gral_new,
                MAX(codigo_ubicacion_esp) AS codigo_ubicacion_esp,
                MAX(codigo_rubro_new) AS codigo_rubro_new,
                MAX(correlativo_nuevo) AS correlativo_nuevo,
                MAX(des_tipo) AS des_tipo,
                MAX(detalles) AS detalles,
                MAX(des_marca) AS des_marca,
                MAX(modelo) AS modelo,
                MAX(serie) AS serie,
                MAX(des_pais) AS des_pais,
                MAX(año_compra) AS año_compra,
                MAX(empresa_factura) AS empresa_factura,
                MAX(nro_factura) AS nro_factura,
                MAX(codigo_estado) AS codigo_estado,
                MAX(valor_inicial) AS valor_inicial,
                MAX(al_2021) AS al_2021,
                MAX(valor_recidual) AS valor_recidual,
                MAX(verificado) AS verificado
            FROM vista_activos WHERE " . $campo . " LIKE ? 
                    GROUP BY id_activo
                    ORDER BY id_activo DESC";
                    $stmt = Conexion::Abrir()->prepare($sql);
                    $cadena = "%$texto%";
                    $stmt->bindParam(1, $cadena, PDO::PARAM_STR);
                    if($stmt->execute()){
                        return $stmt->fetchAll(PDO::FETCH_OBJ);
                    } else {
                        echo 'Error en la ejecución de la consulta.';
                        return array(); 
                    }
            } catch (PDOException $th) {
                echo $th->getMessage();
            }
        }

        public static function Actualizar($editar_dato){
            // echo $dato_activo['activo_estado'] . ' No funca hermano';
            try {
                $sql = "UPDATE activos SET id_tipo = ?, detalles = ?, id_marca = ?, modelo = ?, serie = ?, id_pais = ?, año_compra = ?, valor_inicial = ?, valor_recidual = ?, al_2021 = ?/*, qr = ?*/ WHERE id_activo = ?";
                $stmt = Conexion::Abrir()->prepare($sql);
                $stmt->bindParam(1, $editar_dato['editar_tipo'], PDO::PARAM_INT);
                $stmt->bindParam(2, $editar_dato['editar_detalles'], PDO::PARAM_STR);
                $stmt->bindParam(3, $editar_dato['editar_marca'], PDO::PARAM_INT);
                $stmt->bindParam(4, $editar_dato['editar_modelo'], PDO::PARAM_STR);
                $stmt->bindParam(5, $editar_dato['editar_serie'], PDO::PARAM_STR);
                $stmt->bindParam(6, $editar_dato['editar_pais'], PDO::PARAM_INT);
                $stmt->bindParam(7, $editar_dato['editar_anio_compra'], PDO::PARAM_STR);
                $stmt->bindParam(8, $editar_dato['editar_valor_incial'], PDO::PARAM_STR);
                $stmt->bindParam(9, $editar_dato['editar_valor_residual'], PDO::PARAM_STR);
                $stmt->bindParam(10, $editar_dato['editar_al_2021'], PDO::PARAM_STR);
                $stmt->bindParam(11, $editar_dato['id_activo'], PDO::PARAM_STR);
                $stmt->execute();
                // self::generador_qr($editar_dato['id_activo']);
                // echo 'Activo actualizado correctamete';
            } catch (PDOException $th) {
                echo $th->getMessage();
            }
        }
        public static function Verificar($check, $id){
            try {
                $sql = "UPDATE activos SET verificado = ? WHERE id_activo = ?";
                $stmt = Conexion::Abrir()->prepare($sql);
                $stmt->bindParam(1, $check, PDO::PARAM_INT);
                $stmt->bindParam(2, $id, PDO::PARAM_INT);
                $stmt->execute();
            } catch (PDOException $th) {
                echo $th->getMessage();
            }
        }
        // public static function
    }
?>