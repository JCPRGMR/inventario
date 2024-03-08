<?php
    class Paises extends Conexion{

        static public function Ver(){
            try {
                $sql = "SELECT * FROM paises ORDER BY des_pais ASC";
                $stmt = Conexion::Abrir()->prepare($sql);
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_OBJ);
            } catch (PDOException $th) {
                return $th->getMessage();
            }
        }

        public static function Insertar($des_pais){
            $des_pais = TiposActivos::Mayuscula_singular($des_pais);

            if(!is_null($des_pais)){    
                try {
                    $sql = "INSERT INTO paises(des_pais, registro_pais) VALUES(?,NOW())";
                    $stmt = Conexion::Abrir()->prepare($sql);
                    $stmt->bindParam(1, $des_pais, PDO::PARAM_STR);
                    $stmt->execute();
                } catch (PDOException $th) {
                    echo $th->getMessage();
                }
            }
        }
        
        public static function Buscar_ID($des_pais) {
            $des_pais = TiposActivos::Mayuscula_singular($des_pais);
        
            $sql = "SELECT id_pais FROM paises WHERE des_pais LIKE ?";
            $stmt = Conexion::Abrir()->prepare($sql);
            $stmt->bindParam(1, $des_pais, PDO::PARAM_STR);
        
            try {
                if ($stmt->execute()) {
                    $result = $stmt->fetchColumn();
                    if ($result !== false) {
                        return $result;
                    } else {
                        // Si no se encontró el tipo, lo insertamos
                        self::Insertar($des_pais);
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

        public static function InsertarNuevo($des_pais){
            $des_pais = TiposActivos::Mayuscula_singular($des_pais);
            if(strlen($des_pais) != 0){
                $sql = "SELECT id_pais FROM paises WHERE des_pais LIKE ?";
                $stmt = Conexion::Abrir()->prepare($sql);
                $stmt->bindParam(1, $des_pais, PDO::PARAM_STR);
            
                try {
                    if ($stmt->execute()) {
                        $result = $stmt->fetchColumn();
                        if ($result !== false) {
                            echo 'ESA PAIS YA EXISTE';
                        } else {
                            self::Insertar($des_pais);
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
                $sql = "SELECT * FROM paises ORDER BY id_pais DESC LIMIT 1";
                $stmt = Conexion::Abrir()->prepare($sql);
                $stmt->execute();
                $r = $stmt->fetchObject();
                return $r;
            } catch (PDOException $th) {
                echo $th->getMessage();
            }
        }
    }