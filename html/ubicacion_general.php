<?php include '../templates/header.php' ?>
<?php require '../request/botones.php' ?>

<link rel="stylesheet" href="../css/escalables1.css">
<table>
    <thead>
        <tr>
            <th>cod</th>
            <th>Nombre</th>
            <!-- <th>ID</th> -->
            <th>acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach(Ubicacion_General::Ver() as $row): ?>
        <tr>
            <form action="" method="post">
                <td><?= $row->codigo_ubicacion_gral ?></td>
                <td>
                    <input type="text" name="" id="" value="<?= $row->des_ubicacion_gral ?>">
                </td>
                <!-- <td><?php // $row->id_ubicacion_gral ?></td> -->
                <td>
                    <button type="submit" value="<?= $row->id_ubicacion_gral ?>">📝</button>
                </td>
            </form>
        </tr>
        <?php endforeach;?>
    </tbody>
</table>