<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function exigir_login(): void
{
    if (!isset($_SESSION['usuario_id'])) {
        header('Location: login.php');
        exit;
    }
}

function exigir_admin(): void
{
    exigir_login();
    if ($_SESSION['tipo'] !== 'admin') {
        header('Location: dashboard.php');
        exit;
    }
}

function nivel_por_xp(int $xp): int
{
    return max(1, intdiv($xp, 100) + 1);
}

function percentual_nivel(int $xp): int
{
    return $xp % 100;
}
