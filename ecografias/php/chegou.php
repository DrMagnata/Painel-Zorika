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

// Verificar a ação do botão "Chegou"
if (isset($_POST['action']) && $_POST['action'] == 'chegou') {
    $id = htmlspecialchars($_POST['id']);

    // Atualizar a coluna "fila" para "Chegou"
    $stmtAtualizar = $db->prepare("UPDATE chamar SET fila = 'Chegou' WHERE id = :id");
    $stmtAtualizar->bindParam(':id', $id);

    try {
        $stmtAtualizar->execute();
        echo "Status atualizado para 'Chegou' com sucesso!";
    } catch (PDOException $e) {
        echo "Erro ao atualizar status para 'Chegou': " . $e->getMessage();
    }
    exit;  // Importante: interromper o script após a atualização
}
?>