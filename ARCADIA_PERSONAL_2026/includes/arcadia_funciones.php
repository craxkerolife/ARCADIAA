<?php
function limpiar($valor): string {
    return trim((string)$valor);
}
function e($valor): string {
    return htmlspecialchars((string)$valor, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}
function db(): PDO {
    static $pdo = null;
    if ($pdo instanceof PDO) return $pdo;
    require __DIR__ . '/../config/arcadia_configuracion.php';
    $pdo = new PDO(
        'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4',
        DB_USER,
        DB_PASS,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
         PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
         PDO::ATTR_EMULATE_PREPARES => false]
    );
    return $pdo;
}
function usuario_actual(): ?array {
    return $_SESSION['usuario'] ?? null;
}
function requiere_login(): void {
    if (!usuario_actual()) {
        header('Location: arcadia_login.php');
        exit;
    }
}
function requiere_admin(): void {
    requiere_login();
    if ((usuario_actual()['rol'] ?? '') !== 'Administrador') {
        http_response_code(403);
        exit('No tenés permisos para acceder a esta sección.');
    }
}
function csrf_token(): string {
    if (empty($_SESSION['csrf'])) $_SESSION['csrf'] = bin2hex(random_bytes(32));
    return $_SESSION['csrf'];
}
function validar_csrf(): void {
    $token = $_POST['csrf'] ?? '';
    if (!is_string($token) || !hash_equals(csrf_token(), $token)) {
        http_response_code(419);
        exit('La sesión del formulario venció. Volvé atrás y probá nuevamente.');
    }
}
