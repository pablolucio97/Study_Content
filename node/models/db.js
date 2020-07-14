const sequelize = require('sequelize')

//CREATING DB CONNECT
const dbConnect = new sequelize('postapp', 'root', 'pl97608187', {
    host: 'localhost',
    dialect: 'mysql'
})

module.exports = {
    sequelize: sequelize,
    dbConnect: dbConnect
}