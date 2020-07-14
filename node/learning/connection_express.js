const express = require('express');
const app = express();

app.get('/', function(req, res){
    res.send('Connection already.')
})

app.get('/home', function(req, res){
    res.send('Welcome to home')
})

app.get('/about', function(req, res){
    res.send('Welcome to about')
})

app.get('/contact', function(req, res){
    res.send('Welcome to contact')
})

app.listen(8086, function(){
    console.log('Server running.')
});