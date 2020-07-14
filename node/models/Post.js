const db = require('./db')
const postApp = db.dbConnect.define('posts', {
    title: {
        type: db.sequelize.STRING
    },
    content: {
        type: db.sequelize.TEXT
    }
})

module.exports = postApp;