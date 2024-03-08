<?php
    class Rubros extends Conexion{
        
        public static function Ver(){
            try {
                $sql = "SELECT * FROM rubro ORDER BY codigo_rubro ASC";
                $stmt = Conexion::Abrir()->prepare($sql);
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_OBJ);
            } catch (PDOException $th) {
                return $th->getMessage();
            }
        }
        public static function InsertarDeExcel($codigo_rubro){
            try {
                if(!is_null($codigo_rubro)){
                    $sql = "INSERT INTO rubro(registro_rubro, codigo_rubro) VALUES(NOW(), ?)";
                    $stmt = Conexion::Abrir()->prepare($sql);
                    $stmt->bindParam(1, $codigo_rubro, PDO::PARAM_STR);
                    $stmt->execute();
                }
            } catch (PDOException $th) {
                echo $th->getMessage();
            }
        }
        static public function Existe_desde_Excel($codigo){
            try {
                $sql = "SELECT * FROM rubro WHERE codigo_rubro = ?";
                $stmt = Conexion::Abrir()->prepare($sql);
                $stmt->bindParam(1, $codigo, PDO::PARAM_STR);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                return (empty($result)) ? true : false;
            } catch (PDOException $th) {
                echo $th->getMessage();
            }
        }
        public static function Buscar_ID($codigo_rubro) {
            $sql = "SELECT id_rubro FROM rubro WHERE codigo_rubro LIKE ?";
            $stmt = Conexion::Abrir()->prepare($sql);
            $stmt->bindParam(1, $codigo_rubro, PDO::PARAM_STR);
        
            try {
                if ($stmt->execute()) {
                    $result = $stmt->fetchColumn();
                    if ($result !== false) {
                        return $result;
                    } else {
                        // Si no se encontró el tipo, lo insertamos
                        self::InsertarDeExcel($codigo_rubro);
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

        public static function Insertar($cod_rubro, $des_rubro){
            $sql = "INSERT INTO rubro (des_rubro, registro_rubro, codigo_rubro) VALUES (?, NOW(), ?)";
            $stmt = Conexion::Abrir()->prepare($sql);
            $stmt->bindParam(1, $des_rubro, PDO::PARAM_STR);
            $stmt->bindParam(2, $cod_rubro, PDO::PARAM_STR);
            try {
                if($stmt->execute()){
                    header('Location: ../html/formulario.php');
                }
            } catch (PDOException $th) {
                echo $th->getMessage();
            }
        }
        public static function Ultimo_dato(){
            try {
                $sql = "SELECT * FROM rubro ORDER BY id_rubro DESC LIMIT 1";
                $stmt = Conexion::Abrir()->prepare($sql);
                $stmt->execute();
                $r = $stmt->fetchObject();
                return $r;
            } catch (PDOException $th) {
                echo $th->getMessage();
            }
        }
        public static function Buscar($id){
            $sql = "SELECT * FROM rubro WHERE id_rubro = ? ORDER BY registro_rubro DESC";
            $stmt = Conexion::Abrir()->prepare($sql);
            $stmt->bindParam(1, $id, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetchObject();
            return $result;
        }
    }