<?php
$dbhost = 'localhost';
$dbuser = 'postgres';
$dbpass = '123';
$dbname = 'teste';

try {
    $conn = new PDO("pgsql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro na conexão com o banco de dados.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $local = $_POST["local"];

    // Verificar se o dado já existe na coluna 'nome' da tabela 'chamar'
    $checkQuery = $conn->prepare("SELECT COUNT(*) FROM chamar WHERE nome = :nome");
    $checkQuery->bindParam(':nome', $id);

    try {
        $checkQuery->execute();
        $rowCount = $checkQuery->fetchColumn();

        if ($rowCount > 0) {
            // Os dados já existem na tabela chamar, então vamos atualizar o valor de 'modal_voz' e 'datahora'

            // Consultar o valor atual de 'modal_voz' e 'datahora' para o ID correspondente
            $selectModalVozQuery = $conn->prepare("SELECT modal_voz, datahora FROM chamar WHERE nome = :nome");
            $selectModalVozQuery->bindParam(':nome', $id);

            try {
                $selectModalVozQuery->execute();
                $result = $selectModalVozQuery->fetch(PDO::FETCH_ASSOC);

                $modalVozAtual = $result['modal_voz'];

                // Atualizar o valor de 'modal_voz' para 1 se estiver em 2, e vice-versa
                $novoModalVoz = ($modalVozAtual == 1) ? 2 : 1;

                // Atualizar a coluna 'modal_voz' e 'datahora'
                $updateModalVozQuery = $conn->prepare("UPDATE chamar SET modal_voz = :modal_voz, datahora = NOW() WHERE nome = :nome");
                $updateModalVozQuery->bindParam(':modal_voz', $novoModalVoz);
                $updateModalVozQuery->bindParam(':nome', $id);

                try {
                    $updateModalVozQuery->execute();
                    echo "Valor de 'modal_voz' e 'datahora' atualizados com sucesso.";
                } catch (PDOException $e) {
                    echo "Erro na atualização do valor de 'modal_voz' e 'datahora': " . $e->getMessage();
                }
            } catch (PDOException $e) {
                echo "Erro na consulta do valor atual de 'modal_voz' e 'datahora': " . $e->getMessage();
            }
        } else {
            // Inserir o dado na tabela chamar
            $insertQuery = $conn->prepare("INSERT INTO chamar (nome, tipo, local, datahora, modal_voz) 
                                           SELECT id, tipo, :local, NOW(), '1' FROM espera WHERE id = :id");
            $insertQuery->bindParam(':local', $local);
            $insertQuery->bindParam(':id', $id);

            try {
                $insertQuery->execute();
                echo "Inserção realizada com sucesso";
            } catch (PDOException $e) {
                echo "Erro na inserção: " . $e->getMessage();
            }
        }
    } catch (PDOException $e) {
        echo "Erro na verificação: " . $e->getMessage();
    }
}
?>
