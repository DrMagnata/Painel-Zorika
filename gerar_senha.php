<?php
// Configurações do banco de dados
$dbhost = 'localhost';
$dbuser = 'postgres';
$dbpass = '123';
$dbname = 'teste';

// Cria a conexão com o banco de dados
$conn = new PDO("pgsql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);

// Função para gerar um número aleatório não utilizado na tabela
function gerarNumeroAleatorio($conn) {
    $numeroAleatorio = mt_rand(1, 100); // Gera um número aleatório entre 1 e 100 (ajuste conforme necessário)

    // Verifica se o número já existe na tabela
    $stmt = $conn->prepare("SELECT COUNT(*) FROM espera WHERE id = :id");
    $stmt->bindParam(':id', $numeroAleatorio);
    $stmt->execute();

    // Se o número já existir, gera um novo
    while ($stmt->fetchColumn() > 0) {
        $numeroAleatorio = mt_rand(1, 999);
        $stmt->bindParam(':id', $numeroAleatorio);
        $stmt->execute();
    }

    return $numeroAleatorio;
}

// Gera um número aleatório
$numeroAleatorio = gerarNumeroAleatorio($conn);

// Obtém o tipo do parâmetro GET
$tipo = $_GET['tipo'];

// Adiciona a palavra 'esperando' à coluna 'fila'
$esperando = 'esperando';

// Insere o novo número na tabela
$stmt = $conn->prepare("INSERT INTO espera (id, datahora, tipo, fila) VALUES (:id, NOW(), :tipo, :fila)");
$stmt->bindParam(':id', $numeroAleatorio);
$stmt->bindParam(':tipo', $tipo);
$stmt->bindParam(':fila', $esperando);

if ($stmt->execute()) {
    // Fecha a conexão com o banco de dados
    $conn = null;

    // Retorna a resposta ao cliente
    echo json_encode(['tipo' => $tipo, 'numeroAleatorio' => $numeroAleatorio, 'datahora' => date('Y-m-d H:i:s'), 'fila' => $esperando]);
} else {
    // Se houver um erro na execução da consulta
    echo json_encode(['erro' => 'Erro ao executar a consulta SQL.']);
}
?>
