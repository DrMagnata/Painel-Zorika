<?php
 require_once('php/chegou.php');
 require_once('php/chamar.php');
 require_once('php/chamar-novamente.php');
 $_SESSION['con'] = 'Sala de Procedimentos Número 03';
require_once('php/historico.php');
 ?>
 
 
<!DOCTYPE html>
<html lang="br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>The Voice ZorikaMed</title>
  <link rel="stylesheet" type="text/css" href="css/procedimentos.css">

</head>
<body> 
<div class="container mt-5">
  <div class="cabecao mx-auto text-center">
  <h1 class="mb-4">Bem Vindo, você está na sala de<br>
  Procedimentos 3</h1>
  </div>
  <form action="" method="post">
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
                <option value="Sala de Procedimentos Número 03">Procedimentos 3</option>
                </select>
              </div>
          
              <button class="btn btn-primary" onclick="verificarLocal()" type="submit">Reproduzir</button>
</form>

<div class="mt-5">
    <h2>Controle de Chamada</h2>
    <table class="table table-dark table-striped custom-table">
        <thead>
            <tr>
                <th class="table-header">Tipo</th>
                <th class="table-header">Nome</th>
                <th class="table-header">Data e Hora</th>
                <th class="table-header">Ações</th> <!-- Nova coluna para os botões -->
            </tr>
        </thead>
        <tbody>
            <?php include('php/botoes.php'); ?>
        </tbody>
    </table>
</div>
 <script src="js/chamar-novamente.js"></script>
<script src="js/chegou.js"></script>
</div>

</body>
</html>

