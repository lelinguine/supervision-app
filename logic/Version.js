async function getVersion() {

    try {
        const response = await $.ajax({
            url: apiUrl + "/version",
            type: 'GET',
            dataType: 'json'
        });

        if (response) {
            console.log('Service version', response.version);
        } else {
            console.error('Erreur lors de la récupération de la version');
        }
    } catch (error) {
        console.error('Erreur lors de la récupération de la version:', error.message);
    }
}

getVersion();