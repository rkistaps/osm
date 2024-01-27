// src/index.js

import SimpleAjax from "./App/Core/SimpleAjax";

const apiUrl = 'https://jsonplaceholder.typicode.com';

const data = {
    'some': 'cool',
    'some2': 'coo2l',
};

console.log('coool');

SimpleAjax.get(apiUrl)
    .then((data) => {
        console.log('GET Success:', data);
    })
    .catch((error) => {
        console.error('GET Error:', error);
    });