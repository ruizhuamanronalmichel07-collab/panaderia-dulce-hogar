<?php
require_once __DIR__ . '/config/conexion.php';
require_once __DIR__ . '/includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username !== '' && $password !== '') {
        $stmt = $pdo->prepare('SELECT * FROM usuarios WHERE username = :username AND estado = :estado LIMIT 1');
        $stmt->execute(['username' => $username, 'estado' => 'Activo']);
        $usuario = $stmt->fetch();

        if ($usuario && password_verify($password, $usuario['password_hash'])) {
            $_SESSION['usuario'] = [
                'id' => $usuario['id'],
                'nombre' => $usuario['nombre'],
                'username' => $usuario['username'],
                'rol' => $usuario['rol'],
            ];
            header('Location: dashboard.php');
            exit;
        }
    }

    $_SESSION['error_login'] = 'Credenciales incorrectas o usuario inactivo.';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Panadería Dulce Hogar</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body class="login-page">
    <div class="login-shell">
        <div class="login-brand">
            <div class="brand-mark">DH</div>
            <h1>Panadería Dulce Hogar</h1>
            <p>Control de ventas, inventario y pedidos.</p>
        </div>

        <div class="login-box">
            <div class="login-header">
                <h2>Iniciar sesión</h2>
                <span>Sistema administrativo</span>
            </div>

            <?php if (!empty($_SESSION['error_login'])): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($_SESSION['error_login']) ?></div>
                <?php unset($_SESSION['error_login']); ?>
            <?php endif; ?>

            <form method="POST" class="form-grid">
                <div class="field">
                    <label for="username">Usuario</label>
                    <input type="text" id="username" name="username" placeholder="Ingrese su usuario" required>
                </div>

                <div class="field">
                    <label for="password">Contraseña</label>
                    <input type="password" id="password" name="password" placeholder="Ingrese su contraseña" required>
                </div>

                <button type="submit" class="btn btn-primary full-width">Ingresar</button>
            </form>

            <div class="login-foot">
                <a href="index.php">Volver al sitio</a>
            </div>
        </div>
    </div>
</body>
</html>
