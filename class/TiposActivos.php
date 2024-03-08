<?php
    class TiposActivos extends Conexion{

        public static function Ver(){
            try {
                $sql = "SELECT * FROM tipos ORDER BY des_tipo ASC";
                $stmt = Conexion::Abrir()->prepare($sql);
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_OBJ);
            } catch (PDOException $th) {
                return $th->getMessage();
            }
        }
        public static function Insertar($des_tipo){

            $des_tipo = self::Mayuscula_singular($des_tipo);

            if(!is_null($des_tipo)){
                try {
                    $des_tipo = trim($des_tipo);
                    $sql = "INSERT INTO tipos(des_tipo, registro_tipo) VALUES(?,NOW())";
                    $stmt = Conexion::Abrir()->prepare($sql);
                    $stmt->bindParam(1, $des_tipo, PDO::PARAM_STR);
                    $stmt->execute();
                } catch (PDOException $th) {
                    echo $th->getMessage();
                }
            }
        }

        public static function Buscar_ID($des_tipo) {
            $des_tipo = self::Mayuscula_singular($des_tipo);
        
            $sql = "SELECT id_tipo FROM tipos WHERE des_tipo LIKE ?";
            $stmt = Conexion::Abrir()->prepare($sql);
            $stmt->bindParam(1, $des_tipo, PDO::PARAM_STR);
        
            try {
                if ($stmt->execute()) {
                    $result = $stmt->fetchColumn();
                    if ($result !== false) {
                        return $result;
                    } else {
                        self::Insertar($des_tipo);
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
        

        

        //OTRAS FUNCIONES
        public static function Mayuscula_singular($cadena){
            if(!is_null($cadena)){
                $cadena = trim(strtoupper($cadena));
                $longitud = strlen($cadena);
                
                if ($longitud > 1 && substr($cadena, -1) === 'S') { 
                    // Comprueba si la última letra es 's'
                    $cadena = substr($cadena, 0, $longitud - 1);
                }
            }
            
            return $cadena; 
        }

        public static function InsertarNuevo($des_tipo){
            $des_tipo = self::Mayuscula_singular($des_tipo);

            if(strlen($des_tipo) != 0){
                $des_tipo = self::Mayuscula_singular($des_tipo);
            
                $sql = "SELECT id_tipo FROM tipos WHERE des_tipo LIKE ?";
                $stmt = Conexion::Abrir()->prepare($sql);
                $stmt->bindParam(1, $des_tipo, PDO::PARAM_STR);
            
                try {
                    if ($stmt->execute()) {
                        $result = $stmt->fetchColumn();
                        if ($result !== false) {
                            // header('Location: ../html/formulario.php');
                            echo 'ESE TIPO YA EXISTE';
                        } else {
                            self::Insertar($des_tipo);
                            header('Location: ../html/formulario.php');
                        }
                    } else {
                        echo 'Error al ejecutar la consulta de búsqueda';
                    }
                } catch (PDOException $th) {
                    echo $th->getMessage();
                }
            
                return null;
            }else{
                echo 'Por favor no envie valores vacios';
            }
        }
        public static function Ultimo_dato(){
            try {
                $sql = "SELECT * FROM tipos ORDER BY id_tipo DESC LIMIT 1";
                $stmt = Conexion::Abrir()->prepare($sql);
                $stmt->execute();
                $r = $stmt->fetchObject();
                return $r;
            } catch (PDOException $th) {
                echo $th->getMessage();
            }
        }
    }