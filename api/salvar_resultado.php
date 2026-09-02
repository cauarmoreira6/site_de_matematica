<?php
require '../includes/conexao.php'; require '../includes/verificar_login.php';
header('Content-Type: application/json; charset=utf-8'); exigir_login();
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { http_response_code(405); echo json_encode(['erro'=>'Método inválido']); exit; }
$dados = json_decode(file_get_contents('php://input'), true);
$jogo = trim($dados['jogo'] ?? ''); $dificuldade = $dados['dificuldade'] ?? 'facil'; $acertos = (int)($dados['acertos'] ?? 0); $erros = (int)($dados['erros'] ?? 0); $pontuacao = (int)($dados['pontuacao'] ?? 0);
$permitidos = ['facil','medio','dificil'];
if (!$jogo || !in_array($dificuldade, $permitidos, true) || $acertos < 0 || $erros < 0) { http_response_code(422); echo json_encode(['erro'=>'Dados da partida inválidos']); exit; }
try {
    $pdo->beginTransaction(); $id = $_SESSION['usuario_id'];
    $pdo->prepare('INSERT INTO resultados (usuario_id,jogo,dificuldade,pontuacao,acertos,erros) VALUES (?,?,?,?,?,?)')->execute([$id,$jogo,$dificuldade,$pontuacao,$acertos,$erros]);
    $xpGanho = ($acertos * 10) + ($acertos >= 3 ? 10 : 0) + 20;
    $stmt = $pdo->prepare('SELECT xp FROM progresso WHERE usuario_id = ? FOR UPDATE'); $stmt->execute([$id]); $atual = $stmt->fetch(); $novoXp = ($atual['xp'] ?? 0) + $xpGanho; $nivel = nivel_por_xp($novoXp); $percentual = percentual_nivel($novoXp);
    $pdo->prepare('INSERT INTO progresso (usuario_id,xp,nivel,percentual) VALUES (?,?,?,?) ON DUPLICATE KEY UPDATE xp=VALUES(xp),nivel=VALUES(nivel),percentual=VALUES(percentual)')->execute([$id,$novoXp,$nivel,$percentual]);
    $pdo->prepare("INSERT IGNORE INTO usuario_conquistas (usuario_id,conquista_id) SELECT ?, id FROM conquistas WHERE nome = 'Primeiro Passo'")->execute([$id]);
    if ($acertos === 5) $pdo->prepare("INSERT IGNORE INTO usuario_conquistas (usuario_id,conquista_id) SELECT ?, id FROM conquistas WHERE nome = 'Sequência Perfeita'")->execute([$id]);
    if ($erros === 0) $pdo->prepare("INSERT IGNORE INTO usuario_conquistas (usuario_id,conquista_id) SELECT ?, id FROM conquistas WHERE nome = 'Sem Errar'")->execute([$id]);
    $pdo->prepare("INSERT IGNORE INTO usuario_conquistas (usuario_id,conquista_id) SELECT ?, id FROM conquistas WHERE nome = 'Mestre da Matemática' AND (SELECT COALESCE(SUM(acertos),0) FROM resultados WHERE usuario_id = ?) >= 20")->execute([$id,$id]);
    $pdo->prepare("INSERT IGNORE INTO usuario_conquistas (usuario_id,conquista_id) SELECT ?, id FROM conquistas WHERE nome = 'Jogador Frequente' AND (SELECT COUNT(*) FROM resultados WHERE usuario_id = ?) >= 5")->execute([$id,$id]);
    $pdo->commit(); echo json_encode(['ok'=>true,'xpGanho'=>$xpGanho,'xp'=>$novoXp,'nivel'=>$nivel]);
} catch (Exception $erro) { if ($pdo->inTransaction()) $pdo->rollBack(); http_response_code(500); echo json_encode(['erro'=>'Não foi possível salvar a partida.']); }
