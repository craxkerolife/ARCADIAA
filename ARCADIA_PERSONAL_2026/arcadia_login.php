<?php
session_start();
require_once __DIR__ . '/includes/arcadia_funciones.php';
if (usuario_actual()) { header('Location: arcadia_inicio.php'); exit; }
$error = ''; $email = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    validar_csrf();
    $email = strtolower(limpiar(filter_input(INPUT_POST,'email',FILTER_UNSAFE_RAW) ?? ''));
    $password = (string)($_POST['password'] ?? '');
    if (!filter_var($email,FILTER_VALIDATE_EMAIL) || $password === '') $error='Completá un correo válido y tu contraseña.';
    else {
        try {
            $q=db()->prepare("SELECT u.id_usuario,u.nombre,u.email,u.password,r.nombre AS rol FROM usuarios u INNER JOIN roles r ON r.id_rol=u.id_rol WHERE u.email=? LIMIT 1");
            $q->execute([$email]); $u=$q->fetch();
            if ($u && password_verify($password,$u['password'])) {
                session_regenerate_id(true);
                $_SESSION['usuario']=['id'=>(int)$u['id_usuario'],'nombre'=>$u['nombre'],'email'=>$u['email'],'rol'=>$u['rol']];
                header('Location: arcadia_inicio.php'); exit;
            }
            $error='El correo o la contraseña son incorrectos.';
        } catch (Throwable $ex) { $error='No se pudo conectar con la base de datos. Importá primero tp6/schema.sql.'; }
    }
}
$titulo_pagina='Iniciar sesión | ARCADIA';
require __DIR__.'/includes/arcadia_cabecera.php';
?>
<main class="contenedor"><section class="panel panel-form"><span class="etiqueta">QUÉ BUENO VERTE</span><h2>Iniciar sesión</h2><p>Ingresá con tu cuenta para participar en ARCADIA.</p>
<?php if($error): ?><div class="alerta error"><?=e($error)?></div><?php endif; ?>
<form class="formulario" method="POST"><input type="hidden" name="csrf" value="<?=e(csrf_token())?>">
<label for="email">Correo electrónico</label><input id="email" name="email" type="email" required value="<?=e($email)?>">
<label for="password">Contraseña</label><input id="password" name="password" type="password" required>
<button class="boton" type="submit">Ingresar</button></form><p>¿Todavía no tenés cuenta? <a href="arcadia_registro.php">Registrate</a>.</p></section></main>
<?php require __DIR__.'/includes/arcadia_pie.php'; ?>
