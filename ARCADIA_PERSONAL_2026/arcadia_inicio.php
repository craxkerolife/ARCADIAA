<?php
session_start();
require_once __DIR__.'/includes/arcadia_funciones.php';
$secciones=['inicio'=>'⌂ INICIO','juegos'=>'🎮 JUEGOS','emuladores'=>'🕹️ EMULADORES','simuladores'=>'🧮 SIMULADORES','aplicaciones'=>'💻 APLICACIONES','curso'=>'📚 CURSO HTML','blog'=>'📰 BLOG','busqueda'=>'🔎 BÚSQUEDA','sugerencias'=>'💡 SUGERENCIAS','comunidad'=>'👥 COMUNIDAD','contacto'=>'✉ CONTACTO'];
$seccion=limpiar($_GET['seccion'] ?? 'inicio'); if(!isset($secciones[$seccion])) $seccion='inicio';
$titulos=array_map(fn($x)=>trim(preg_replace('/^[^ ]+ /u','',$x)),$secciones);
$titulo_pagina=($titulos[$seccion] ?? 'Inicio').' | ARCADIA';
$errores=[]; $mensaje='';
$valores=['nombre'=>'','email'=>'','asunto'=>'','opinion'=>''];
if($_SERVER['REQUEST_METHOD']==='POST' && in_array($seccion,['sugerencias','contacto'],true)){
  validar_csrf();
  foreach($valores as $k=>$_) $valores[$k]=limpiar(filter_input(INPUT_POST,$k,FILTER_UNSAFE_RAW) ?? '');
  if($valores['nombre']==='' || mb_strlen($valores['nombre'])>60) $errores[]='Ingresá un nombre válido.';
  if(!filter_var($valores['email'],FILTER_VALIDATE_EMAIL)) $errores[]='Ingresá un correo electrónico válido.';
  if($valores['asunto']==='' || mb_strlen($valores['asunto'])>100) $errores[]='El asunto es obligatorio (máximo 100 caracteres).';
  if($valores['opinion']==='' || mb_strlen($valores['opinion'])>1000) $errores[]='El mensaje es obligatorio (máximo 1000 caracteres).';
  if(!$errores){
    try {
      $q=db()->prepare("INSERT INTO sugerencias (id_usuario,nombre,email,asunto,mensaje) VALUES (?,?,?,?,?)");
      $q->execute([usuario_actual()['id'] ?? null,$valores['nombre'],$valores['email'],$valores['asunto'],$valores['opinion']]);
      $mensaje='¡Gracias! Tu mensaje quedó guardado correctamente.';
      $valores=['nombre'=>'','email'=>'','asunto'=>'','opinion'=>''];
    } catch(Throwable $ex) { $errores[]='No se pudo guardar el mensaje. Verificá la base de datos.'; }
  }
}
$busqueda=limpiar(filter_input(INPUT_GET,'q',FILTER_UNSAFE_RAW) ?? '');
$catalogo=[
 ['Super Mario','Juego','Un clásico de plataformas y aventuras.','https://supermario-game.com/es','🍄'],
 ['Tetris','Juego','Desafío de lógica y bloques.','https://tetris.com/play-tetris','🧩'],
 ['Minecraft Classic','Juego','Construcción y exploración con bloques.','https://classic.minecraft.net/','🌳'],
 ['PPSSPP','Emulador','Emulador para juegos de PSP.','https://www.ppsspp.org/download/','🎮'],
 ['RetroArch','Emulador','Plataforma para distintos sistemas retro.','https://www.retroarch.com/','🕹️'],
 ['Desmos','Simulador','Calculadora gráfica y científica online.','https://www.desmos.com/scientific','➗'],
 ['Piano Virtual','Simulador','Experimentá con música desde el navegador.','https://www.onlinepianist.com/virtual-piano','🎹'],
 ['Visual Studio Code','Aplicacion','Editor de código para desarrollar proyectos.','https://code.visualstudio.com/','⌨️'],
 ['Google Chrome','Aplicacion','Navegador web para acceder a internet.','https://www.google.com/chrome/','🌐'],
 ['Discord','Aplicacion','Plataforma para comunicarse y crear comunidades.','https://discord.com/','💬']
];
if($seccion==='busqueda' && $busqueda!=='') $resultados=array_filter($catalogo,fn($r)=>stripos(implode(' ',$r),$busqueda)!==false);
require __DIR__.'/includes/arcadia_cabecera.php';
require __DIR__.'/includes/arcadia_menu.php';
?>
<main class="contenedor">
<?php if($seccion==='inicio'): ?>
<section class="hero"><div class="hero-texto"><span class="etiqueta">JUEGOS · TECNOLOGÍA · APRENDIZAJE</span><h2>Explorá un mundo de<br><span>posibilidades digitales.</span></h2><p>Descubrí videojuegos, emuladores, herramientas y recursos para aprender sobre tecnología y desarrollo web.</p><a class="boton" href="arcadia_inicio.php?seccion=juegos">EXPLORAR ARCADIA <span>→</span></a></div><div class="hero-arte"><div class="circulo">✦</div><div class="consola">🎮</div><div class="orb orb-uno"></div><div class="orb orb-dos"></div></div></section>
<section class="bloque"><div class="titulo-seccion"><div><span class="etiqueta">DESCUBRÍ</span><h2>¿Qué podés encontrar?</h2></div><p>Un espacio para jugar, aprender y explorar.</p></div><div class="tarjetas tres">
<article class="tarjeta"><div class="icono">🎮</div><h3>Videojuegos</h3><p>Clásicos y títulos para disfrutar desde tu navegador.</p><a class="texto-link" href="?seccion=juegos">Ver juegos →</a></article>
<article class="tarjeta"><div class="icono">💻</div><h3>Aplicaciones</h3><p>Programas y herramientas útiles para estudiar y crear.</p><a class="texto-link" href="?seccion=aplicaciones">Ver aplicaciones →</a></article>
<article class="tarjeta"><div class="icono">📚</div><h3>Aprendizaje</h3><p>Conceptos básicos para empezar a desarrollar páginas web.</p><a class="texto-link" href="?seccion=curso">Aprender HTML →</a></article></div></section>
<?php elseif(in_array($seccion,['juegos','emuladores','simuladores','aplicaciones'],true)): 
$tipo=['juegos'=>'Juego','emuladores'=>'Emulador','simuladores'=>'Simulador','aplicaciones'=>'Aplicacion'][$seccion];
$titulo=['juegos'=>'🎮 Juegos','emuladores'=>'🕹️ Emuladores','simuladores'=>'🧮 Simuladores','aplicaciones'=>'💻 Aplicaciones'][$seccion];
$items=array_values(array_filter($catalogo,fn($r)=>$r[1]===$tipo));
try {$dbItems=db()->prepare("SELECT titulo,tipo,descripcion,url FROM recursos WHERE estado='Activo' AND tipo=? ORDER BY created_at DESC");$dbItems->execute([$tipo]);foreach($dbItems as $r)$items[]=[$r['titulo'],$r['tipo'],$r['descripcion'],$r['url'],'✨'];}catch(Throwable $ex){}
?><section class="encabezado-pagina"><span class="etiqueta">EXPLORÁ EL CATÁLOGO</span><h2><?=e($titulo)?></h2><p>Elegí un recurso y conocé más.</p></section><section class="tarjetas tres">
<?php foreach($items as $r): ?><article class="tarjeta"><div class="portada"><?=e($r[4] ?? '✨')?></div><h3><?=e($r[0])?></h3><p><?=e($r[2])?></p><a class="boton" href="<?=e($r[3])?>" target="_blank" rel="noopener noreferrer">Abrir recurso ↗</a></article><?php endforeach; ?></section>
<?php elseif($seccion==='busqueda'): ?>
<section class="panel"><span class="etiqueta">ENCONTRÁ LO QUE BUSCÁS</span><h2>🔎 Búsqueda rápida (GET)</h2><form method="GET" class="formulario buscador-linea"><input type="hidden" name="seccion" value="busqueda"><input name="q" value="<?=e($busqueda)?>" placeholder="Ejemplo: Mario, emulador..." aria-label="Buscar" required><button class="boton">Buscar</button></form>
<?php if($busqueda!==''): ?><div class="resultado"><h3>Resultados para “<?=e($busqueda)?>”</h3><?php if($resultados): ?><div class="resultados-lista"><?php foreach($resultados as $r): ?><div><strong><?=e($r[0])?></strong><p><?=e($r[2])?></p></div><?php endforeach; ?></div><?php else: ?><p>No se encontraron resultados. Probá con otra palabra.</p><?php endif; ?></div><?php endif; ?></section>
<?php elseif($seccion==='curso'): ?>
<section class="encabezado-pagina"><span class="etiqueta">EMPEZÁ A CREAR</span><h2>📚 Curso básico de HTML</h2><p>Conocé los primeros pasos para construir una página web.</p></section><section class="panel"><h3>¿Qué es HTML?</h3><p>HTML es un lenguaje de marcado que organiza el contenido de una página web mediante etiquetas.</p><div class="leccion"><h3>1. Estructura básica</h3><pre><code>&lt;!DOCTYPE html&gt;
&lt;html lang="es"&gt;
&lt;head&gt;&lt;title&gt;Mi página&lt;/title&gt;&lt;/head&gt;
&lt;body&gt;&lt;h1&gt;Hola, mundo&lt;/h1&gt;&lt;/body&gt;
&lt;/html&gt;</code></pre></div><div class="leccion"><h3>2. Encabezados y párrafos</h3><p>Los encabezados van desde h1 hasta h6. Para escribir párrafos se utiliza p.</p></div><div class="leccion"><h3>3. Enlaces e imágenes</h3><p>La etiqueta a crea enlaces y la etiqueta img permite insertar imágenes.</p></div></section>
<?php elseif($seccion==='blog'): ?>
<section class="encabezado-pagina"><span class="etiqueta">IDEAS Y CONOCIMIENTO</span><h2>📰 Blog ARCADIA</h2><p>Pequeñas lecturas para conocer más sobre el mundo digital.</p></section><section class="tarjetas dos"><article class="tarjeta"><span class="etiqueta">DESARROLLO WEB</span><h3>¿Qué es HTML?</h3><p>Es el lenguaje de marcado que permite estructurar textos, imágenes y enlaces de una página web.</p></article><article class="tarjeta"><span class="etiqueta">TECNOLOGÍA</span><h3>¿Qué es un emulador?</h3><p>Es un programa que reproduce el funcionamiento de otro sistema o dispositivo.</p></article></section>
<?php elseif($seccion==='sugerencias' || $seccion==='contacto'): ?>
<section class="panel panel-form"><span class="etiqueta">TU OPINIÓN NOS AYUDA</span><h2><?=$seccion==='sugerencias'?'💡 Formulario de sugerencias':'✉ Contacto'?></h2><p>Completá los datos para enviarnos una consulta, idea o comentario. Si iniciaste sesión, el mensaje queda asociado a tu cuenta.</p>
<?php if($mensaje): ?><div class="alerta exito" role="status"><?=e($mensaje)?></div><?php endif; ?><?php if($errores): ?><div class="alerta error" role="alert"><strong>Revisá estos datos:</strong><ul><?php foreach($errores as $er): ?><li><?=e($er)?></li><?php endforeach; ?></ul></div><?php endif; ?>
<form method="POST" class="formulario"><input type="hidden" name="csrf" value="<?=e(csrf_token())?>"><label for="nombre">Nombre</label><input id="nombre" name="nombre" maxlength="60" value="<?=e($valores['nombre'] ?: (usuario_actual()['nombre'] ?? ''))?>" required><label for="email">Correo electrónico</label><input id="email" name="email" type="email" maxlength="150" value="<?=e($valores['email'] ?: (usuario_actual()['email'] ?? ''))?>" required><label for="asunto">Asunto</label><input id="asunto" name="asunto" maxlength="100" value="<?=e($valores['asunto'])?>" required><label for="opinion">Tu mensaje o sugerencia</label><textarea id="opinion" name="opinion" rows="5" maxlength="1000" required><?=e($valores['opinion'])?></textarea><button class="boton">Enviar mensaje ↗</button></form></section>
<?php elseif($seccion==='comunidad'): ?>
<section class="panel panel-form"><span class="etiqueta">PARTICIPÁ</span><h2>👥 Debate de la comunidad</h2><p><strong>¿Qué contenido te gustaría ver más en ARCADIA?</strong></p><form class="formulario" id="form-comunidad"><label class="opcion"><input type="radio" name="contenido" value="Más juegos retro" required> Más juegos retro</label><label class="opcion"><input type="radio" name="contenido" value="Más emuladores"> Más emuladores</label><label class="opcion"><input type="radio" name="contenido" value="Más programas"> Más programas</label><label class="opcion"><input type="radio" name="contenido" value="Más sistemas operativos"> Más sistemas operativos</label><label for="motivo">¿Por qué elegiste esa opción?</label><textarea id="motivo" rows="4" placeholder="Contanos tu opinión..."></textarea><button class="boton" type="submit">Participar ↗</button><p id="respuesta-comunidad" class="respuesta" aria-live="polite"></p></form><p class="nota-form">La votación es una demostración visual; no se almacena todavía.</p></section>
<?php endif; ?>
</main>
<?php require __DIR__.'/includes/arcadia_pie.php'; ?>
