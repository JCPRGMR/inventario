<?php session_start(); session_destroy()?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/login.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="../request/botones.php" method="post">
        <header>
            <img src="../img/rtp_logo_blanco.png" alt="">
            <div>
                RTP Sistema de inventario
            </div>
            <small>para contadores</small>
        </header>
        <div class="form-input">
            <input type="text" name="usuario" id="" placeholder="Correo o nombre de usuario">
            <input type="password" name="clave" id="" placeholder="Contraseña">
        </div>
        <button type="submit" name="log_in">Ingresar</button>
    </form>
</body>
</html>