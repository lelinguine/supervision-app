async function getMeasure() {
    const requestData = {
        token: getCookie('token')
    };

    try {
        const response = await $.ajax({
            url: apiUrl + "/son",
            type: 'POST',
            dataType: 'json',
            contentType: 'application/json',
            data: JSON.stringify(requestData)
        });

        if (response) {
            return response.valeur;
        } else {
            console.error('Erreur lors de la r�ception des donn�es');
        }
    } catch (error) {
        console.error('Erreur lors de la requ�te POST:', error.message);
    }
}

getMeasure();