const db = require('./posts_connect')

const post = db.dbConnect.define('posts', {
    title: {
        type: db.sequelize.STRING
    },
    content: {
        type: db.sequelize.TEXT
    }
})

module.exports = post;