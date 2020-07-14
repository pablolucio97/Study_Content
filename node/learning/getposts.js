//CONFIGURING TEMPLATE ENGINE
app.engine('handlebars', handlebars({defaultLayout: 'main'}))
app.set('view engine','handlebars')

app.get('/cad', function(req, res){
    res.render('form')
})

app.post('/add', function(req, res){
    post.create({
        title: req.body.title,
        content: req.body.content
    }).then(function(){
         res.send('All right.')
    }).catch(function(error){
        res.send('An error has ocrrued: ' + error)
    })
})

app.listen(8084, function(){
    console.log('All right. Server running.')
});