<?php
    class Ubicacion_Especifica extends Conexion{
        static public function Ver(){
            try {
                $sql = "SELECT * FROM ubicacion_especifica ORDER BY codigo_ubicacion_esp ASC";
                $stmt = Conexion::Abrir()->prepare($sql);
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_OBJ);
            } catch (PDOException $th) {
                return $th->getMessage();
            }
        }

        public static function InsertarDeExcel($cod_ue){
            try {
                if(!is_null($cod_ue)){
                    $sql = "INSERT INTO ubicacion_especifica(registro_ubicacion_esp, codigo_ubicacion_esp) VALUES(NOW(), ?)";
                    $stmt = Conexion::Abrir()->prepare($sql);
                    $stmt->bindParam(1, $cod_ue, PDO::PARAM_STR);
                    $stmt->execute();
                }
            } catch (PDOException $th) {
                echo $th->getMessage();
            }
        }
        public static function Existe_desde_excel($codigo){
            try {
                $sql = "SELECT * FROM ubicacion_especifica WHERE codigo_ubicacion_esp = ?";
                $stmt = Conexion::Abrir()->prepare($sql);
                $stmt->bindParam(1, $codigo, PDO::PARAM_STR);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                return (empty($result)) ? true : false;
            } catch (PDOException $th) {
                echo $th->getMessage();
            }
        }
        public static function Buscar_ID($cod_ue) {
            $sql = "SELECT id_ubicacion_esp FROM ubicacion_especifica WHERE codigo_ubicacion_esp LIKE ?";
            $stmt = Conexion::Abrir()->prepare($sql);
            $stmt->bindParam(1, $cod_ue, PDO::PARAM_STR);
        
            try {
                if ($stmt->execute()) {
                    $result = $stmt->fetchColumn();
                    if ($result !== false) {
                        return $result;
                    } else {
                        // Si no se encontró el tipo, lo insertamos
                        self::InsertarDeExcel($cod_ue);
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

        public static function Insertar($des_ubicacion_esp, $cod_ubicacion_esp){
            $sql = "INSERT INTO ubicacion_especifica (des_ubicacion_esp, registro_ubicacion_esp, codigo_ubicacion_esp ) VALUES (?, NOW(), ?)";
            $stmt = Conexion::Abrir()->prepare($sql);
            $stmt->bindParam(1, $des_ubicacion_esp, PDO::PARAM_STR);
            $stmt->bindParam(2, $cod_ubicacion_esp, PDO::PARAM_STR);
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
                $sql = "SELECT * FROM ubicacion_especifica ORDER BY id_ubicacion_esp DESC LIMIT 1";
                $stmt = Conexion::Abrir()->prepare($sql);
                $stmt->execute();
                $r = $stmt->fetchObject();
                return $r;
            } catch (PDOException $th) {
                echo $th->getMessage();
            }
        }
        public static function Buscar($id){
            $sql = "SELECT * FROM ubicacion_especifica WHERE id_ubicacion_esp = ?";
            $stmt = Conexion::Abrir()->prepare($sql);
            $stmt->bindParam(1, $id, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetchObject();
            return $result;
        }
    }