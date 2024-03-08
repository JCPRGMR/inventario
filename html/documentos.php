<?php include '../templates/header.php' ?>
<?php require '../request/botones.php';?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/documentos1.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <header>
        <form action="qr.php" method="post" target="_blank  " style="background-color: rgb(43, 43, 43); padding: 5px; color: white;">
            Del id <input type="number" name="from" required id="" placeholder="Desde el id <?= Activos::Idmenor() ?>" value="1" style="width: 50px;">
            al <input type="number" name="to" required id="" placeholder="Hasta el id 100" value="10" style="width: 50px;">
            <button type="submit" name="qr">QR POR LOTES</button>
        </form>
        <!-- <form action="pdfInRealTime.php" method="post" target="ven" style="background-color: red; padding: 5px; color: white;">
            Del id 
            <input type="number" name="from" required id="" placeholder="Desde el id <?php // Activos::Idmenor() ?>" value="1" style="width: 50px;">
            al 
            <input type="number" name="to" required id="" placeholder="Hasta el id 100" value="10" style="width: 50px;">
            <button type="submit" name="pdf">PDF</button>
        </form>
        <form action="" method="post">
            <button type="submit" name="exportar" style="background-color: green; color: white; padding: 7px;">Excel</button>
        </form> -->
        <?php // $msg ?>
    </header>
    <iframe src="" frameborder="0" id="ven" name="ven" class="ven"></iframe>
</body>
</html>
<style>
    button{
        cursor: pointer;
    }
    button:hover{
        transform: scale(0.9);
    }
</style>