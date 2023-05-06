<?php
include 'config.php'; // Inclua o arquivo de configuração com a conexão ao banco de dados

// Consulta para obter todos os usuários e suas pontuações recordes
$sql = "SELECT username, pontuacao FROM usuarios ORDER BY pontuacao DESC";
$result = $conexao->query($sql);
?>
<head>


<style>
    table {
      width: 100%;
      border-collapse: collapse;
      background-color: white; /* Define o fundo da tabela como branco */
    }

    th, td {
      padding: 8px;
      text-align: left;
      border-bottom: 1px solid #ddd;
    }

    th {
      background-color: #f2f2f2;
    }
  </style>
<table>
  <thead>
    <tr>
      <th>Usuário</th>
      <th>Pontuação Recorde</th>
    </tr>
  </thead>
  <tbody>
    <?php
    // Loop para exibir os resultados da consulta na tabela
    while ($row = $result->fetch_assoc()) {
      echo "<tr>";
      echo "<td>" . $row["username"] . "</td>";
      echo "<td>" . $row["pontuacao"] . "</td>";
      echo "</tr>";
    }
    ?>
  </tbody>
</table>
</head>
<?php
$conexao->close();
?>
