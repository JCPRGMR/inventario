<?php
    class Codigo_nuevo extends Conexion{
        public static function Insertar($id_activo, $id_rubro, $id_ubicacion_gral, $id_ubicacion_esp, $correlativo){
            // $correlativo = sprintf("%04d", $correlativo);
            try {
                $sql = "INSERT INTO codigo_nuevo (id_activo, id_rubro, id_ubicacion_gral, id_ubicacion_esp, registro_cod_nuevo, correlativo_nuevo) VALUES (?,?,?,?,NOW(),?)";
                $stmt = Conexion::Abrir()->prepare($sql);
                $stmt->bindParam(1, $id_activo, PDO::PARAM_INT);
                $stmt->bindParam(2, $id_rubro, PDO::PARAM_INT);
                $stmt->bindParam(3, $id_ubicacion_gral, PDO::PARAM_INT);
                $stmt->bindParam(4, $id_ubicacion_esp, PDO::PARAM_INT);
                $stmt->bindParam(5, $correlativo, PDO::PARAM_STR);
                if($stmt->execute()){
                    // echo 'CODIGO_NUEVO insertado correctamente';
                }else{
                    echo 'Error al enviar el estado';
                }
            } catch (PDOException $th) {
                echo $th->getMessage();
            }
        }
        public static function Buscar_desde_Excel($correlativo){
            try {
                $sql = "SELECT * FROM codigo_nuevo WHERE correlativo_nuevo = ?";
                $stmt = Conexion::Abrir()->prepare($sql);
                $stmt->bindParam(1, $correlativo, PDO::PARAM_STR);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                return (empty($result)) ? true : false;
            } catch (PDOException $th) {
                echo $th->getMessage();
            }
        }
        public static function Buscar($id){
            try {
                $sql = "SELECT * FROM codigo_nuevo WHERE id_activo = ? ORDER BY registro_cod_nuevo DESC";
                $stmt = Conexion::Abrir()->prepare($sql);
                $stmt->bindParam(1, $id, PDO::PARAM_STR);
                $stmt->execute();
                $result = $stmt->fetchObject();
                return $result;
            } catch (PDOException $th) {
                echo $th->getMessage();
            }
        }
        public static function Actualizar($datos){
            // echo '<pre>';
            // var_dump($datos);
            // echo '</pre>';
            try {
                // $codigo_old = self::Buscar($datos['id_activo']);
                // if($datos['editar_ug_new'] !== $codigo_old->id_ubicacion_gral || $datos['editar_ue_new'] !== $codigo_old->id_ubicacion_esp || $datos['editar_rubro_new'] !== $codigo_old->id_rubro || $datos['editar_correlativo_new'] !== $codigo_old->correlativo_antiguo){
                    $sql = "INSERT INTO codigo_nuevo (id_activo, id_rubro, id_ubicacion_gral, id_ubicacion_esp, registro_cod_nuevo, correlativo_nuevo) 
                    VALUES (?, ?, ?, ?, NOW(), ?)";
                    $stmt = Conexion::Abrir()->prepare($sql);
                    $stmt->bindParam(1, $datos['id_activo'], PDO::PARAM_INT);
                    $stmt->bindParam(2, $datos['editar_rubro_new'], PDO::PARAM_INT);
                    $stmt->bindParam(3, $datos['editar_ug_new'], PDO::PARAM_INT);
                    $stmt->bindParam(4, $datos['editar_ue_new'], PDO::PARAM_INT);
                    $stmt->bindParam(5, $datos['editar_correlativo_new'], PDO::PARAM_STR);
                    $stmt->execute();
                    Activos::generador_qr($datos['id_activo']);
                    // echo ' Codigo nuevo actualizado correctamente';
                // }
            } catch (PDOException $th) {
                echo $th->getMessage();
            }
        }
        public static function Buscar_para_editar($id){
            try {
                $sql = "SELECT codigo_nuevo.*, ubicacion_general.des_ubicacion_gral, ubicacion_general.codigo_ubicacion_gral, ubicacion_especifica.des_ubicacion_esp, ubicacion_especifica.codigo_ubicacion_esp, rubro.des_rubro, rubro.codigo_rubro
                from codigo_nuevo 
                inner join ubicacion_general on ubicacion_general.id_ubicacion_gral = codigo_nuevo.id_ubicacion_gral
                inner join ubicacion_especifica on ubicacion_especifica.id_ubicacion_esp = codigo_nuevo.id_ubicacion_esp
                inner join rubro on rubro.id_rubro = codigo_nuevo.id_rubro
                where id_activo = ? ORDER BY registro_cod_nuevo DESC limit 1";
                
                $stmt = Conexion::Abrir()->prepare($sql);
                $stmt->bindParam(1, $id, PDO::PARAM_INT);
                $stmt->execute();
        
                if ($stmt->rowCount() > 0) {
                    // FetchObject solo cuando hay resultados
                    $resultados = $stmt->fetchObject();
                    return $resultados;
                } else {
                    return 'DATO NO RECONOCIDO';
                }
            } catch (PDOException $e) {
                // Manejar la excepción de la base de datos
                return 'Error en la consulta: ' . $e->getMessage();
            }
        }
        
    }