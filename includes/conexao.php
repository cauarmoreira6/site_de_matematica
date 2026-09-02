<?php
$host = '127.0.0.1';
$banco = 'mathplay';
$usuario = 'root';
$senha = '';
$port = '3308';

try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$banco;charset=utf8mb4", $usuario, $senha);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $erro) {
    die('Não foi possível conectar ao banco. Verifique o MySQL e importe banco/mathplay.sql.');
}
