<?php
session_start();
require_once __DIR__ . '/config/env.php';
require_once __DIR__ . '/includes/functions.php';

$secciones = [
  'inicio' => '⌂ INICIO', 'juegos' => '🎮 JUEGOS', 'emuladores' => '🕹️ EMULADORES',
  'simuladores' => '🧮 SIMULADORES', 'aplicaciones' => '💻 APLICACIONES',
  'curso' => '📚 CURSO HTML', 'blog' => '📰 BLOG', 'busqueda' => '🔎 BÚSQUEDA',
  'sugerencias' => '💡 SUGERENCIAS', 'comunidad' => '👥 COMUNIDAD', 'contacto' => '✉ CONTACTO'
];
$seccion = limpiar($_GET['seccion'] ?? 'inicio');
if (!array_key_exists($seccion, $secciones)) $seccion = 'inicio';
$titulos = ['inicio'=>'Inicio','juegos'=>'Juegos','emuladores'=>'Emuladores','simuladores'=>'Simuladores','aplicaciones'=>'Aplicaciones','curso'=>'Curso HTML','blog'=>'Blog','busqueda'=>'Búsqueda','sugerencias'=>'Sugerencias','comunidad'=>'Comunidad','contacto'=>'Contacto'];
$titulo_pagina = $titulos[$seccion] . ' | ' . $nombre_sitio;

$errores = []; $mensaje = '';
$valores = ['nombre'=>'','email'=>'','asunto'=>'','opinion'=>''];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  foreach ($valores as $campo => $_) $valores[$campo] = limpiar($_POST[$campo] ?? '');
  if ($valores['nombre'] === '') $errores[] = 'El nombre es obligatorio.';
  if (!filter_var($valores['email'], FILTER_VALIDATE_EMAIL)) $errores[] = 'Ingresá un correo electrónico válido.';
  if ($valores['asunto'] === '') $errores[] = 'El asunto es obligatorio.';
  if ($valores['opinion'] === '') $errores[] = 'El mensaje no puede estar vacío.';
  if (mb_strlen($valores['nombre']) > 60 || mb_strlen($valores['asunto']) > 100 || mb_strlen($valores['opinion']) > 1000) $errores[] = 'Uno de los campos supera la cantidad máxima de caracteres.';
  if (!$errores) {
    $mensaje = '¡Gracias, ' . e($valores['nombre']) . '! Tu mensaje fue recibido correctamente.';
    $valores = ['nombre'=>'','email'=>'','asunto'=>'','opinion'=>''];
  } else { $seccion = 'contacto'; $titulo_pagina = 'Contacto | ' . $nombre_sitio; }
}

$catalogo = [
 'Super Mario'=>'Juego de plataformas y aventuras.', 'Tetris'=>'Juego clásico de lógica y bloques.',
 'Minecraft Classic'=>'Construcción y exploración en un mundo de bloques.',
 'PPSSPP'=>'Emulador para jugar títulos de PSP.', 'RetroArch'=>'Plataforma que reúne distintos sistemas de emulación.',
 'Desmos'=>'Calculadora gráfica y científica online.', 'Piano Virtual'=>'Piano para practicar música desde el navegador.',
 'Visual Studio Code'=>'Editor de código para desarrollar proyectos.', 'Google Chrome'=>'Navegador web.'
];
$busqueda = limpiar($_GET['q'] ?? ''); $resultados = [];
if ($seccion === 'busqueda' && $busqueda !== '') foreach ($catalogo as $nombre=>$descripcion) if (stripos($nombre.' '.$descripcion, $busqueda) !== false) $resultados[$nombre] = $descripcion;

require __DIR__ . '/includes/header.php';
require __DIR__ . '/includes/nav.php';
?>
<main class="contenedor">
<?php if ($seccion === 'inicio'): ?>
  <section class="hero">
    <div class="hero-texto"><span class="etiqueta">JUEGOS · TECNOLOGÍA · APRENDIZAJE</span><h2>Explorá un mundo de<br><span>posibilidades digitales.</span></h2><p>Descubrí videojuegos, emuladores, herramientas y recursos para aprender sobre tecnología y desarrollo web.</p><a class="boton" href="index.php?seccion=juegos">EXPLORAR ARCADIA <span>→</span></a></div>
    <div class="hero-arte" aria-hidden="true"><div class="circulo">✦</div><div class="consola">🎮</div><div class="orb orb-uno"></div><div class="orb orb-dos"></div></div>
  </section>
  <section class="bloque"><div class="titulo-seccion"><div><span class="etiqueta">DESCUBRÍ</span><h2>¿Qué podés encontrar?</h2></div><p>Un espacio para jugar, aprender y explorar.</p></div>
    <div class="tarjetas tres"><article class="tarjeta"><div class="icono">🎮</div><h3>Videojuegos</h3><p>Clásicos y títulos para disfrutar desde tu navegador.</p><a href="index.php?seccion=juegos" class="texto-link">Ver juegos →</a></article><article class="tarjeta"><div class="icono">💻</div><h3>Aplicaciones</h3><p>Programas y herramientas útiles para estudiar y crear.</p><a href="index.php?seccion=aplicaciones" class="texto-link">Ver aplicaciones →</a></article><article class="tarjeta"><div class="icono">📚</div><h3>Aprendizaje</h3><p>Conceptos básicos para empezar a desarrollar páginas web.</p><a href="index.php?seccion=curso" class="texto-link">Aprender HTML →</a></article></div>
  </section>
<?php elseif ($seccion === 'juegos'): ?>
  <section class="encabezado-pagina"><span class="etiqueta">DIVERSIÓN SIN LÍMITES</span><h2>🎮 Juegos</h2><p>Elegí un clásico y empezá a jugar.</p></section>
  <section class="tarjetas tres">
    <article class="tarjeta"><div class="portada mario">🍄</div><h3>Super Mario</h3><p>Un clásico de plataformas lleno de aventuras.</p><a class="boton" href="https://supermario-game.com/es" target="_blank" rel="noopener">Jugar ahora ↗</a><p class="video-link"><a href="https://www.youtube.com/results?search_query=Super+Mario+Bros+gameplay" target="_blank" rel="noopener">Ver videos relacionados</a></p></article>
    <article class="tarjeta"><div class="portada tetris">🧩</div><h3>Tetris</h3><p>Ordená las piezas y completá líneas en este desafío de lógica.</p><a class="boton" href="https://tetris.com/play-tetris" target="_blank" rel="noopener">Jugar ahora ↗</a></article>
    <article class="tarjeta"><div class="portada minecraft">🌳</div><h3>Minecraft Classic</h3><p>Construí y explorá un mundo formado por bloques.</p><a class="boton" href="https://classic.minecraft.net/" target="_blank" rel="noopener">Jugar ahora ↗</a></article>
  </section>
<?php elseif ($seccion === 'emuladores'): ?>
  <section class="encabezado-pagina"><span class="etiqueta">VOLVÉ A LOS CLÁSICOS</span><h2>🕹️ Emuladores</h2><p>Programas que permiten disfrutar juegos de distintas plataformas.</p></section>
  <section class="tarjetas dos"><article class="tarjeta"><div class="icono">🎮</div><h3>PPSSPP</h3><p>Emulador que permite ejecutar juegos de la consola portátil PSP en diferentes dispositivos.</p><a class="boton" href="https://www.ppsspp.org/download/" target="_blank" rel="noopener">Descargar PPSSPP ↗</a></article><article class="tarjeta"><div class="icono">🕹️</div><h3>RetroArch</h3><p>Plataforma que reúne diferentes núcleos para emular consolas y sistemas retro.</p><a class="boton" href="https://www.retroarch.com/" target="_blank" rel="noopener">Página oficial ↗</a></article></section>
<?php elseif ($seccion === 'simuladores'): ?>
  <section class="encabezado-pagina"><span class="etiqueta">PROBÁ Y EXPERIMENTÁ</span><h2>🧮 Simuladores</h2><p>Herramientas interactivas para practicar y aprender.</p></section>
  <section class="tarjetas dos"><article class="tarjeta"><div class="icono">➗</div><h3>Calculadora online</h3><p>Realizá operaciones y explorá funciones matemáticas.</p><a class="boton" href="https://www.desmos.com/scientific" target="_blank" rel="noopener">Abrir calculadora ↗</a></article><article class="tarjeta"><div class="icono">🎹</div><h3>Piano virtual</h3><p>Experimentá con notas y melodías desde el navegador.</p><a class="boton" href="https://www.onlinepianist.com/virtual-piano" target="_blank" rel="noopener">Abrir piano ↗</a></article></section>
<?php elseif ($seccion === 'aplicaciones'): ?>
  <section class="encabezado-pagina"><span class="etiqueta">HERRAMIENTAS DIGITALES</span><h2>💻 Aplicaciones</h2><p>Programas que pueden ayudarte a estudiar, comunicarte y crear.</p></section>
  <section class="tarjetas tres"><article class="tarjeta"><div class="icono">⌨️</div><h3>Visual Studio Code</h3><p>Editor de código utilizado para crear páginas y aplicaciones.</p><a class="boton" href="https://code.visualstudio.com/" target="_blank" rel="noopener">Página oficial ↗</a></article><article class="tarjeta"><div class="icono">🌐</div><h3>Google Chrome</h3><p>Navegador web para acceder a sitios y servicios de internet.</p><a class="boton" href="https://www.google.com/chrome/" target="_blank" rel="noopener">Página oficial ↗</a></article><article class="tarjeta"><div class="icono">💬</div><h3>Discord</h3><p>Plataforma para comunicarse mediante mensajes y comunidades.</p><a class="boton" href="https://discord.com/" target="_blank" rel="noopener">Página oficial ↗</a></article></section>
<?php elseif ($seccion === 'curso'): ?>
  <section class="encabezado-pagina"><span class="etiqueta">EMPEZÁ A CREAR</span><h2>📚 Curso básico de HTML</h2><p>Conocé los primeros pasos para construir una página web.</p></section>
  <section class="panel"><h3>¿Qué es HTML?</h3><p>HTML es un lenguaje de marcado que se utiliza para organizar el contenido de una página web mediante etiquetas.</p><div class="leccion"><h3>1. Estructura básica</h3><p>Todo documento HTML comienza indicando su tipo y contiene las etiquetas principales <code>html</code>, <code>head</code> y <code>body</code>.</p><pre><code>&lt;!DOCTYPE html&gt;
&lt;html lang="es"&gt;
&lt;head&gt;
  &lt;title&gt;Mi página&lt;/title&gt;
&lt;/head&gt;
&lt;body&gt;
  &lt;h1&gt;Hola, mundo&lt;/h1&gt;
  &lt;p&gt;Mi primera página web.&lt;/p&gt;
&lt;/body&gt;
&lt;/html&gt;</code></pre></div><div class="leccion"><h3>2. Encabezados y párrafos</h3><p>Los encabezados van desde <code>h1</code> hasta <code>h6</code>. Para escribir párrafos se utiliza <code>p</code>.</p></div><div class="leccion"><h3>3. Enlaces e imágenes</h3><p>La etiqueta <code>a</code> crea enlaces y la etiqueta <code>img</code> permite insertar imágenes.</p></div></section>
<?php elseif ($seccion === 'blog'): ?>
  <section class="encabezado-pagina"><span class="etiqueta">IDEAS Y CONOCIMIENTO</span><h2>📰 Blog ARCADIA</h2><p>Pequeñas lecturas para conocer más sobre el mundo digital.</p></section>
  <section class="tarjetas dos"><article class="tarjeta"><span class="etiqueta">DESARROLLO WEB</span><h3>¿Qué es HTML?</h3><p>Es el lenguaje de marcado que permite estructurar textos, imágenes, enlaces y otros contenidos de una página web.</p></article><article class="tarjeta"><span class="etiqueta">INTERNET</span><h3>¿Qué es un navegador?</h3><p>Es un programa que permite visitar sitios web e interactuar con diferentes contenidos y servicios de internet.</p></article><article class="tarjeta"><span class="etiqueta">VIDEOJUEGOS</span><h3>¿Qué es un emulador?</h3><p>Es un programa que reproduce, mediante software, el funcionamiento de otro sistema o plataforma.</p></article></section>
<?php elseif ($seccion === 'busqueda'): ?>
  <section class="panel panel-form"><span class="etiqueta">ENCONTRÁ LO QUE BUSCÁS</span><h2>🔎 Buscador ARCADIA</h2><p>Escribí una palabra para buscar juegos, emuladores y aplicaciones.</p><form method="GET" action="index.php" class="formulario"><input type="hidden" name="seccion" value="busqueda"><label for="q">Palabra clave</label><div class="buscador-linea"><input id="q" name="q" type="search" value="<?= e($busqueda) ?>" placeholder="Ej: Minecraft, Tetris, emulador..." maxlength="60"><button class="boton" type="submit">Buscar</button></div></form>
  <?php if ($busqueda !== ''): ?><div class="resultado"><h3>Resultados para “<?= e($busqueda) ?>”</h3><?php if ($resultados): ?><div class="resultados-lista"><?php foreach ($resultados as $nombre=>$descripcion): ?><div><strong><?= e($nombre) ?></strong><p><?= e($descripcion) ?></p></div><?php endforeach; ?></div><?php else: ?><p>No se encontraron resultados. Probá con otra palabra.</p><?php endif; ?></div><?php endif; ?></section>
<?php elseif ($seccion === 'sugerencias' || $seccion === 'contacto'): ?>
  <section class="panel panel-form"><span class="etiqueta">TU OPINIÓN NOS AYUDA</span><h2><?= $seccion === 'sugerencias' ? '💡 Formulario de sugerencias' : '✉ Contacto' ?></h2><p>Completá los datos para enviarnos una consulta, idea o comentario.</p>
  <?php if ($mensaje): ?><div class="alerta exito" role="status"><?= $mensaje ?></div><?php endif; ?>
  <?php if ($errores): ?><div class="alerta error" role="alert"><strong>Revisá estos datos:</strong><ul><?php foreach ($errores as $error): ?><li><?= e($error) ?></li><?php endforeach; ?></ul></div><?php endif; ?>
  <form method="POST" action="index.php?seccion=<?= e($seccion) ?>" class="formulario"><label for="nombre">Nombre</label><input id="nombre" name="nombre" type="text" value="<?= e($valores['nombre']) ?>" maxlength="60" required><label for="email">Correo electrónico</label><input id="email" name="email" type="email" value="<?= e($valores['email']) ?>" maxlength="120" required><label for="asunto">Asunto</label><input id="asunto" name="asunto" type="text" value="<?= e($valores['asunto']) ?>" maxlength="100" required><label for="opinion">Tu mensaje o sugerencia</label><textarea id="opinion" name="opinion" rows="5" maxlength="1000" required><?= e($valores['opinion']) ?></textarea><button class="boton" type="submit">Enviar mensaje ↗</button></form><p class="nota-form">* Formulario de práctica: valida y muestra la recepción del mensaje, pero no envía un correo real ni guarda datos en una base de datos.</p></section>
<?php elseif ($seccion === 'comunidad'): ?>
  <section class="panel panel-form"><span class="etiqueta">PARTICIPÁ</span><h2>👥 Debate de la comunidad</h2><p><strong>¿Qué contenido te gustaría ver más en ARCADIA?</strong></p><form class="formulario" id="form-comunidad"><label class="opcion"><input type="radio" name="contenido" value="Más juegos retro" required> Más juegos retro</label><label class="opcion"><input type="radio" name="contenido" value="Más emuladores"> Más emuladores</label><label class="opcion"><input type="radio" name="contenido" value="Más programas"> Más programas</label><label class="opcion"><input type="radio" name="contenido" value="Más sistemas operativos"> Más sistemas operativos</label><label for="motivo">¿Por qué elegiste esa opción?</label><textarea id="motivo" rows="4" placeholder="Contanos tu opinión..."></textarea><button class="boton" type="submit">Participar ↗</button><p id="respuesta-comunidad" class="respuesta" aria-live="polite"></p></form></section>
<?php endif; ?>
</main>
<?php require __DIR__ . '/includes/footer.php'; ?>
