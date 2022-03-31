<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN</title>
</head>
<body>
    <form action="../controllers/login.php" method="post">
        <label>Documento</label><br>
        <input type="number" name="id_usu"><br><br>
        <label>Contraseña</label><br>
        <input type="password" name="contrasena_usu"><br><br>
        <button type="submit">Inicar sesión</button>
    </form>
</body>
</html>