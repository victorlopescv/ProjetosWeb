var altura=0
var largura=0
var vida = 1
var tempo = 15
var clicados = 0
var criaMosquitoTempo=1500

// recupera o link da pagina, porem o search ao contrario do href, recupera apenas o que esta depois da ? inclusive a ?
var nivel = window.location.search
// . replace funciona da seguinte forma: localizada o primeiro item no caso '?' da string e substitui pelo segundo no caso '' vazio
nivel = nivel.replace('?','')

if (nivel==='normal') {
	criaMosquitoTempo = 1500
}else if(nivel==='dificil'){
	criaMosquitoTempo = 1000
}else if (nivel==='chucknorris') {
	criaMosquitoTempo = 750
}

function ajustaTamanhoPalcoJogo(){
 	altura = window.innerHeight
	largura = window.innerWidth
	console.log(largura, altura )
}

ajustaTamanhoPalcoJogo()


var cronometro = setInterval(function(){
		
	if (tempo < 0) {
			clearInterval(cronometro)
			clearInterval(criaMosquito)
			window.location.href = 'vitoria.html'

	}else{
		
		document.getElementById('contagem').innerHTML = tempo
		tempo -=1
		
		}
},1000)



function posicaoRandomicaMosquito(){


//remover elemento mosquito anterior e game over	
//caso esse elemento não exista ira dar um erro, portanto vamos verificar 
if (document.getElementById('mosquito')) {


	if (vida>3) {
	window.location.href ='fim_de_jogo.html'
}else{
document.getElementById('v' + vida).src = 'imagens/coracao_vazio.png'
document.getElementById('mosquito').remove()
vida++;
}
}




var posicaoX =  Math.floor(Math.random() * largura) - 90
var posicaoY =  Math.floor(Math.random() * altura) - 90

posicaoX = posicaoX < 0 ? 0 : posicaoX
posicaoY = posicaoY < 0 ? 0 : posicaoY


console.log(posicaoX,posicaoY)

//criar o elemento html
var mosquito = document.createElement('img')
mosquito.src = 'imagens/mosquito.png'
mosquito.className = tamanhoAleatorio() + ' ' + ladoAleatorio()
mosquito.style.left = posicaoX +'px'
mosquito.style.top= posicaoY +'px'
mosquito.style.position = 'absolute'
mosquito.id = 'mosquito'
mosquito.onclick = function() {
	this.remove()
	clicados++;
	document.getElementById('mortos').innerHTML=clicados
}

document.body.appendChild (mosquito) 
}


function tamanhoAleatorio(){
	
	var classe = Math.floor(Math.random() * 3)

	switch (classe){
		case 0:
		return 'mosquito1'
		
		case 1:
		return 'mosquito2'
		
		case 2: 
		return 'mosquito3'
	}
}

function ladoAleatorio(){

	var lado = Math.floor(Math.random()* 2)
	
	switch(lado){
		case 0:
		return 'ladoA'

		case 1:
		return 'ladoB'
	}

}

