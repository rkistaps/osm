export default class AjaxClient {
    static get(url) {
        return new Promise((resolve, reject) => {
            this.makeRequest(url, 'GET', null, resolve, reject);
        });
    }

    static post(url, data) {
        return new Promise((resolve, reject) => {
            this.makeRequest(url, 'POST', data, resolve, reject);
        });
    }

    static makeRequest(url, method, data, successCallback, errorCallback) {
        const xhr = new XMLHttpRequest();
        xhr.open(method, url, true);

        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    successCallback(JSON.parse(xhr.responseText));
                } else {
                    errorCallback(xhr.statusText);
                }
            }
        };

        if (method === 'POST') {
            xhr.setRequestHeader('Content-Type', 'application/json');
        }

        xhr.send(data ? JSON.stringify(data) : null);
    }
}
