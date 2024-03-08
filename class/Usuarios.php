<?php
    class Usuarios{
        static function Verificar($valores){
            $post = (object) $valores;
            try {
                $sql = "SELECT * FROM usuarios WHERE usuario = ? AND pass = ?";
                $stmt = Conexion::Abrir()->prepare($sql);
                $stmt->bindParam(1, $post->usuario, PDO::PARAM_STR);
                $stmt->bindParam(2, $post->clave, PDO::PARAM_STR);
                $stmt->execute();
                $resultado = $stmt->fetch(PDO::FETCH_OBJ);
                if ($resultado) {
                    session_start();
                    $_SESSION['usuario'] = $resultado->usuario;
                    $_SESSION['rol'] = $resultado->id_rol;
                    header('Location: ../html/tabla_activos.php');
                } else {
                    echo 'Si tiene problemas para ingresar al sistema, comuníquese con el administrador';
                }
            } catch (PDOException $th) {
                return $th->getMessage();
            }
        }
        static function Insertar(object $in){
            try {
                $sql = "INSERT INTO usuarios(usuario, correo, nombre, pass, id_rol) VALUES(?,?,?,?,?)";
                $stmt = Conexion::Abrir()->prepare($sql);
                $stmt->bindParam(1, $in->usuario, PDO::PARAM_STR);
                $stmt->bindParam(2, $in->email, PDO::PARAM_STR);
                $stmt->bindParam(3, $in->nombres, PDO::PARAM_STR);
                $stmt->bindParam(4, $in->password, PDO::PARAM_STR);
                $stmt->bindParam(5, $in->rol, PDO::PARAM_INT);
                if($stmt->execute()){
                    return 'Usuario ' . $in->usuario . ' creado exitosamente!';
                }else{
                    return 'No se pudo crear el usuario correctamete';
                }
            } catch (\Throwable $th) {
                //throw $th;
            }
        }
        static function Ver(){
            try {
                $sql = "SELECT * FROM usuarios inner join roles on roles.id_rol = usuarios.id_rol";
                $stmt = Conexion::Abrir()->prepare($sql);
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_OBJ);
            } catch (PDOException $th) {
                echo $th->getMessage();
            }
        }
    }