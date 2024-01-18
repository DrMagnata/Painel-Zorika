<?php
if(isset($_SESSION['con'])){


$consultorioSelecionado = $_SESSION['con'];
    try {
        $stmt = $db->prepare("SELECT * FROM chamar WHERE local = :consultorio AND fila = 'Esperando'");
        $stmt->bindParam(':consultorio', $consultorioSelecionado, PDO::PARAM_STR);
        $stmt->execute();
        $historico = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Erro ao consultar o histórico: " . $e->getMessage();
    }

}