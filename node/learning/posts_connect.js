var sequelize = require('sequelize');
var dbConnect = new sequelize('postapp', 'root', 'pl97608187',
{
    host: 'localhost',
    dialect: 'mysql'
}
)

module.exports = {
    sequelize: sequelize,
    dbConnect: dbConnect
}
