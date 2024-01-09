<?php
// Configurações do banco de dados
$dbhost = 'localhost';
$dbuser = 'postgres';
$dbpass = '123';
$dbname = 'teste';

try {
    $db = new PDO("pgsql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro na conexão com o banco de dados: " . $e->getMessage());
}

// Configurar o fuso horário para Brasília
date_default_timezone_set('America/Sao_Paulo');

// Verificar a ação do botão "Chamar Novamente"
if (isset($_POST['action']) && $_POST['action'] == 'chamarNovamente') {
    $id = htmlspecialchars($_POST['id']);

    // Obter a data e hora atual no formato 'Y-m-d H:i:s'
    $datahora = date('Y-m-d H:i:s');

    // Atualizar a coluna "datahora"
    $stmtAtualizar = $db->prepare("UPDATE chamar SET datahora = :datahora WHERE id = :id");
    $stmtAtualizar->bindParam(':datahora', $datahora);
    $stmtAtualizar->bindParam(':id', $id);

    try {
        $stmtAtualizar->execute();
        echo "Datahora atualizada com sucesso!";
    } catch (PDOException $e) {
        echo "Erro ao atualizar datahora: " . $e->getMessage();
    }
    exit;  // Importante: interromper o script após a atualização
}
?>