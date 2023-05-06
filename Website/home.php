<?php
session_start();
include 'config.php'; // Inclua o arquivo de configuração

// Verifique se o usuário está logado
if (!isset($_SESSION['email'])) {
  // Redirecione o usuário para a página de login ou exiba uma mensagem de erro
  header("Location: index.php");
  exit();
}

// Consulta para obter o nome de usuário com base nas informações de autenticação
// Supondo que você tenha uma tabela chamada "usuarios" com uma coluna chamada "username"
$sql = "SELECT username, email, pontuacao FROM usuarios WHERE email = '" . $_SESSION['email'] . "'";
$result = $conexao->query($sql);

if ($result->num_rows > 0) {
  // Se houver resultados, exiba o nome de usuário e pontuação no HTML
  $row = $result->fetch_assoc();
  $username = $row["username"];
  $email = $row["email"]; // Recupera o email do resultado da consulta
  $highScore = $row["pontuacao"]; // Recupera a pontuação do resultado da consulta
} else {
  // Se nenhum resultado for encontrado, defina um valor padrão para o nome de usuário, email e pontuação
  $username = "Nome de Usuário Padrão";
  $email = "Email Padrão";
  $highScore = 0;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifica se a pontuação enviada é maior que a pontuação atual
    $pontuacao = $_POST['pontuacao'];
    if ($pontuacao > $highScore) {
      $highScore = $pontuacao;
      
      // Atualize a tabela 'usuarios' no banco de dados com a nova maior pontuação
      $updateQuery = "UPDATE usuarios SET pontuacao = '$highScore' WHERE email = '$email'";
      $conexao->query($updateQuery);
    }
  }
  
$conexao->close();
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="home.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Dino</title>
</head>
<body>
<div class="container">
    
  <div class="nickname"><?php echo $username?></div>
  <a class="logout" href="index.php">LogOut</a>
  <div class="container1">
  <div class="game">
    <span id="score"><a>0</a></span>
    <div class="high-score">Maior Pontuação: <?php echo $highScore; ?></div>
    <div id="dino"></div>
    <div id="cactus"></div  >
  </div>
  <div class="leaderboard">
    <iframe src="leaderboard.php" frameborder="0" height="300"></iframe>
  </div>
</div>
</div>
<script src="dino.js"></script>
</body>
</html>
