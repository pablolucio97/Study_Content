const express = require('express')
const app = express();
const bodyParser = require('body-parser')
const handlebars = require('express-handlebars')

//CONNECTING TO DB
const sequelize = require('sequelize')
const dbConnect = new sequelize('register_system', 'root', 'pl97608187', {
    host: 'localhost',
    dialect: 'mysql'
})



//CONFIG
//TEMPLATE ENGINE
app.engine('handlebars', handlebars({defaultLayout: 'main'}))
app.set('view engine', 'handlebars')

//BODY PARSER
app.use(bodyParser.urlencoded({extended: false}))
app.use(bodyParser.json())

//ROUTES
app.get('/home', function(req, res){
    res.render('form')
})

app.post('/add', function(req, res){
    res.send("Title: " + req.body.title + 
    ' Content: ' + req.body.content)
})

app.listen(8088, function(){
    console.log('Server running.')
})
