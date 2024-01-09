$(document).ready(function() {
    // Delegação de eventos para preservar os eventos dos botões
    $('#tabela-espera').on('click', 'button', function() {
        var id = $(this).closest('tr').data('id');
        var selectedLocal = $('#local').val();

        if (selectedLocal === '#') {
            alert('Por Gentileza, Escolha Adequadamente o local');
            return;
        }

        var action = $(this).data('action');
        handleButtonClick(id, action);
    });

    function handleButtonClick(id, action) {
        var selectedLocal = $('#local').val();

        if (selectedLocal === '#') {
            alert('Por Gentileza, Escolha Adequadamente o local');
            return;
        }

        if (action === 'chamar') {
            $.ajax({
                type: 'POST',
                url: 'php/chamar.php',
                data: { id: id, local: selectedLocal },
                success: function (response) {
                    console.log('Inserção realizada com sucesso:', response);
                    updateTable();
                }
            });
        }

        $.ajax({
            type: 'POST',
            url: 'php/atualizar_dados.php', 
            data: { id: id, action: action },
            success: function (response) {
                var rowSelector = '#tabela-espera tr[data-id="' + id + '"]';
                var row = $(rowSelector);

                row.find('.status-cell').html(response);

                // Adicione mais linhas conforme necessário para outras células que precisam ser atualizadas

                row.find('td').addClass('sua-classe'); 
            }
        });
    }

    function updateTable() {
        $.ajax({
            type: 'GET',
            url: 'php/atualizar_dados.php', 
            success: function (response) {
                $('#tabela-espera').html(response);
            }
        });
    }

    function handleAutoUpdate() {
        setInterval(updateTable, 4000);
    }

    handleAutoUpdate();
});