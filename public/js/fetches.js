//взял функцию из документации https://learn.javascript.ru/cookie
//я беру апи токен из куков

function getCookie(name) {
    let matches = document.cookie.match(new RegExp(
        "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
    ));
    return matches ? decodeURIComponent(matches[1]) : undefined;
}

export async function fetchCreateWorker(data) {
    return await fetch('/api/workers', {
        method: 'POST',
        headers: {
            'Content-type': 'application/json',
            'User-token-key': getCookie('token')
        },
        body: JSON.stringify(data),
    });
}

export async function fetchGetWorker(id) {
    return await fetch(`api/workers/${id}`, {
        method: 'GET',
        headers: {
            'Accept' : 'application/json',
            'User-token-key': getCookie('token')
        }
    });
}

export async function fetchUpdateWorker(id, data) {
    return await fetch(`/api/workers/${id}`, {
        method: 'PUT',
        headers: {
            'Content-type': 'application/json',
            'User-token-key': getCookie('token')
        },
        body: JSON.stringify(data),
    });
}

export async function fetchDeleteWorker(id) {
    return await fetch(`/api/workers/${id}`, {
        method: 'DELETE',
        headers: {
            'Accept' : 'application/json',
            'User-token-key': getCookie('token')
        }
    });
}