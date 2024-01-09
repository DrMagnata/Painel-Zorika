document.addEventListener("DOMContentLoaded", function () {
    // Função para carregar os dados do banco de dados
    function carregarDados() {
      $.ajax({
        url: 'php/consulta.php',
        type: 'GET',
        dataType: 'json',
        success: function (data) {
          // Filtra os dados para incluir apenas os do tipo 'paciente'
          var pacientes = data.filter(function (item) {
            return item.tipo === 'Paciente';
          });

          // Ordena os dados por data de forma decrescente
          pacientes.sort(function (a, b) {
            return new Date(b.data) - new Date(a.data);
          });

          // Pega apenas os 4 primeiros itens
          var ultimos4Pacientes = pacientes.slice(0, 1);

          // Preenche os cards com os dados do banco de dados
          preencherCards(ultimos4Pacientes);
        },
        error: function () {
          console.error('Erro ao carregar os dados do banco de dados.');
        }
      });
    }

    // Função para preencher os cards com os dados do banco de dados
    function preencherCards(data) {
      var pacientesDiv = $('#pacientes');
      pacientesDiv.empty(); // Limpa o conteúdo atual

      // Itera sobre os dados e cria os cards
      $.each(data, function (index, item) {
        var pacienteCard = $('<div>').addClass('paciente-card');
        pacienteCard.append('<strong></strong> ' + item.nome + '<br>');
        pacienteCard.append('<strong></strong> ' + item.local);
        pacientesDiv.append(pacienteCard);
      });


    }

    // Chama a função para carregar os dados ao carregar a página
    carregarDados();

        // Define o intervalo para chamar a função carregarDados a cada 4 segundos
        setInterval(carregarDados, 4000);
  });