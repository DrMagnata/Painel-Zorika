<?php
 require_once('php/chegou.php');
 require_once('php/chamar.php');
 require_once('php/chamar-novamente.php');
 ?>
 
<!DOCTYPE html>
<html lang="br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>The Voice ZorikaMed</title>
  <!-- Adicione o link para o Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="css/procedimentos.css">

</head>
<body> 
<div class="container mt-5">
  <div class="cabecao mx-auto text-center">
  <h1 class="mb-4">Bem Vindo, você está na sala de<br>
  Procedimentos 2</h1>
  </div>
  <form action="#" method="post">
          <div class="cabecao">
          <div class="form-group" style="display: none;">
            <label for="tipo">Selecione:</label>
            <div class="led"> </div>
            <select class="form-control" id="tipo" name="tipo">
              <option value="Paciente">Paciente</option>
            </select>
            <div class="led"> </div>
          </div>

          <div class="form-group">
            <label for="texto">Nome do Paciente:</label>
            <div class="led"> </div>
            <input type="text" class="form-control" id="texto" name="texto">
          </div>

              <div class="form-group" style="display: none;">
                <label for="local">Local:</label>
                <div class="led"> </div>

                <select class="form-control" id="local" name="local">
                <option value="Sala de Procedimentos Número 02">Procedimentos 2</option>
                </select>
              </div>
          
              <button class="btn btn-primary" onclick="verificarLocal()" type="submit">Reproduzir</button>
</form>

  <!-- Adicione o link para o Bootstrap JS e Popper.js -->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8ApSOlI/1wo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

  <?php
// Consultar o histórico do Consultório Número 01 com 'fila' igual a 'Esperando'
try {
    $stmt = $db->prepare("SELECT * FROM chamar WHERE local = 'Sala de Procedimentos Número 02' AND fila = 'Esperando'");
    $stmt->execute();
    $historico = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Erro ao consultar o histórico: " . $e->getMessage();
}
?>


<!-- Adapte esta parte no final do seu arquivo HTML -->
<!-- Adapte esta parte no final do seu arquivo HTML -->
<div class="mt-5">
    <h2>Controle de Chamada</h2>
    <table class="table table-dark table-striped">
        <thead>
            <tr>
                <th>Tipo</th>
                <th>Nome</th>
                <th>Data e Hora</th>
                <th>Ações</th> <!-- Nova coluna para os botões -->
            </tr>
        </thead>
        <tbody>
            <?php foreach ($historico as $row): ?>
                <tr>
                    <td><?= $row['tipo'] ?></td>
                    <td><?= $row['nome'] ?></td>
                    <td><?= date('d/m/y H:i:s', strtotime($row['datahora'])) ?></td>
                    <td>
                        <!-- Botões para cada linha -->
                        <button class="btn btn-primary btn-sm" onclick="chamarNovamente(<?= $row['id'] ?>)">Chamar Novamente</button>
                        <button class="btn btn-success btn-sm" onclick="chegou(<?= $row['id'] ?>)">Chegou</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<script src="js/chamar-novamente.js"></script>
<script src="js/chegou.js"></script>
</div>
</body>
</html>

