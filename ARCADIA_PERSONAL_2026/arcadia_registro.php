<?php
session_start();
require_once __DIR__ . '/includes/arcadia_funciones.php';
if (usuario_actual()) { header('Location: arcadia_inicio.php'); exit; }
$errores = []; $nombre = ''; $apellido = ''; $email = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    validar_csrf();
    $nombre = limpiar(filter_input(INPUT_POST, 'nombre', FILTER_UNSAFE_RAW) ?? '');
    $apellido = limpiar(filter_input(INPUT_POST, 'apellido', FILTER_UNSAFE_RAW) ?? '');
    $email = strtolower(limpiar(filter_input(INPUT_POST, 'email', FILTER_UNSAFE_RAW) ?? ''));
    $password = (string)($_POST['password'] ?? '');
    $confirmar = (string)($_POST['confirmar'] ?? '');
    if ($nombre === '' || mb_strlen($nombre) > 100) $errores[] = 'Ingresá un nombre válido.';
    if ($apellido === '' || mb_strlen($apellido) > 100) $errores[] = 'Ingresá un apellido válido.';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || mb_strlen($email) > 150) $errores[] = 'Ingresá un correo válido.';
    if (strlen($password) < 8) $errores[] = 'La contraseña debe tener al menos 8 caracteres.';
    if ($password !== $confirmar) $errores[] = 'Las contraseñas no coinciden.';
    if (!$errores) {
        try {
            $pdo = db();
            $q = $pdo->prepare("INSERT INTO usuarios (id_rol,nombre,apellido,email,password) SELECT id_rol,?,?,?,? FROM roles WHERE nombre='Usuario'");
            $q->execute([$nombre,$apellido,$email,password_hash($password, PASSWORD_DEFAULT)]);
            $id = (int)$pdo->lastInsertId();
            session_regenerate_id(true);
            $_SESSION['usuario'] = ['id'=>$id,'nombre'=>$nombre,'email'=>$email,'rol'=>'Usuario'];
            header('Location: arcadia_inicio.php?seccion=inicio'); exit;
        } catch (PDOException $ex) {
            $errores[] = $ex->getCode() === '23000' ? 'Ese correo ya está registrado.' : 'No se pudo crear la cuenta. Revisá que hayas importado la base de datos.';
        }
    }
}
$titulo_pagina='Registrarse | ARCADIA';
require __DIR__.'/includes/arcadia_cabecera.php';
?>
<main class="contenedor"><section class="panel panel-form"><span class="etiqueta">CREÁ TU CUENTA</span><h2>Registrarse en ARCADIA</h2><p>Completá tus datos para participar y acceder a las funciones de usuario.</p>
<?php if($errores): ?><div class="alerta error"><ul><?php foreach($errores as $er): ?><li><?=e($er)?></li><?php endforeach; ?></ul></div><?php endif; ?>
<form class="formulario" method="POST">
<input type="hidden" name="csrf" value="<?=e(csrf_token())?>">
<label for="nombre">Nombre</label><input id="nombre" name="nombre" maxlength="100" required value="<?=e($nombre)?>">
<label for="apellido">Apellido</label><input id="apellido" name="apellido" maxlength="100" required value="<?=e($apellido)?>">
<label for="email">Correo electrónico</label><input id="email" name="email" type="email" maxlength="150" required value="<?=e($email)?>">
<label for="password">Contraseña (mínimo 8 caracteres)</label><input id="password" name="password" type="password" minlength="8" required>
<label for="confirmar">Confirmar contraseña</label><input id="confirmar" name="confirmar" type="password" minlength="8" required>
<button class="boton" type="submit">Crear cuenta</button></form><p>¿Ya tenés cuenta? <a href="arcadia_login.php">Iniciá sesión</a>.</p></section></main>
<?php require __DIR__.'/includes/arcadia_pie.php'; ?>
