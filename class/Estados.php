<?php
    class Estados extends Conexion{
        public static function Ver(){
            try {
                $sql = "SELECT * FROM estados";
                $stmt = Conexion::Abrir()->prepare($sql);
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_OBJ);
            } catch (PDOException $th) {
                return $th->getMessage();
            }
        }

        public static function InsertarDeExcel($codigo_estado){
            try {
                if(!is_null($codigo_estado)){
                    $sql = "INSERT INTO estados(registro_estado, codigo_estado) VALUES (NOW(),?)";
                    $stmt = Conexion::Abrir()->prepare($sql);
                    $stmt->bindParam(1, $codigo_estado, PDO::PARAM_STR);
                    $stmt->execute();
                }
            } catch (PDOException $th) {
                echo $th->getMessage();
            }
        }
        
        public static function Buscar_desde_Excel($codigo){
            try {
                $sql = "SELECT * FROM estados WHERE codigo_estado = ?";
                $stmt = Conexion::Abrir()->prepare($sql);
                $stmt->bindParam(1, $codigo, PDO::PARAM_STR);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                return (empty($result)) ? true : false;
            } catch (PDOException $th) {
                echo $th->getMessage();
            }
        }
        public static function Buscar_ID($codigo_estado) {
            $sql = "SELECT id_estado FROM estados WHERE codigo_estado LIKE ?";
            $stmt = Conexion::Abrir()->prepare($sql);
            $stmt->bindParam(1, $codigo_estado, PDO::PARAM_STR);
            try {
                if ($stmt->execute()) {
                    $result = $stmt->fetchColumn();
                    if ($result !== false) {
                        return $result;
                    } else {
                        // Si no se encontró el tipo, lo insertamos
                        self::InsertarDeExcel($codigo_estado);
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

        public static function Insertar($des_estado, $codigo_estado){
            $sql = "INSERT INTO estados (des_estado, registro_estado, codigo_estado) VALUES (?, NOW(), ?)";
            $stmt = Conexion::Abrir()->prepare($sql);
            $stmt->bindParam(1, $des_estado, PDO::PARAM_STR);
            $stmt->bindParam(2, $codigo_estado, PDO::PARAM_STR);
            if($stmt->execute()){
                header('Location: ../html/formulario.php');
            }else{
                echo 'error al insertar la nueva ubicacion general';
            }
        }
        public static function Ultimo_dato(){
            try {
                $sql = "SELECT * FROM estados ORDER BY id_estado DESC LIMIT 1";
                $stmt = Conexion::Abrir()->prepare($sql);
                $stmt->execute();
                $r = $stmt->fetchObject();
                return $r;
            } catch (PDOException $th) {
                echo $th->getMessage();
            }
        }
    }