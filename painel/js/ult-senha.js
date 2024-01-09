document.addEventListener("DOMContentLoaded", function () {
    // Função para carregar os dados do banco de dados
    function carregarSenhas() {
      $.ajax({
        url: 'php/consulta.php', 
        type: 'GET',
        dataType: 'json',
        success: function (data) {
          // Filtra os dados para incluir apenas senhas comuns e preferenciais
          var senhas = data.filter(function (item) {
            return item.tipo === 'Senha Comum' || item.tipo === 'Senha Preferencial';
          });

          // Ordena os dados por data de forma decrescente
          senhas.sort(function (a, b) {
            return new Date(b.datahora) - new Date(a.datahora);
          });

          // Pega apenas a última senhas
          var ultimas1Senhas = senhas.slice(0, 1);

          preencherSenhas(ultimas1Senhas);
        },
        error: function () {
          console.error('Erro ao carregar os dados do banco de dados.');
        }
      });
    }

    // Função para preencher os cards com os dados do banco de dados
    function preencherSenhas(data) {
      var chamadasDiv = $('#chamadas1');
      chamadasDiv.empty(); // Limpa o conteúdo atual

      // Itera sobre os dados e cria os cards
      $.each(data, function (index, item) {
        var chamadaCard = $('<div>').addClass('chamada');
        chamadaCard.append('<span>' + item.tipo + '</span><br>');
        chamadaCard.append('<span>' + item.nome + '</span><br>');
        chamadaCard.append('<span>' + item.local + '</span><br>');
        chamadasDiv.append(chamadaCard);
      });
    }

    // Chama a função para carregar os dados ao carregar a página
    carregarSenhas();

            // Define o intervalo para chamar a função carregarDados a cada 4 segundos
            setInterval(carregarDados, 4000);
  });