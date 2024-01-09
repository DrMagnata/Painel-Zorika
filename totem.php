<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>ZorikaMed Totem</title>
  <!-- Adicione o link para o Bootstrap -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <style>
    /* Estilo personalizado para as senhas preferencial e comum */
    .senha-button {
      margin-top: 20px;
    }

    body {
      background-color: black; /* Cor de fundo geral */
      color: white; /* Cor do texto geral */
    }

    #gerar-senha {
      text-align: center;
      margin-top: 40px;
    }

    /* Estilo para centralizar o texto nas divs button */
    .button-container {
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100%; /* Adiciona altura de 100% para centralizar verticalmente */
    }

    .container {
      height: 100vh; /* Adiciona altura de 100% da viewport para centralizar verticalmente */
      display: flex;
      flex-direction: column;
      justify-content: center;
    }

    h2 {
      font-size: xx-large;
    }
    /* Estilo para impressão */
    @media print {
      body * {
        visibility: hidden;
      }
      #informacoes-banco, #senha-gerada {
        visibility: visible;
      }
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="row">
      <div class="col-12 text-center">
        <h2>Gerar Senha</h2>
      </div>
    </div>
    <div class="row">
  <div class="col-12 senha-pref-button" id="gerar-senha-preferencial">
    <div class="button-container">
      <button class="btn btn-danger btn-block senha-button p-5" onclick="gerarSenha('Senha Preferencial')" style="font-size: x-large;">Atendimento Preferencial</button>
    </div>
  </div>
  <div class="col-12 senha-comum-button" id="gerar-senha-comum">
    <div class="button-container">
      <button class="btn btn-primary btn-block senha-button p-5" onclick="gerarSenha('Senha Comum')" style="font-size: x-large;">Atendimento Comum</button>
    </div>
  </div>
</div>

    <!-- Div para exibir a senha gerada -->
    <div class="row informacoes-print">
  <div class="col-12" id="senha-gerada"></div>
</div>
<div class="row informacoes-print">
  <div class="col-12" id="informacoes-banco"></div>
</div>



<!-- Adicione o script do Bootstrap (jQuery é necessário para alguns recursos) -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

<script>
  function gerarSenha(tipo) {
      // Função para fazer a requisição assíncrona ao servidor
      function fazerRequisicao(numeroAleatorio, tipo) {
        // Cria um objeto XMLHttpRequest
        var xhr = new XMLHttpRequest();

        // Configura a requisição para obter a última informação do banco de dados
        xhr.open('GET', 'obter_ultima_informacao.php', true);

        xhr.onload = function () {
    if (xhr.status >= 200 && xhr.status < 300) {
        // Converte o JSON retornado em um objeto JavaScript
        var ultimaInformacao = JSON.parse(xhr.responseText);

        // Converte a data para o formato brasileiro (DD/MM/AA)
        var dataHora = new Date(ultimaInformacao.datahora);
        var dataFormatada = ("0" + dataHora.getDate()).slice(-2) + '/' + ("0" + (dataHora.getMonth() + 1)).slice(-2) + '/' + dataHora.getFullYear().toString().slice(-2);

        // Exibe a última informação do banco de dados na página HTML
        var ultimaInformacaoHTML = '<h3>Última Informação do Banco de Dados</h3>';
        ultimaInformacaoHTML += '<p>Tipo: ' + ultimaInformacao.tipo + ', Número Aleatório: ' + ultimaInformacao.numeroAleatorio + ', Data: ' + dataFormatada + '</p>';

        document.getElementById('informacoes-banco').innerHTML = ultimaInformacaoHTML;

        // Agora, faça uma segunda requisição para gerar a senha
        fazerRequisicaoParaGerarSenha(numeroAleatorio, tipo, dataHora);
    } else {
        console.error('Erro na requisição:', xhr.statusText);
    }
};

        // Envia a requisição
        xhr.send();
      }

// Função para fazer a requisição assíncrona ao servidor para gerar a senha
function fazerRequisicaoParaGerarSenha(numeroAleatorio, tipo, dataHora) {
    // Cria um objeto XMLHttpRequest
    var xhr = new XMLHttpRequest();

    // Configura a requisição para gerar a senha
    xhr.open('GET', 'gerar_senha.php?numeroAleatorio=' + numeroAleatorio + '&tipo=' + tipo, true);

    xhr.onload = function () {
        if (xhr.status >= 200 && xhr.status < 300) {
            // Converte o JSON retornado em um objeto JavaScript
            var informacoes = JSON.parse(xhr.responseText);

            // Converte a data para o formato brasileiro (DD/MM/AA)
            var dataHoraSenha = new Date(informacoes.datahora);
            var dataFormatadaSenha = ("0" + dataHoraSenha.getDate()).slice(-2) + '/' + ("0" + (dataHoraSenha.getMonth() + 1)).slice(-2) + '/' + dataHoraSenha.getFullYear().toString().slice(-2);
            
            // Obtém horas, minutos e segundos da dataHoraSenha
            var horas = ("0" + dataHoraSenha.getHours()).slice(-2);
            var minutos = ("0" + dataHoraSenha.getMinutes()).slice(-2);
            var segundos = ("0" + dataHoraSenha.getSeconds()).slice(-2);

            // Exibe as informações na página HTML
            document.getElementById('senha-gerada').innerHTML = '' + informacoes.tipo +
                '<br>Número ' + informacoes.numeroAleatorio +
                '<br>no dia ' + dataFormatadaSenha +
                '<br>às ' + horas + ':' + minutos + ':' + segundos;

            // Após gerar a senha, imprime automaticamente
            window.print();
        } else {
            console.error('Erro na requisição:', xhr.statusText);
        }
    };

    // Envia a requisição
    xhr.send();
}

    // Gera um número aleatório
    var numeroAleatorio = gerarNumeroAleatorio();

    // Faz a requisição ao servidor para obter a última informação do banco de dados
    fazerRequisicao(numeroAleatorio, tipo);
  }

  // Função para gerar um número aleatório não utilizado na tabela 
  function gerarNumeroAleatorio() {
    return Math.floor(Math.random() * 100) + 1;
  }
</script>

<style>
  @media print {
    /* Estilos para a impressão */
    body {
      font-family: Arial, sans-serif;
      color: black; /* Cor do texto para a impressão */
      background-color: white; /* Cor de fundo para a impressão */
      font-size: xx-large;
      margin: 0; /* Remove margens padrão */
      padding: 0; /* Adiciona algum espaço interno */
      text-align: center;
    }

    @page {
      margin: 0; /* Remove margens padrão da página */
    }

    /* Mostra as informações do banco de dados apenas na impressão */
    .informacoes-print {
      display: block !important;
    }
  }

  /* Oculta as informações do banco de dados na visualização padrão da página web */
  .informacoes-print {
    display: none;
  }
</style>


</body>
</html>