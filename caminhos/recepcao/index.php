<?php
require_once('php/chamar.php');
require_once('php/chegou.php');
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Recepção</title>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/recepcao.css">

</head>
<body>

<div class="form-group">
    <label for="local">Local:</label>
    <div class="led"></div>
    <select class="form-control" id="local" name="local">
        <option value="#">Escolha o local</option>
        <option value="Recepção Guichê Número 01">Recepção 01</option>
        <option value="Recepção Guichê Número 02">Recepção 02</option>
        <option value="Recepção Guichê Número 03">Recepção 03</option>
    </select>
</div>

<script src="js/recepcao.js"></script>

</body>
</html>