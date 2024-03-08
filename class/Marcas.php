<?php
    class Marcas extends Conexion{

        public static function Ver(){
            try {
                $consulta = "SELECT * FROM marcas ORDER BY des_marca ASC";
                $stmt = Conexion::Abrir()->prepare($consulta);
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_OBJ);
            } catch (PDOException $th) {
                echo $th->getMessage();
            }
        }

        public static function Insertar($des_marca){
            $des_marca = TiposActivos::Mayuscula_singular($des_marca);

            if(!is_null($des_marca)){
                try {
                    $sql = "INSERT INTO marcas(des_marca, registro_marca) VALUES(?,NOW())";
                    $stmt = Conexion::Abrir()->prepare($sql);
                    $stmt->bindParam(1, $des_marca, PDO::PARAM_STR);
                    $stmt->execute();
                } catch (PDOException $th) {
                    echo $th->getMessage();
                }
            }
        }
        public static function Buscar_ID($des_marca) {
            $des_marca = TiposActivos::Mayuscula_singular($des_marca);
        
            $sql = "SELECT id_marca FROM marcas WHERE des_marca LIKE ?";
            $stmt = Conexion::Abrir()->prepare($sql);
            $stmt->bindParam(1, $des_marca, PDO::PARAM_STR);
        
            try {
                if ($stmt->execute()) {
                    $result = $stmt->fetchColumn();
                    if ($result !== false) {
                        return $result;
                    } else {
                        self::Insertar($des_marca);
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

        public static function InsertarNuevo($des_marca){
            $des_marca = TiposActivos::Mayuscula_singular($des_marca);
            if(strlen($des_marca) != 0){
                $sql = "SELECT id_marca FROM marcas WHERE des_marca LIKE ?";
                $stmt = Conexion::Abrir()->prepare($sql);
                $stmt->bindParam(1, $des_marca, PDO::PARAM_STR);
            
                try {
                    if ($stmt->execute()) {
                        $result = $stmt->fetchColumn();
                        if ($result !== false) {
                            echo 'ESA MARCA YA EXISTE';
                        } else {
                            self::Insertar($des_marca);
                            header('Location: ../html/formulario.php');
                        }
                    } else {
                        echo 'Error al ejecutar la consulta de búsqueda';
                    }
                } catch (PDOException $th) {
                    echo $th->getMessage();
                }
            
                return null;
            }
        }
        public static function Ultimo_dato(){
            try {
                $sql = "SELECT * FROM marcas ORDER BY id_marca DESC LIMIT 1";
                $stmt = Conexion::Abrir()->prepare($sql);
                $stmt->execute();
                $r = $stmt->fetchObject();
                return $r;
            } catch (PDOException $th) {
                echo $th->getMessage();
            }
        }
    }