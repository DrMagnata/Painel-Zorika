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