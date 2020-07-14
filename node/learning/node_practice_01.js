//EXPRESS INVOKE
var express = require('express')
var app = express();
var handlebars = require('express-handlebars')

//DB CONNECT
var sequelize = require('sequelize');
var dbConnect = new sequelize('register_system', 'root', 'pl97608187',
    {
        host: 'localhost',
        dialect: 'mysql'
    }
)


//ENGINE HANDLEBARS SETUP
app.engine('handlebars', handlebars({defaultLayout: 'main'}))
app.set('view engine', 'handlebars')




//RENDERING FORM
app.get('/send', function(req, res) {
    res.render(__dirname + '/views/form')
})

//MSG CALL BACK
app.post('/posted', function(req, res){
    res.send('Data received')
})



app.listen(8083, function(){
    console.log('Server running on the 8083 door.')
})


