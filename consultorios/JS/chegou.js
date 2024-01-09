async function chegou(id) {
    try {
        const response = await fetch('cons2.php', { 
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