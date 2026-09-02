<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$titulo = $titulo ?? 'MathPlay Solutions';
$pagina = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($titulo) ?> | MathPlay</title>
    <link rel="stylesheet" href="<?= $css ?? (($root ?? '') . 'css/style.css') ?>">
</head>
<body>
<header class="topbar">
    <a class="brand" href="<?= $home ?? 'dashboard.php' ?>"><span class="brand-mark">M</span> MathPlay <strong>Solutions</strong></a>
    <?php if (isset($_SESSION['usuario_id'])): ?>
    <nav class="nav-links">
        <a class="<?= $pagina === 'dashboard.php' ? 'active' : '' ?>" href="<?= $home ?? 'dashboard.php' ?>">Painel</a>
        <a href="<?= $root ?? '' ?>jogos.php">Jogos</a>
        <a href="<?= $root ?? '' ?>ranking.php">Ranking</a>
        <a href="<?= $root ?? '' ?>perfil.php">Perfil</a>
        <?php if ($_SESSION['tipo'] === 'admin'): ?><a href="<?= $root ?? '' ?>admin/dashboard.php">Admin</a><?php endif; ?>
        <a class="nav-exit" href="<?= $root ?? '' ?>logout.php">Sair</a>
    </nav>
    <?php endif; ?>
</header>
<main class="page-shell">
