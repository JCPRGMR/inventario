<?php
    class Codigo_antiguo extends Conexion{
        public static function Insertar($id_activo, $id_rubro, $id_ubicacion_gral, $correlativo){
            try {
                $sql = "INSERT INTO codigo_antiguo (id_activo, id_rubro, id_ubicacion_gral, registro_cod_antiguo, correlativo_antiguo) VALUES (?,?,?,NOW(),?)";
                $stmt = Conexion::Abrir()->prepare($sql);
                $stmt->bindParam(1, $id_activo, PDO::PARAM_INT);
                $stmt->bindParam(2, $id_rubro, PDO::PARAM_INT);
                $stmt->bindParam(3, $id_ubicacion_gral, PDO::PARAM_INT);
                $stmt->bindParam(4, $correlativo, PDO::PARAM_STR);
                if($stmt->execute()){
                    // echo 'Codigo Antiguo insertado correctamente';
                }else{
                    echo 'Error al enviar el estado';
                }
            } catch (PDOException $th) {
                echo $th->getMessage();
            }
        }
        
        public static function Buscar_desde_Excel($correlativo){
            try {
                $sql = "SELECT * FROM codigo_antiguo WHERE correlativo_antiguo = ?";
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
                $sql = "SELECT * FROM codigo_antiguo WHERE id_activo = ? ORDER BY registro_cod_antiguo DESC";
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
            try {
                // $codigo_old = self::Buscar($datos['id_activo']);
                // if ($datos['editar_ug_old'] !== $codigo_old->id_ubicacion_gral || $datos['editar_rubro_old'] !== $codigo_old->id_rubro || $datos['editar_correlativo_old'] !== $codigo_old->correlativo_antiguo) {
                    $sql = "INSERT INTO codigo_antiguo (id_activo, id_rubro, id_ubicacion_gral, registro_cod_antiguo, correlativo_antiguo) VALUES (?, ?, ?, NOW(), ?)";
                    $stmt = Conexion::Abrir()->prepare($sql);
                    $stmt->bindParam(1, $datos['id_activo'], PDO::PARAM_INT);
                    $stmt->bindParam(2, $datos['editar_rubro_old'], PDO::PARAM_INT);
                    $stmt->bindParam(3, $datos['editar_ug_old'], PDO::PARAM_INT);
                    $stmt->bindParam(4, $datos['editar_correlativo_old'], PDO::PARAM_STR);
                    $stmt->execute();
                    Activos::generador_qr($datos['id_activo']);
                    // echo ' Codigo antiguo actualizado correctamente';
                // }
            } catch (PDOException $th) {
                echo $th->getMessage();
            }
        }
        public static function Buscar_para_editar($id){
            $sql = "SELECT * FROM codigo_antiguo 
            INNER JOIN ubicacion_general on ubicacion_general.id_ubicacion_gral = codigo_antiguo.id_ubicacion_gral
            inner join rubro on rubro.id_rubro = codigo_antiguo.id_rubro
            WHERE id_activo = ? ORDER BY registro_cod_antiguo DESC LIMIT 1";
            $stmt = Conexion::Abrir()->prepare($sql);
            $stmt->bindParam(1, $id, PDO::PARAM_INT);
            $stmt->execute();
            // $resultados = $stmt->fetchObject();
            // return $resultados;
            if ($stmt->rowCount() > 0) {
                // FetchObject solo cuando hay resultados
                $resultados = $stmt->fetchObject();
                return $resultados;
            } else {
                // Devolver un valor por defecto (puedes devolver un objeto vacío o nulo, dependiendo de tus necesidades)
                return null;
            }
        }
    }