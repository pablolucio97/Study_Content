
//CONNECTING TO MYSQL, DB 'register_system'
const sequelize = require('sequelize')
const dbConnect = new sequelize('register_system', 'root', 'pl97608187', {
    host: 'localhost',
    dialect: 'mysql'
})


//VERIFYING IF THE CONNECT RUN WITH SUCCESS
dbConnect.authenticate().then(function(){
    console.log('Success')
}).catch(function(error){
    console.log('Error' + error)
})
