<?php
    class Facturas{
        public static function Insertar($nro_factura, $empresa, $foto_factura, $id_activo){
            try {
                $sql = "INSERT INTO facturas (nro_factura, empresa_factura, foto_factura, id_activo) VALUES (?,?,?,?)";
                $stmt = Conexion::Abrir()->prepare($sql);
                $stmt->bindParam(1, $nro_factura, PDO::PARAM_STR);
                $stmt->bindParam(2, $empresa, PDO::PARAM_STR);
                $stmt->bindParam(3, $foto_factura, PDO::PARAM_STR);
                $stmt->bindParam(4, $id_activo, PDO::PARAM_INT);
                $stmt->execute();
            } catch (PDOException $th) {
                echo $th->getMessage();
                // echo 'Esta enviando valores vacios en la factura, vuelva atras y revise los datos por favor';
            }
        }
        public static function Subir_foto($file, $id_activo){
            $file_temp = $file['tmp_name'];
            $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
            $destino = 'D:/inventario_img/facturas/';
            $nombre_pdf = $id_activo . '.' . $extension;
            move_uploaded_file($file_temp, $destino.$nombre_pdf);
            return $nombre_pdf;
        }
        public static function Actualizar_foto($file, $id_activo) {
            $file_temp = $file['tmp_name'];
            $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
            $destino = 'D:/inventario_img/facturas/';
        
            $foto_activo = Activos::BuscarParaEditar($id_activo)->foto_activo;
            
            // Eliminar espacios en blanco y obtener los últimos 2 caracteres
            $id_activo_modificado = /*substr(*/str_replace(' ', '', $id_activo)/*, -2)*/;
        
            // Formar el nuevo nombre de la imagen
            $nombre_img = $id_activo_modificado . '.' . $extension;
        
            // Mover el archivo
            move_uploaded_file($file_temp, $destino . $nombre_img);
        
            try {
                // Actualizar la base de datos
                $sql = "UPDATE facturas SET foto_factura = ? WHERE id_activo = ?; UPDATE activos SET foto_activo = ? WHERE id_activo = ?";
                $stmt = Conexion::Abrir()->prepare($sql);
                $stmt->bindParam(1, $nombre_img, PDO::PARAM_STR);
                $stmt->bindParam(2, $id_activo, PDO::PARAM_INT);
                $stmt->bindParam(3, $foto_activo, PDO::PARAM_STR);
                $stmt->bindParam(4, $id_activo, PDO::PARAM_INT);
                $stmt->execute();
        
                return $nombre_img;
            } catch (PDOException $th) {
                echo $th;
            }
        
            return $nombre_img;
        }
    }