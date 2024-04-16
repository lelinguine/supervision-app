async function getConnect() {
    const requestData = {
        identifiant: $('#identifiant').val(),
        password: $('#password').val()
    };

    try {
        const response = await $.ajax({
            url: apiUrl + "/connect",
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(requestData),
        });

        if (response && response.token) {
            setCookie('token', response.token, 7);
            window.location.href = 'view/';
        } else {
        }
    } catch (error) {
    }
}