var express = require('express')
var app = express()
var path = require('path'); 
// app.get('/', function (req, res) {
//   res.send('Hello World')
// })

app.use(express.static(path.join(__dirname, '../server')));
app.listen(80);