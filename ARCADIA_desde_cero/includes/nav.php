<nav class="navegacion" aria-label="Navegación principal">
  <?php foreach ($secciones as $clave => $nombre): ?>
    <a class="<?= $seccion === $clave ? 'active' : '' ?>" href="index.php?seccion=<?= e($clave) ?>"><?= e($nombre) ?></a>
  <?php endforeach; ?>
</nav>
