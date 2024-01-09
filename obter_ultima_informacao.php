<?php
// Configurações do banco de dados
$dbhost = 'localhost';
$dbuser = 'postgres';
$dbpass = '123';
$dbname = 'teste';

// Cria a conexão com o banco de dados
$conn = new PDO("pgsql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);

// Consulta para obter a última informação da tabela
$stmt = $conn->prepare("SELECT * FROM espera ORDER BY datahora DESC LIMIT 1");
$stmt->execute();
$ultimaInformacao = $stmt->fetch(PDO::FETCH_ASSOC);

// Fecha a conexão com o banco de dados
$conn = null;

// Converte o formato da data para o brasileiro (DD/MM/AA)
$dataHora = new DateTime($ultimaInformacao['datahora']);
$ultimaInformacao['datahora'] = $dataHora->format('d/m/y');

// Converte o resultado em formato JSON e imprime
echo json_encode($ultimaInformacao);
?>
