require('dotenv').config()

const express = require('express')
const cookieParser = require('cookie-parser')
const fs = require('fs')

const visiter = require('./visiter');

// Starting Express and Midlewares
const app = express();

app.use(cookieParser())
app.use(express.json());
app.use(express.static('public'));

// Example Blog Post
app.get(`/blog/diario-viajante-ep7`, function(req, res) { 
    let html = fs.readFileSync('./public/blog-post.html', 'utf8')

    const nome = (req.query.nome) ? req.query.nome : "Usuário Anônimo"
    const comentario = (req.query.comentario) ? req.query.comentario : "Poucas palavras..."

    if(req.query.nome || req.query.comentario) { 
        const comentarioHtml = 
        `<div class="post-comment mb-3">
            <h6>${nome}</h6>
            <div class="meta"><span class="date">Publicado hoje</span></div>
            <p>${comentario}</p>
        </div>`
        html = html.replace('<!--NOVO-COMENTARIO-->', comentarioHtml)
    }

    res.setHeader('Content-Type', 'text/html')
    return res.send(Buffer.from(html))
})

// Set admin bot to visit the blog url
app.post(`/visit`, async function(req, res) { 

    const targetUrl = req.body.target 
    const serverOrigin = process.env.SERVER_URL || 'http://localhost:3333/'
    
    if(!targetUrl || !targetUrl.startsWith(serverOrigin)){
        return res.status(400).json({'message': 'Link inválido!'})
    }

    await visiter.visit(targetUrl);
    
    return res.json({'message': 'Link enviado ao administrador!'})
})

// Printing configurations
console.log(`Starting server at ${process.env.SERVER_PORT || 3333}`)
console.log(`Server url set as ${process.env.SERVER_URL || 'http://localhost:3333/'}`)
console.log(`Cookie domain set as ${process.env.SERVER_DOMAIN || 'localhost'}`)
console.log(`Flag is ${process.env.FLAG || 'flag{admin_s3cr3t_l0l}'}`)

// Starting Express Server
app.listen(process.env.SERVER_PORT || 3333, '0.0.0.0');