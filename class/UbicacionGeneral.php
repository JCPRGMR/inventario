<?php
    class Ubicacion_General extends Conexion{
        static public function Ver(){
            try {
                $sql = "SELECT * FROM ubicacion_general ORDER BY codigo_ubicacion_gral ASC";
                $stmt = Conexion::Abrir()->prepare($sql);
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_OBJ);
            } catch (PDOException $th) {
                return $th->getMessage();
            }
        }
        static public function InsertarDeExcel($cod_ug){
            try {
                if(!is_null($cod_ug)){
                    $sql = "INSERT INTO ubicacion_general(registro_ubicacion_gral, codigo_ubicacion_gral) VALUES(NOW(), ?)";
                    $stmt = Conexion::Abrir()->prepare($sql);
                    $stmt->bindParam(1, $cod_ug, PDO::PARAM_STR);
                    $stmt->execute();
                }
            } catch (PDOException $th) {
                echo $th->getMessage();
            }
        }
        static public function Existe_desde_excel($codigo){
            try {
                $sql = "SELECT * FROM ubicacion_general WHERE codigo_ubicacion_gral = ?";
                $stmt = Conexion::Abrir()->prepare($sql);
                $stmt->bindParam(1, $codigo, PDO::PARAM_STR);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                return (empty($result)) ? true : false;
            } catch (PDOException $th) {
                echo $th->getMessage();
            }
        }
        public static function Buscar_ID($cod_ug) {
            $sql = "SELECT id_ubicacion_gral FROM ubicacion_general WHERE codigo_ubicacion_gral LIKE ?";
            $stmt = Conexion::Abrir()->prepare($sql);
            $stmt->bindParam(1, $cod_ug, PDO::PARAM_STR);
        
            try {
                if ($stmt->execute()) {
                    $result = $stmt->fetchColumn();
                    if ($result !== false) {
                        return $result;
                    } else {
                        // Si no se encontró el tipo, lo insertamos
                        self::InsertarDeExcel($cod_ug);
                        // Recuperamos el ID nuevamente
                        $stmt->execute();
                        $result = $stmt->fetchColumn();
                        return $result !== false ? $result : null;
                    }
                } else {
                    echo 'Error al ejecutar la consulta de búsqueda';
                }
            } catch (PDOException $th) {
                echo $th->getMessage();
            }
        
            return null;
        }

        /*****************************************************
         *                      CRUD
         *****************************************************/
        static public function Insertar($des_ubicacion, $codigo_ubicacion_gral){
            $sql = "INSERT INTO ubicacion_general (des_ubicacion_gral, registro_ubicacion_gral, codigo_ubicacion_gral) VALUES (?, NOW(), ?)";
            $stmt = Conexion::Abrir()->prepare($sql);
            $stmt->bindParam(1, $des_ubicacion, PDO::PARAM_STR);
            $stmt->bindParam(2, $codigo_ubicacion_gral, PDO::PARAM_STR);
            if($stmt->execute()){
                header('Location: ../html/formulario.php');
            }else{
                echo 'error al insertar la nueva ubicacion general';
            }
        }
        public static function Ultimo_dato(){
            try {
                $sql = "SELECT * FROM ubicacion_general ORDER BY id_ubicacion_gral DESC LIMIT 1";
                $stmt = Conexion::Abrir()->prepare($sql);
                $stmt->execute();
                $r = $stmt->fetchObject();
                return $r;
            } catch (PDOException $th) {
                echo $th->getMessage();
            }
        }
        public static function Buscar($id){
            $sql = "SELECT * FROM ubicacion_general WHERE id_ubicacion_gral = ?";
            $stmt = Conexion::Abrir()->prepare($sql);
            $stmt->bindParam(1, $id, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetchObject();
            return $result;
        }
    }