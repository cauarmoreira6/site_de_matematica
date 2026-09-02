<?php
require 'includes/conexao.php';
if (session_status() === PHP_SESSION_NONE) session_start();
if (isset($_SESSION['usuario_id'])) { header('Location: dashboard.php'); exit; }
$erro = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare('SELECT * FROM usuarios WHERE email = ?');
    $stmt->execute([trim($_POST['email'])]); $usuario = $stmt->fetch();
    if ($usuario && password_verify($_POST['senha'], $usuario['senha'])) {
        $_SESSION['usuario_id'] = $usuario['id']; $_SESSION['nome'] = $usuario['nome']; $_SESSION['tipo'] = $usuario['tipo'];
        header('Location: ' . ($usuario['tipo'] === 'admin' ? 'admin/dashboard.php' : 'dashboard.php')); exit;
    }
    $erro = 'E-mail ou senha não conferem.';
}
$titulo = 'Entrar'; $css = 'css/style.css'; $home = 'index.php'; include 'includes/header.php'; ?>
<div class="form-wrap"><div class="card"><div class="eyebrow">Bem-vindo de volta</div><h2>Entrar</h2><p class="lead">Continue sua próxima missão.</p><?php if ($erro): ?><div class="notice"><?= htmlspecialchars($erro) ?></div><?php endif; ?><form method="post"><label for="email">E-mail</label><input id="email" name="email" type="email" required><label for="senha">Senha</label><input id="senha" name="senha" type="password" required><button class="button" type="submit" style="width:100%;margin-top:22px">Entrar</button></form><div class="form-footer">Ainda não tem conta? <a href="cadastro.php">Cadastre-se</a></div></div></div>
<?php include 'includes/footer.php'; ?>
