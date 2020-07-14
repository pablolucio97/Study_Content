const express = require('express');
const serverConnection = express();

serverConnection.get('/test', function(req, res){
  res.sendFile(__dirname + '/test_sendfile.html')
})

serverConnection.listen(8081);
