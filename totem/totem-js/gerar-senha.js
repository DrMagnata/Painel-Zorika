function gerarSenha(tipo) {
    // Função para fazer a requisição assíncrona ao servidor
    function fazerRequisicao(numeroAleatorio, tipo) {
      // Cria um objeto XMLHttpRequest
      var xhr = new XMLHttpRequest();

      // Configura a requisição para obter a última informação do banco de dados
      xhr.open('GET', 'totem/totem-php/ult_info.php', true);

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
  xhr.open('GET', 'totem/totem-php/gerar_senha.php?numeroAleatorio=' + numeroAleatorio + '&tipo=' + tipo, true);

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