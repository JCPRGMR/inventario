<?php
    class Roles{
        static function Ver(){
            try {
                $sql = "SELECT * FROM roles ORDER BY id_rol DESC";
                $stmt = Conexion::Abrir()->prepare($sql);
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_OBJ);
            } catch (PDOException $th) {
                echo $th->getMessage();
            }
        }
    }