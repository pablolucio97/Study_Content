
//CONNECTING TO DB
const sequelize = require('sequelize')
const dbConnect = new sequelize('register_system', 'root', 'pl97608187', {
    host: 'localhost',
    dialect: 'mysql'
})

//TESTING CONNECTION
dbConnect.authenticate().then(function(){
    console.log('Success')
}).catch(function(error){
    console.log('Error' + error)
})

//CREATING A MODEL/TABLE (with name post)
const post = dbConnect.define('posts', {
    title: {
        type: sequelize.STRING
    },
    content: {
        type: sequelize.TEXT
    }
})

//CREATING A NEW ITEM FOR THE MODEL/TABLE

post.create({
    title: 'My title',
    content: 'This is my main content.'
})