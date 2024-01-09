<?php
$dbhost = 'localhost';
$dbuser = 'postgres';
$dbpass = '123';
$dbname = 'teste';

$conn = new PDO("pgsql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);

if ($_POST['action'] == 'chegou') {
    $id_chegou = $_POST['id'];
    $updateQuery = $conn->prepare("UPDATE espera SET fila = 'chegou' WHERE id = :id");
    $updateQuery->bindParam(':id', $id_chegou);
    $updateQuery->execute();
} elseif ($_POST['action'] == 'chamar_novamente') {
    $id_chamar_novamente = $_POST['id'];
}

$query = $conn->prepare("SELECT * FROM espera WHERE fila = 'esperando' ORDER BY datahora");
$query->execute();
$data = $query->fetchAll(PDO::FETCH_ASSOC);

$response = '<table border="1">
                <tr>
                    <th>N°</th>
                    <th>Tipo</th>
                    <th>Data e Hora</th>
                    <th>Ações</th>
                    <!-- Adicione mais colunas conforme necessário -->
                </tr>';
foreach ($data as $row) {
    $formattedDateTime = date('d/m/y H:i:s', strtotime($row['datahora'])); 
    $response .= '<tr data-id="' . $row['id'] . '">';
    $response .= '<td>' . $row['id'] . '</td>';
    $response .= '<td>' . $row['tipo'] . '</td>';
    $response .= '<td>' . $formattedDateTime . '</td>'; 
    $response .= '<td>';
    $response .= '<button type="button" data-action="chegou">Chegou</button>';
    $response .= '<button type="button" class="chamar-btn" data-action="chamar" data-id="' . $row['id'] . '">Chamar</button>';
    $response .= '</td>';
    $response .= '</tr>';
}
$response .= '</table>';

echo $response;
?>
