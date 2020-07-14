 
 //EXPRESS INVOKE
 const express = require('express')
 const app = express();
 const handlebars = require('express-handlebars')
 const bodyParser = require('body-parser')


//DB CONNECT
const sequelize = require('sequelize');
const dbConnect = new sequelize('register_system', 'root', 'pl97608187', {
host: 'localhost',
dialect: 'mysql'
})

//CONFIGURING TEMPLATE ENGINE
app.engine('handlebars', handlebars({defaultLayout: 'main'}))
app.set('view engine','handlebars')

//CONFIGURING BODY PARSER
app.use(bodyParser.urlencoded({extended: false}))
app.use(bodyParser.json())

 //ROUTE
 app.get('/regpost', function(req,res){
     res.render(__dirname + '/views/form')
 })

 app.post('/posting', function(req, res) {
     res.send('Form receveid. Text: ' + req.body.title + ' Content: ' + req.body.content)
 })

 app.listen(8082, function(){
     console.log('Server running.')
 })