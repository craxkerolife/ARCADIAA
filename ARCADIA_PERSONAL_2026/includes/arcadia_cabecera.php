<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="ARCADIA: juegos, emuladores, simuladores, aplicaciones y aprendizaje tecnológico.">
  <title><?= e($titulo_pagina ?? 'ARCADIA') ?></title>
  <link rel="stylesheet" href="assets/css/arcadia_estilo_visual.css">
</head>
<body>
<header class="encabezado">
  <div class="marca">
    <a class="logo" href="arcadia_inicio.php" aria-label="Ir al inicio">A</a>
    <div><h1>ARCADIA</h1><p>Tu espacio de juegos, programas y tecnología</p></div>
    <div class="acciones-cuenta">
      <?php if (usuario_actual()): ?>
        <span>Hola, <?= e(usuario_actual()['nombre']) ?></span>
        <?php if ((usuario_actual()['rol'] ?? '') === 'Administrador'): ?><a href="arcadia_admin.php">Administrar</a><?php endif; ?>
        <a href="arcadia_logout.php">Cerrar sesión</a>
      <?php else: ?>
        <a href="arcadia_login.php">Iniciar sesión</a>
        <a class="registro-mini" href="arcadia_registro.php">Registrarse</a>
      <?php endif; ?>
    </div>
  </div>
</header>
