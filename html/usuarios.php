<?php include '../templates/header.php' ?>
<?php require '../request/botones.php' ?>
<link rel="stylesheet" href="../css/usuarios1.css">

<form action="" method="post">
    <header>Crear usuario</header>
    <div>
        <input class="campo" required type="text" name="usuario" id="" placeholder="Nombre de usuario">
        <input class="campo" type="email" name="email" id="" placeholder="Correo electronico">
        <input class="campo" type="text" name="nombres" id="" placeholder="Nombres y Apellidos">
        <input class="campo" required type="password" name="password" id="" placeholder="Contraseña / clave">
        <select class="campo" required name="rol" id="">
            <?php foreach(Roles::Ver() as $row):?>
                <option value="<?= $row->id_rol ?>"><?= $row->des_rol ?></option>
            <?php endforeach?>
        </select>

    </div>
    <button type="submit" name="crear_usuario">CREAR</button>
</form>
<table border="1">
    <thead>
        <th>Usuario</th>
        <!-- <th>Nombre</th> -->
        <th>Rol</th>
        <th>Password</th>
    </thead>
    <tbody>
        <?php foreach(Usuarios::Ver() as $row):?>
            <tr>
                <td><?= $row->usuario ?></td>
                <!-- <td><?php // $row->nombre ?></td> -->
                <td><?= $row->des_rol ?></td>
                <td class="simbolos"><?= $row->pass ?></td>
            </tr>
        <?php endforeach?>
    </tbody>
</table>