const express = require('express')
const app = express();

//TESTING TO RENDER A REACT FILE (FALLS)
app.get("/", function(req, res){
    res.sendFile(__dirname + '/test_send_react_file.js')
})

app.get('/:people/:job/:salary', function(req, res){
    res.send('Hello ' + req.params.people + ' your job is ' +
    req.params.job + ' and your salary is R$ ' + req.params.salary ) 
})

app.listen(8087, function(){
    console.log('Server running.')
})