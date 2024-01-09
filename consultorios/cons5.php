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



<!DOCTYPE html>
<html lang="br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>The Voice ZorikaMed</title>
  <!-- Adicione o link para o Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

  <style>
    body {
      background-color: rgb(48, 48, 48);
    }

    .cabecao {
      background-color: rgb(66, 66, 66); /* Cor principal de fundo */
      color: rgb(178, 178, 178); /* Cor do texto */
      border-radius: 10px;
      margin-top: 20px;
      padding: 20px;
    }

    /* Cor secundária para o formulário */
    form {
      background-color: rgb(66, 66, 66);
      padding: 20px;
      border-radius: 10px;
      margin-top: 20px;
    }

    /* Cor secundária para os labels */
    label {
      color: rgb(66, 66, 66);
    }

    /* Cor secundária para os inputs */
    input,
    label {
      background-color: rgb(48, 48, 48);
      color: rgb(178, 178, 178);
      border: none;
      border-radius: 5px;
      padding: 8px 12px;
      margin-bottom: 10px;
    }

    /* Estilo para o botão Enviar */
    input[type="submit"] {
      background-color: rgb(178, 178, 178);
      color: rgb(48, 48, 48);
      cursor: pointer;
    }


    .led {
	width: 100%;
	height: 2px;
	background: linear-gradient(208deg, #bd1e27, blue, #bd1e27, blue, #bd1e27);
	background-size: 1000% 1000%;
	animation: RGB-BACKGROUD-LINEAR-GRADIENT 5s ease infinite;
  }
  
  
  @keyframes RGB-BACKGROUD-LINEAR-GRADIENT {
	0% {
	  background-position: 96% 0%;
	  background-position-x: 96%;
	  background-position-y: 0%;
	}
	50% {
	  background-position: 5% 100%;
	  background-position-x: 5%;
	  background-position-y: 100%;
	}
	100% {
	  background-position: 96% 0%;
	  background-position-x: 96%;
	  background-position-y: 0%;
	}
  }

  </style>
</head>
<body> 
  <div class="container mt-5">
  <div class="cabecao mx-auto text-center">
    <h1 class="mb-4">Bem Vindo, você está no<br>
  Consultório 05</h1>
  </div>
  <form action="#" method="post">
          <div class="cabecao">
          <div class="form-group" style="display: none;">
            <label for="tipo">Selecione:</label>
            <div class="led"> </div>
            <select class="form-control" id="tipo" name="tipo">
              <option value="Paciente">Paciente</option>
            </select>
            <div class="led"> </div>
          </div>

          <div class="form-group">
            <label for="texto">Nome do Paciente:</label>
            <div class="led"> </div>
            <input type="text" class="form-control" id="texto" name="texto">
          </div>

              <div class="form-group" style="display: none;">
                <label for="local">Local:</label>
                <div class="led"> </div>

                <select class="form-control" id="local" name="local">
                  <option value="Consultório Número 05">Consultório 5</option>
                </select>
              </div>
          
              <button class="btn btn-primary" onclick="verificarLocal()" type="submit">Reproduzir</button>
</form>

  <!-- Adicione o link para o Bootstrap JS e Popper.js -->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8ApSOlI/1wo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

  <?php
// Consultar o histórico do Consultório Número 01 com 'fila' igual a 'Esperando'
try {
    $stmt = $db->prepare("SELECT * FROM chamar WHERE local = 'Consultório Número 05' AND fila = 'Esperando'");
    $stmt->execute();
    $historico = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Erro ao consultar o histórico: " . $e->getMessage();
}
?>


<!-- Adapte esta parte no final do seu arquivo HTML -->
<!-- Adapte esta parte no final do seu arquivo HTML -->
<div class="mt-5">
    <h2>Controle de Chamada</h2>
    <table class="table table-dark table-striped">
        <thead>
            <tr>
                <th>Tipo</th>
                <th>Nome</th>
                <th>Data e Hora</th>
                <th>Ações</th> <!-- Nova coluna para os botões -->
            </tr>
        </thead>
        <tbody>
            <?php foreach ($historico as $row): ?>
                <tr>
                    <td><?= $row['tipo'] ?></td>
                    <td><?= $row['nome'] ?></td>
                    <td><?= date('d/m/y H:i:s', strtotime($row['datahora'])) ?></td>
                    <td>
                        <!-- Botões para cada linha -->
                        <button class="btn btn-primary btn-sm" onclick="chamarNovamente(<?= $row['id'] ?>)">Chamar Novamente</button>
                        <button class="btn btn-success btn-sm" onclick="chegou(<?= $row['id'] ?>)">Chegou</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>
    // Funções para os botões (pode personalizar conforme necessário)
    function chamarNovamente(id) {
        // Lógica para chamar novamente com base no ID
        console.log('Chamando novamente: ' + id);
    }

    function chegou(id) {
        // Lógica para indicar que chegou com base no ID
        console.log('Chegou: ' + id);
    }
</script>

<script>
    async function chamarNovamente(id) {
        try {
            const response = await fetch('cons5.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `action=chamarNovamente&id=${id}`,
            });

            const result = await response.text();
            console.log(result);

            // Atualizar a interface do usuário conforme necessário (opcional)
        } catch (error) {
            console.error('Erro ao chamar novamente:', error);
        }
    }
</script>
<script>
    async function chegou(id) {
        try {
            const response = await fetch('cons5.php', { 
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `action=chegou&id=${id}`,
            });

            const result = await response.text();
            console.log(result);

            // Atualizar a interface do usuário conforme necessário (opcional)
        } catch (error) {
            console.error('Erro ao atualizar status para "Chegou":', error);
        }
    }
</script>


</div>
</body>
</html>

