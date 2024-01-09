document.addEventListener("DOMContentLoaded", function () {
    // Função para carregar os dados do banco de dados
    function carregarDados() {
      $.ajax({
        url: 'php/consulta.php', // Substitua 'consulta.php' pelo URL real do seu arquivo de consulta
        type: 'GET',
        dataType: 'json',
        success: function (data) {
          // Filtra os dados para incluir apenas os do tipo 'paciente'
          var pacientes = data.filter(function (item) {
            return item.tipo === 'Paciente';
          });

          // Filtra os dados para incluir apenas senhas comuns e preferenciais
          var senhas = data.filter(function (item) {
            return item.tipo === 'Senha Comum' || item.tipo === 'Senha Preferencial';
          });

          // Ordena os dados por data de forma decrescente
          pacientes.sort(function (a, b) {
            return new Date(b.data) - new Date(a.data);
          });

          senhas.sort(function (a, b) {
            return new Date(b.datahora) - new Date(a.datahora);
          });

          // Pega apenas os 4 primeiros itens de 'paciente-card' e 'chamadas1'
          var ultimosPacientes = pacientes.slice(0, 1);
          var ultimasSenhas = senhas.slice(0, 1);

          // Preenche os cards com os dados 'paciente-card' e 'chamadas1'
          preencherCards(ultimosPacientes, 'pacientes');
          preencherCards(ultimasSenhas, 'chamadas1');

          // Pega o restante dos dados, excluindo os 8 itens já exibidos
          var restanteDados = data.filter(function (item) {
            return !ultimosPacientes.includes(item) && !ultimasSenhas.includes(item);
          });

          // Ordena o restante dos dados por data de forma crescente
          restanteDados.sort(function (a, b) {
            return new Date(a.data || a.datahora) - new Date(b.data || b.datahora);
          });

          // Preenche os cards com os 5 primeiros do restante dos dados
          preencherRestanteDados(restanteDados.slice(0, 5));
        },
        error: function () {
          console.error('Erro ao carregar os dados do banco de dados.');
        }
      });
    }

    // Função para preencher os cards com os dados do banco de dados
    function preencherCards(data, containerId) {
      var container = $('#' + containerId);
      container.empty(); // Limpa o conteúdo atual

      // Itera sobre os dados e cria os cards
      $.each(data, function (index, item) {
        var card = $('<div>').addClass(containerId === 'pacientes' ? 'paciente-card' : 'chamada');
        if (containerId === 'pacientes') {
          card.append('<strong></strong> ' + item.nome + '<br>');
          card.append('<strong></strong> ' + item.local);
        } else {
          card.append('<span>' + item.tipo + '</span><br>');
          card.append('<span>' + item.nome + '</span><br>');
          card.append('<span>' + item.local + '</span><br>');
        }
        container.append(card);
      });
    }

    // Função para preencher o restante dos dados
    function preencherRestanteDados(data) {
      var historicoDiv = $('.historico');
      historicoDiv.empty(); // Limpa o conteúdo atual

      // Itera sobre os dados restantes e cria os cards
      $.each(data, function (index, item) {
        var card = $('<div>');

        if (item.tipo === 'Paciente') {
          card.addClass('paciente-card');
          card.append('<strong></strong> ' + item.nome + '<br>');
          card.append('<strong></strong> ' + item.local);
        } else {
          card.addClass('chamada');
          card.append('<span>' + item.tipo + '</span><br>');
          card.append('<span>' + item.nome + '</span><br>');
          card.append('<span>' + item.local + '</span><br>');
        }

        historicoDiv.append(card);

        // Verifica se já foram exibidos 5 itens
        if (index >= 4) {
          return false; // Encerra o loop após 5 itens
        }
      });
    }

    // Chama a função para carregar os dados ao carregar a página
    carregarDados();
            // Define o intervalo para chamar a função carregarDados a cada 4 segundos
            setInterval(carregarDados, 4000);
  });