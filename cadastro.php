<?php
require 'includes/conexao.php';
if (session_status() === PHP_SESSION_NONE) session_start();
$erro = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome']); $email = trim($_POST['email']); $senha = $_POST['senha'];
    if (strlen($senha) < 6) $erro = 'A senha precisa ter pelo menos 6 caracteres.';
    else { try { $pdo->beginTransaction(); $stmt = $pdo->prepare('INSERT INTO usuarios (nome,email,senha) VALUES (?,?,?)'); $stmt->execute([$nome,$email,password_hash($senha, PASSWORD_DEFAULT)]); $id = $pdo->lastInsertId(); $pdo->prepare('INSERT INTO progresso (usuario_id) VALUES (?)')->execute([$id]); $pdo->commit(); $_SESSION['usuario_id']=$id; $_SESSION['nome']=$nome; $_SESSION['tipo']='aluno'; header('Location: dashboard.php'); exit; } catch (PDOException $e) { if ($pdo->inTransaction()) $pdo->rollBack(); $erro = 'Este e-mail já está cadastrado.'; } }
}
$titulo = 'Criar conta'; $css = 'css/style.css'; $home = 'index.php'; include 'includes/header.php'; ?>
<div class="form-wrap"><div class="card"><div class="eyebrow">Comece sua jornada</div><h2>Criar conta</h2><p class="lead">Uma conta, muitas missões.</p><?php if ($erro): ?><div class="notice"><?= htmlspecialchars($erro) ?></div><?php endif; ?><form method="post"><label for="nome">Nome</label><input id="nome" name="nome" required><label for="email">E-mail</label><input id="email" name="email" type="email" required><label for="senha">Senha</label><input id="senha" name="senha" type="password" minlength="6" required><button class="button coral" type="submit" style="width:100%;margin-top:22px">Criar minha conta</button></form><div class="form-footer">Já joga aqui? <a href="login.php">Entrar</a></div></div></div>
<?php include 'includes/footer.php'; ?>
