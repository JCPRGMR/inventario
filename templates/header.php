<?php session_start() ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/index5.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RTP - Inventario v1.1.4</title>
</head>
<body>
    <input type="checkbox" name="" id="nav-bar" style="position: absolute; visibility: hidden;">
    <nav>
        <ul>
            <a href="../html/tabla_activos.php?pagina=1">
                <li>ACTIVOS</li>
            </a>
            <?php if($_SESSION['rol'] !== 3 ):?>
            <a href="../html/formulario.php">
                <li>AGREGAR ACTIVOS</li>
            </a>
            <?php endif;?>
            <a href="../html/documentos.php">
                <li>QR's</li>
            </a>
            <?php if($_SESSION['rol'] === 1 ):?>
                <a href="../html/subir_excel.php">
                    <li>SUBIR EXCEL</li>
                </a>
                <a href="../html/usuarios.php">
                    <li>USUARIOS</li>
                </a>
            <?php endif;?>
            <a href="../html/login.php">
                <li>
                    <?= (!isset($_SESSION['usuario'])) ? header('Location: ../html/login.php') : 'CERRAR SESION'; ?>
                </li>
            </a>
        </ul>
        <label for="nav-bar" class="on-nav">MENU</label>
    </nav>
    <main>