<?php
error_reporting(E_ALL);
ini_set('display_errors', 1)
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "public/templates/header.php" ?>
</head>

<body>
    <main class="">
        <div id="contenedor" class="vh-100 container d-flex justify-content-center align-items-center">
            <div id="login_contenedor" class="">
                <form method="POST" action="../Auth/login">
                    <div class="mb-3">
                        <label for="username" class="form-label">Correo electrónico</label>
                        <input type="text" id="username" name="username" class="form-control" placeholder="Ingresa tu usuario" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña</label>
                        <input type="password" id="password" name="password" class="form-control" placeholder="Ingresa tu contraseña" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Iniciar sesión</button>
                    <span>Crear usuario</span>
                </form>
            </div>
        </div>
    </main>
</body>

</html>