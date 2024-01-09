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

// Processar dados do formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tipo = htmlspecialchars($_POST['tipo']);
    $nome = htmlspecialchars($_POST['texto']);
    $local = htmlspecialchars($_POST['local']);

    // Verificar se o campo 'texto' está preenchido
    if (empty($nome)) {
        echo "Por favor, preencha o campo 'Nome do Paciente'.";
    } elseif ($local === '#') {
        echo "Por Gentileza, Escolha Adequadamente o local.";
    } else {
        // Obter a data e hora atual no formato 'Y-m-d H:i:s'
        $datahora = date('Y-m-d H:i:s');

        // Valor padrão para a coluna 'fila'
        $valorFila = 'Esperando';

        // Verificar se o paciente já existe no banco de dados
        $stmtVerificar = $db->prepare("SELECT id FROM chamar WHERE nome = :nome AND local = :local");
        $stmtVerificar->bindParam(':nome', $nome);
        $stmtVerificar->bindParam(':local', $local);
        $stmtVerificar->execute();
        $result = $stmtVerificar->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            // Paciente já existe, realizar a atualização
            $idPacienteExistente = $result['id'];

            $stmtAtualizar = $db->prepare("UPDATE chamar SET datahora = :datahora, fila = :fila WHERE id = :id");
            $stmtAtualizar->bindParam(':datahora', $datahora);
            $stmtAtualizar->bindParam(':fila', $valorFila);
            $stmtAtualizar->bindParam(':id', $idPacienteExistente);

            try {
                $stmtAtualizar->execute();
                echo "Dados atualizados com sucesso!";
            } catch (PDOException $e) {
                echo "Erro ao atualizar dados: " . $e->getMessage();
            }
        } else {
            // Paciente não existe, realizar a inserção
            $stmtInserir = $db->prepare("INSERT INTO chamar (tipo, nome, local, datahora, fila) VALUES (:tipo, :texto, :local, :datahora, :fila)");
            $stmtInserir->bindParam(':tipo', $tipo);
            $stmtInserir->bindParam(':texto', $nome);
            $stmtInserir->bindParam(':local', $local);
            $stmtInserir->bindParam(':datahora', $datahora);
            $stmtInserir->bindParam(':fila', $valorFila);

            try {
                $stmtInserir->execute();
                echo "Dados inseridos com sucesso!";
            } catch (PDOException $e) {
                echo "Erro ao inserir dados: " . $e->getMessage();
            }
        }
    }
}
?>