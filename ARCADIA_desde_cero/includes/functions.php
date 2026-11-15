<?php
function limpiar($valor): string {
    return trim((string)$valor);
}
function e($valor): string {
    return htmlspecialchars((string)$valor, ENT_QUOTES, 'UTF-8');
}
