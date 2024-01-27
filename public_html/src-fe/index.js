// src/index.js

import SimpleAjax from "./App/Core/SimpleAjax";

const apiUrl = 'https://jsonplaceholder.typicode.com/todos/1';

SimpleAjax.get(apiUrl)
    .then((data) => {
        console.log('GET Success:', data);
    })
    .catch((error) => {
        console.error('GET Error:', error);
    });