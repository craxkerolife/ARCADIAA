<?php
session_start();
require_once __DIR__.'/includes/arcadia_funciones.php';
requiere_admin();
$pdo=db(); $mensaje=''; $error='';
if ($_SERVER['REQUEST_METHOD']==='POST') {
    validar_csrf();
    $accion=$_POST['accion'] ?? '';
    if ($accion==='crear') {
        $titulo=limpiar($_POST['titulo'] ?? ''); $descripcion=limpiar($_POST['descripcion'] ?? '');
        $tipo=$_POST['tipo'] ?? ''; $url=trim((string)($_POST['url'] ?? ''));
        $cat=(int)($_POST['categoria'] ?? 0);
        if ($titulo==='' || !in_array($tipo,['Juego','Emulador','Simulador','Aplicacion'],true) || !filter_var($url,FILTER_VALIDATE_URL)) $error='Completá título, tipo y una URL válida.';
        else {
            $q=$pdo->prepare("INSERT INTO recursos (id_usuario,id_categoria,titulo,descripcion,tipo,url) VALUES (?,?,?,?,?,?)");
            $q->execute([usuario_actual()['id'],$cat,$titulo,$descripcion,$tipo,$url]); $mensaje='Recurso agregado al catálogo.';
        }
    } elseif ($accion==='estado') {
        $q=$pdo->prepare("UPDATE recursos SET estado=? WHERE id_recurso=?");
        $q->execute([($_POST['estado'] ?? '')==='Activo'?'Activo':'Inactivo',(int)($_POST['id'] ?? 0)]);
        $mensaje='Estado actualizado.';
    } elseif ($accion==='eliminar') {
        $q=$pdo->prepare("DELETE FROM recursos WHERE id_recurso=?"); $q->execute([(int)($_POST['id'] ?? 0)]); $mensaje='Recurso eliminado.';
    }
}
$categorias=$pdo->query("SELECT * FROM categorias ORDER BY nombre")->fetchAll();
$recursos=$pdo->query("SELECT r.*,c.nombre AS categoria FROM recursos r INNER JOIN categorias c ON c.id_categoria=r.id_categoria ORDER BY r.created_at DESC")->fetchAll();
$titulo_pagina='Administración | ARCADIA';
require __DIR__.'/includes/arcadia_cabecera.php';
?>
<main class="contenedor"><section class="encabezado-pagina"><span class="etiqueta">PANEL PRIVADO</span><h2>Administrar ARCADIA</h2><p>Agregá recursos y mantené actualizado el catálogo.</p></section>
<?php if($mensaje): ?><div class="alerta exito"><?=e($mensaje)?></div><?php endif; ?><?php if($error): ?><div class="alerta error"><?=e($error)?></div><?php endif; ?>
<section class="panel"><h3>Agregar recurso</h3><form class="formulario" method="POST"><input type="hidden" name="csrf" value="<?=e(csrf_token())?>"><input type="hidden" name="accion" value="crear">
<label>Título</label><input name="titulo" maxlength="150" required><label>Descripción</label><textarea name="descripcion" rows="3"></textarea>
<label>Tipo</label><select name="tipo"><option>Juego</option><option>Emulador</option><option>Simulador</option><option>Aplicacion</option></select>
<label>Categoría</label><select name="categoria"><?php foreach($categorias as $c): ?><option value="<?=$c['id_categoria']?>"><?=e($c['nombre'])?></option><?php endforeach; ?></select>
<label>Enlace</label><input type="url" name="url" required placeholder="https://..."><button class="boton">Guardar recurso</button></form></section>
<section class="panel" style="margin-top:22px"><h3>Recursos cargados</h3><div class="tabla-scroll"><table><tr><th>Título</th><th>Tipo</th><th>Estado</th><th>Acciones</th></tr>
<?php foreach($recursos as $r): ?><tr><td><?=e($r['titulo'])?></td><td><?=e($r['tipo'])?></td><td><?=e($r['estado'])?></td><td><form method="POST" class="acciones-tabla"><input type="hidden" name="csrf" value="<?=e(csrf_token())?>"><input type="hidden" name="id" value="<?=$r['id_recurso']?>"><button name="accion" value="estado" class="boton boton-secundario" onclick="this.form.estado.value='<?=$r['estado']==='Activo'?'Inactivo':'Activo'?>'">Cambiar estado</button><input type="hidden" name="estado" value="<?=$r['estado']==='Activo'?'Inactivo':'Activo'?>"><button name="accion" value="eliminar" class="boton boton-peligro" onclick="return confirm('¿Eliminar este recurso?')">Eliminar</button></form></td></tr><?php endforeach; ?>
<?php if(!$recursos): ?><tr><td colspan="4">Todavía no hay recursos cargados.</td></tr><?php endif; ?></table></div></section></main>
<?php require __DIR__.'/includes/arcadia_pie.php'; ?>
