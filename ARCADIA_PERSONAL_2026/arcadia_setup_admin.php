<?php
// Ejecutar una sola vez desde localhost para convertir tu cuenta en administrador.
// Primero registrate normalmente. Después abrí este archivo, escribí tu correo y eliminá este archivo.
session_start();
require_once __DIR__.'/includes/arcadia_funciones.php';
$mensaje='';
if($_SERVER['REQUEST_METHOD']==='POST'){
  $email=strtolower(trim((string)($_POST['email']??'')));
  if(filter_var($email,FILTER_VALIDATE_EMAIL)){
    $q=db()->prepare("UPDATE usuarios SET id_rol=(SELECT id_rol FROM roles WHERE nombre='Administrador') WHERE email=?");
    $q->execute([$email]); $mensaje=$q->rowCount()?'La cuenta fue convertida en Administrador. Cerrá sesión y volvé a ingresar.':'No se encontró ese correo.';
  } else $mensaje='Ingresá un correo válido.';
}
?><!doctype html><html lang="es"><meta charset="utf-8"><title>Configurar administrador</title><body><h1>Configurar administrador de ARCADIA</h1><p><?=e($mensaje)?></p><form method="post"><label>Correo de tu cuenta <input type="email" name="email" required></label><button>Convertir en administrador</button></form><p>Por seguridad, eliminá arcadia_setup_admin.php después de usarlo.</p></body></html>
