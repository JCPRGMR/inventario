<?php
    class Conexion{
        private static $host = 'localhost';
        private static $dbname = 'inventory';
        private static $user = 'root';
        private static $password = '';
        private static $con;
        
        public static function Abrir() {
            if (!isset(self::$con)) {
                try {
                    $connection = "mysql:host=" . self::$host . ";dbname=" . self::$dbname;
                    self::$con = new PDO($connection, self::$user, self::$password);
                    self::$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    // echo 'se realizo la conexion';
                } catch (PDOException $th) {
                    echo $th->getMessage();
                    die();
                }
            }
    
            return self::$con;
        }


        
        public static function Eliminar_Tablas(){
            try {
                $tablas = [
                    'codigo_nuevo',
                    'codigo_antiguo',
                    'activos_estados',
                    'ubicacion_especifica',
                    'ubicacion_general',
                    'facturas',
                    'activos',
                    'tipos',
                    'marcas',
                    'paises',
                    'estados',
                    'rubro',
                ];
            
                foreach ($tablas as $tabla) {
                    $sql = "DELETE FROM $tabla; ALTER TABLE $tabla AUTO_INCREMENT = 1";
                    $stmt = self::Abrir()->prepare($sql);
                    $stmt->execute();
                }
                header('Location: ../html/tabla_activos.php');
            } catch (PDOException $th) {
                echo 'error: ' . $th->getMessage();
            }
        }
    }
    