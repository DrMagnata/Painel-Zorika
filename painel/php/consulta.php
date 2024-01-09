<?php
$dbhost = 'localhost';
$dbuser = 'postgres';
$dbpass = '123';
$dbname = 'teste';

try {
    $db = new PDO("pgsql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro na conexão com o banco de dados.");
}

$sql = "SELECT tipo, nome, local, TO_CHAR(datahora, 'DD/MM/YYYY HH24:MI:SS') AS datahora_formatada, modal_voz FROM chamar ORDER BY datahora DESC";

try {
    $stmt = $db->prepare($sql);
    $stmt->execute();
    
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode($result);
} catch (PDOException $e) {
    error_log("Erro na consulta: " . $e->getMessage());
    echo "Erro na consulta.";
}

?>