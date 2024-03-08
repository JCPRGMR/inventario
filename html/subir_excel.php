<?php //include 'templates/header.php' ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="../request/botones.php" method="post" enctype="multipart/form-data">
        <input type="file" name="archivo_xls" id="" accept=".xlsx, .xls">
        <button type="submit" name="enviar_xls">Enviar a la base de datos</button>
        <button type="submit" name="del_tipos">Eliminar todos los registros de la base de datos</button>
    </form>
</body>
</html>