$(document).ready(() => {
	
/*             ****JQUERY load()/get()/post()

		*** .load('url/caminho')
		load no JQuery encapsula todo o conteudo de XMLHttpRequest() do JavaScript (AJAX/requisicoes_assincrona.html) , fazendo que fique mais pratico e agil
		
			$('#pagina').load('documentacao.html')
			

		*** get()	
		$.('url' , funcao callback que retornar o conteudo)
		$.get() --> mesmo que laod porem passando paratmetros que sao exibidos na url
		
		$.get('documentacao.html', data => {
			console.log(data)
			$('#pagina').html(data)
		})

		*** post()
		$.post()--> mesmo que laod e post porem passando paratmetros que NAO são exibidos na url
		
		$.post('documentacao.html', data => {
			console.log(data)
			$('#pagina').html(data)
		})
*/
	$('#documentacao').on('click' , () => {

		$.post('documentacao.html', data => {
			$('#pagina').html(data)
		})		
	})

	$('#suporte').on('click' , () => {

		$.post('suporte.html' , data  => {
			$('#pagina').html(data)
		})
	})

	//ajax
	$('#competencia').on('change', e => {
		
		let competencia = $(e.target).val()

		$.ajax({ 
			type: 'GET', //metodo
			url: 'app.php', //url
			data: `competencia=${competencia}`, //dado - urlencode => atributos a direita, valores a esquerda do '=' VALOR GET OU POST
			dataType: 'json', //o retorno desta requisição é enviada em html puro ou seja text, com esse configuração recebemos um json obj literal
			success: dados => {
				//console.log(dados) //dados é  string retornada de app.php que representa o arquivo json obj literal 
			$('#numeroVendas').html(dados.numeroVendas)
			$('#totalVendas').html(dados.totalVendas)
			$('#clientesAtivos').html(dados.clientesAtivos)
			$('#clientesInativos').html(dados.clientesInativos)
			$('#totalCriticas').html(dados.totalCriticas)
			$('#totalElogios').html(dados.totalElogios)
			$('#totalSugestao').html(dados.totalSugestao)
			$('#totalDespesas').html(dados.totalDespesas)
			}, //sucesso
			error: erro => {console.log(erro)} //erro 
		 })

		


	})


}) //.ready()