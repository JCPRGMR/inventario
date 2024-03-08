<?php
    class Activos_estados extends Conexion{
        public static function Ver(){}
        public static function Insertar($id_activo, $id_estado){
            try {
                $sql = "INSERT INTO activos_estados (id_activo, id_estado, registro_act_est) VALUES (?,?,NOW())";
                $stmt = Conexion::Abrir()->prepare($sql);
                $stmt->bindParam(1, $id_activo, PDO::PARAM_INT);
                $stmt->bindParam(2, $id_estado, PDO::PARAM_INT);
                if($stmt->execute()){
                    // echo 'Estado insertado correctamente';
                }else{
                    echo 'Error al enviar el estado';
                }
            } catch (PDOException $th) {
                echo $th->getMessage();
            }
        }
    }