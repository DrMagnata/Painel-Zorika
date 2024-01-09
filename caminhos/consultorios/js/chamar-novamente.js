async function chamarNovamente(id) {
    try {
        const response = await fetch('', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `action=chamarNovamente&id=${id}`,
        });

        const result = await response.text();
        console.log(result);

    } catch (error) {
        console.error('Erro ao chamar novamente:', error);
    }
}