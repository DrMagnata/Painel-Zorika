<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Recepção</title>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>
<body>

<style>
    body {
        background-color: #20232a; /* Cor de fundo escura */
        color: #61dafb; /* Cor do texto */
        font-family: 'Arial', sans-serif;
        margin: 0;
        padding: 0;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 100vh;
    }


    .form-group label {
        color: #61dafb; /* Cor do texto da label */
        margin-right: 10px;
    }

    .form-group select {
        padding: 5px;
        font-size: 16px;
        border: 1px solid #61dafb; /* Cor da borda do input */
        color: #61dafb; /* Cor do texto do input */
        background-color: #282c34; /* Cor de fundo escura para o input */
        border-radius: 5px;
    }

    .led {
        width: 10px;
        height: 10px;
        background-color: #ffcc00; /* Cor do indicador de LED (amarelo) */
        border-radius: 50%;
        display: inline-block;
        margin-right: 5px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    th, td {
        border: 1px solid #61dafb; /* Cor da borda das células da tabela */
        padding: 8px;
        text-align: left;
    }

    th {
        background-color: #282c34; /* Cor de fundo do cabeçalho da tabela */
        color: #61dafb; /* Cor do texto do cabeçalho da tabela */
    }

    tr:nth-child(even) {
        background-color: #282c34; /* Cor de fundo das linhas pares */
    }

    button {
        padding: 5px 10px;
        font-size: 14px;
        cursor: pointer;
        margin-right: 5px;
        background-color: #61dafb; /* Cor de fundo do botão */
        color: #20232a; /* Cor do texto do botão */
        border: none;
        border-radius: 5px;
    }

    button:hover {
        background-color: #45a049; /* Cor de fundo do botão ao passar o mouse */
    }

    button:disabled {
        background-color: #a0a0a0; /* Cor de fundo do botão desativado */
        cursor: not-allowed;
    }
</style>

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


<?php

$dbhost = 'localhost';
$dbuser = 'postgres';
$dbpass = '123';
$dbname = 'teste';

$conn = new PDO("pgsql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);

if (isset($_POST['chegou'])) {
    $id_chegou = $_POST['chegou'];
    $updateQuery = $conn->prepare("UPDATE espera SET fila = 'chegou' WHERE id = :id");
    $updateQuery->bindParam(':id', $id_chegou);
    $updateQuery->execute();
}


if (isset($_POST['Chamar'])) {
    $id_Chamar = $_POST['Chamar'];
}

$query = $conn->query("SELECT * FROM espera WHERE fila = 'esperando' ORDER BY datahora");
$data = $query->fetchAll(PDO::FETCH_ASSOC);

echo '<form method="post" action="">';
echo '<table border="1" id="tabela-espera">
        <tr>
            <th>N°</th>
            <th>Tipo</th>
            <th>Data e Hora</th>
            <th>Ações</th>
            <!-- Adicione mais colunas conforme necessário -->
        </tr>';
foreach ($data as $row) {
    echo '<tr data-id="' . $row['id'] . '">';
    echo '<td>' . $row['id'] . '</td>'; 
    echo '<td>' . $row['tipo'] . '</td>'; 
    echo '<td>' . date('d/m/y H:i:s', strtotime($row['datahora'])) . '</td>'; 
    echo '<td>';
    echo '<button type="button" data-action="chegou" onclick="handleButtonClick(' . $row['id'] . ', \'chegou\')">Chegou</button>';
    echo '<button type="button" class="chamar-btn" data-action="chamar" data-id="' . $row['id'] . '">Chamar</button>';
    echo '</td>';
    echo '</tr>';
}
echo '</table>';
echo '</form>';
?>


<script>
$(document).ready(function() {
    // Delegação de eventos para preservar os eventos dos botões
    $('#tabela-espera').on('click', 'button', function() {
        var id = $(this).closest('tr').data('id');
        var selectedLocal = $('#local').val();

        if (selectedLocal === '#') {
            alert('Por Gentileza, Escolha Adequadamente o local');
            return;
        }

        var action = $(this).data('action');
        handleButtonClick(id, action);
    });

    function handleButtonClick(id, action) {
        var selectedLocal = $('#local').val();

        if (selectedLocal === '#') {
            alert('Por Gentileza, Escolha Adequadamente o local');
            return;
        }

        if (action === 'chamar') {
            $.ajax({
                type: 'POST',
                url: 'chamar.php',
                data: { id: id, local: selectedLocal },
                success: function (response) {
                    console.log('Inserção realizada com sucesso:', response);
                    updateTable();
                }
            });
        }

        $.ajax({
            type: 'POST',
            url: 'atualizar_dados.php', 
            data: { id: id, action: action },
            success: function (response) {
                var rowSelector = '#tabela-espera tr[data-id="' + id + '"]';
                var row = $(rowSelector);

                row.find('.status-cell').html(response);

                // Adicione mais linhas conforme necessário para outras células que precisam ser atualizadas

                row.find('td').addClass('sua-classe'); 
            }
        });
    }

    function updateTable() {
        $.ajax({
            type: 'GET',
            url: 'atualizar_dados.php', 
            success: function (response) {
                $('#tabela-espera').html(response);
            }
        });
    }

    function handleAutoUpdate() {
        setInterval(updateTable, 4000);
    }

    handleAutoUpdate();
});
</script>

</body>
</html>