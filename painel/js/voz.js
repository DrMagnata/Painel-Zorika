document.addEventListener("DOMContentLoaded", function () {
    // Variável para armazenar os dados mais recentes
    var ultimaLinhaAtual = null;
  
    // Função para carregar os dados do banco de dados referentes à última linha com timeout
    function carregarUltimaLinha() {
      $.ajax({
        url: 'php/consulta.php', // Substitua 'consulta_timeout.php' pelo URL real do seu arquivo de consulta para timeouts
        type: 'GET',
        dataType: 'json',
        success: function (data) {
          // Verifica se há dados disponíveis
          if (data.length > 0) {
            // Ordena os dados por datahora de forma decrescente
            data.sort(function (a, b) {
              return new Date(b.datahora) - new Date(a.datahora);
            });
  
            // Pega a última linha com timeout mais recente
            var ultimaLinha = data[0];
  
            // Verifica se os dados são diferentes dos dados atuais antes de atualizar
            if (!saoIguais(ultimaLinha, ultimaLinhaAtual)) {
              // Preenche a div 'ultima-fade-in' com os dados do banco de dados
              preencherUltimaLinha(ultimaLinha);
  
              // Obtém as classes de estilo do card
              var cardClasses = getCardClasses(ultimaLinha);
  
              // Adiciona as classes à div 'ultima-fade-in'
              $('.ultima-fade-in').attr('class', 'ultima-fade-in ' + cardClasses);
  
              // Executa a animação de fade-in
              var ultimaFadeInDiv = $('.ultima-fade-in');
              ultimaFadeInDiv.addClass('fade-in');
  
              // Chama a função playVoice
              playVoice(getTextToRead(ultimaLinha));
  
              setTimeout(function () {
                ultimaFadeInDiv.removeClass('fade-in');
                ultimaFadeInDiv.addClass('hidden'); // Adiciona a classe 'hidden' após a animação
              }, 5000); // Tempo da animação em milissegundos
  
              // Atualiza a variável com os dados mais recentes
              ultimaLinhaAtual = ultimaLinha;
            }
          } else {
            // Se não houver dados, pode esconder a div ou mostrar uma mensagem indicando a ausência de dados
            $('.ultima-fade-in').addClass('hidden');
          }
        },
        error: function () {
          console.error('Erro ao carregar os dados do banco de dados.');
        }
      });
    }
  
    // Função para verificar se dois objetos são iguais
    function saoIguais(obj1, obj2) {
      return JSON.stringify(obj1) === JSON.stringify(obj2);
    }
  
    // Função para obter as classes de estilo do card
    function getCardClasses(data) {
      var classes = '';
  
      // Adapte este trecho de acordo com a estrutura do seu objeto de dados
      if (data.tipo === 'Paciente') {
        classes = 'paciente-card';
      } else if (data.tipo === 'Senha Comum' || data.tipo === 'Senha Preferencial') {
        classes = 'chamada';
      }
  
      return classes;
    }
  
    // Função para preencher a div 'ultima-fade-in' com os dados do banco de dados
    function preencherUltimaLinha(data) {
      var ultimaFadeInDiv = $('.ultima-fade-in');
      ultimaFadeInDiv.empty(); // Limpa o conteúdo atual
  
      // Cria os elementos com os dados da última linha
      var linhaElement = $('<div>').addClass('linha');
      linhaElement.append('<span>' + data.tipo + '</span><br>');
      linhaElement.append('<span>' + data.nome + '</span><br>');
      linhaElement.append('<span>' + data.local + '</span><br>');
  
      // Adiciona a linha à div 'ultima-fade-in'
      ultimaFadeInDiv.append(linhaElement);
  
      // Remove a classe 'hidden' para tornar a div visível
      ultimaFadeInDiv.removeClass('hidden');
  
      // Executa a animação de fade-in apenas se houver uma nova informação
      if (ultimaLinhaAtual !== null) {
        // Obtém as classes de estilo do card
        var cardClasses = getCardClasses(data);
  
        // Adiciona as classes à div 'ultima-fade-in'
        ultimaFadeInDiv.attr('class', 'ultima-fade-in ' + cardClasses);
  
        // Executa a animação de fade-in
        ultimaFadeInDiv.addClass('fade-in');
        setTimeout(function () {
          ultimaFadeInDiv.removeClass('fade-in');
          ultimaFadeInDiv.addClass('hidden'); // Adiciona a classe 'hidden' após a animação
        }, 5000); // Tempo da animação em milissegundos
      }
  
      // Atualiza a variável com os dados mais recentes
      ultimaLinhaAtual = data;
    }
  
    // Função para obter o texto a ser lido em voz alta
    function getTextToRead(data) {
      var texto = '';
  
      // Adapte este trecho de acordo com a estrutura do seu objeto de dados
      if (data.tipo === 'Paciente') {
        texto = 'Atenção ' + data.tipo + '\n' +
          ' ' + data.nome + '\n' +
          ' Compareça por gentileza ' + data.local;
      } else if (data.tipo === 'Senha Comum' || data.tipo === 'Senha Preferencial') {
        texto = 'Atenção ' + data.tipo + '\n' +
          ' ' + data.nome + '\n' +
          ' Compareça por gentileza ' + data.local;
      }
  
      return texto;
    }
  
    // Função para reproduzir a voz
    function playVoice(text) {
      var msg = new SpeechSynthesisUtterance();
      msg.text = text;
      window.speechSynthesis.speak(msg);
    }
  
    // Chama a função para carregar a última linha ao carregar a página
    carregarUltimaLinha();
  
    // Define o intervalo para chamar a função carregarUltimaLinha a cada 4 segundos
    setInterval(carregarUltimaLinha, 4000);
  });
  