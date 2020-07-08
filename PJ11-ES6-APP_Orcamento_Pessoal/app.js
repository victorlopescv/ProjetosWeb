
// classe que as funcoes chamao
class Despesa{
	constructor(ano,mes,dia,tipo,descricao,valor){
		this.ano=ano
		this.mes=mes
		this.dia=dia
		this.tipo=tipo
		this.descricao=descricao
		this.valor=valor
	}

	validarDados(){
		for(let i in this){
			if(this[i]==undefined || this[i]=='' || this[i]==null){
				return false
			}
		}
		return true
	}
}

class Bd {

	constructor(){
		let id = localStorage.getItem('id')
		if (id === null) {
			localStorage.setItem('id',0)
		}
	}

	getProximoId(){

		let proximoId = localStorage.getItem('id')
		return parseInt(proximoId)+1 

	}

	gravar(d){
		let id = this.getProximoId()

		localStorage.setItem(id,JSON.stringify(d))

		localStorage.setItem('id',id)
	}

	recuperarTodosRegistros(){
		//criadno array despesas para alocar todas as depesa
		let despesas = []
		//recuperando ultimo ID para colocar limite no laço de repetição
		let id = localStorage.getItem('id')
		//criando laço de repeticao que recupera todos id dentro do localStorage
		for(let i = 1 ; i <= id ; i++){
			let despesa = JSON.parse(localStorage.getItem(i)) // recuperando o valor da id 1 até ultima id transforamando JSON (string) para objeto Literal
			
			// verifica se a despesa recuperada do local storage foi removida, caso sim, não ira realizar o push, 
			//pois continue significa pular toda logica abaixo e voltar a repitação no inicio ignorando o codigo abaixo
			if(despesa === null){ 
				continue
			}	

			despesa.id = i
			despesas.push(despesa) // inserindo na ultima posição do array despesas as despesas cadastradas
			
		}
		return despesas // retorna o Array com todas as despesas para função que chamou o metodo
	}

	pesquisar(despesa){
		
		let despesasFiltradas = []
        despesasFiltradas = this.recuperarTodosRegistros()

		//ano
		if(despesa.ano != ''){
				despesasFiltradas=despesasFiltradas.filter(f => f.ano == despesa.ano)
			}
		//mes
		if(despesa.mes != ''){
				despesasFiltradas=despesasFiltradas.filter(f => f.mes == despesa.mes)
			}
		//dia
		if(despesa.dia != ''){
				despesasFiltradas=despesasFiltradas.filter(f => f.dia == despesa.dia)
			}
		//tipo
		if(despesa.tipo != ''){
				despesasFiltradas=despesasFiltradas.filter(f => f.tipo == despesa.tipo)
			}
		//descricao
		if(despesa.descricao != ''){
				despesasFiltradas=despesasFiltradas.filter(f => f.descricao == despesa.descricao)
			}
		//valor
		if(despesa.valor != ''){
				despesasFiltradas=despesasFiltradas.filter(f => f.valor == despesa.valor)
			}
			return despesasFiltradas
	}

	remover(id){
		localStorage.removeItem(id)
		window.location.reload()
	}

}

let bd = new Bd()


//onclick no botao + no index.html para cadastrar novas despesas
function cadastrarDespesas(){

	let ano = document.getElementById('ano')
	let mes = document.getElementById('mes')
	let dia = document.getElementById('dia')
	let tipo = document.getElementById('tipo')
	let descricao = document.getElementById('descricao')
	let valor = document.getElementById('valor')
	let despesa = new Despesa(ano.value,mes.value,dia.value,tipo.value,descricao.value,valor.value)	


	if(despesa.validarDados()){
		bd.gravar(despesa)

		//ajustando o modal de forma dinamica
		document.getElementById('modal_titulo_div').className = 'modal-header text-success'
		document.getElementById('modal_titulo').innerHTML = ' Registro inserido com sucesso'
		document.getElementById('modal_conteudo').innerHTML = 'Despesa foi cadastrada com sucesso'
		document.getElementById('modal_btn').innerHTML = 'Voltar'
		document.getElementById('modal_btn').className = 'btn btn-success'
		$('#modalRegistraDespesa').modal('show') // framework jquery

		//limpar os campos após gravação
		ano.value=''
		mes.value=''
		dia.value=''
		tipo.value=''
		descricao.value=''
		valor.value= ''
		
	}else{
		document.getElementById('modal_titulo_div').className = 'modal-header text-danger'
		document.getElementById('modal_titulo').innerHTML = 'Erro na inclusão do registro'
		document.getElementById('modal_conteudo').innerHTML = 'Erro na gravação, verifique se todos os campos foram preenchidos corretamente!'
		document.getElementById('modal_btn').innerHTML = 'Voltar e corrigir'
		document.getElementById('modal_btn').className = 'btn btn-danger'
		$('#modalRegistraDespesa').modal('show')
	} 
}

//Mostrar lista despesas filtradas e não filtradas)
//onload ao carregar body da pagina consulta.html ou onclick atraves da funcao pesquisarDespesa()
function carregaListaDespesas(despesas = Array(), filtro = false){

	//criando um array para receber o array despesas do metodo recuperarTodosRegistros
	if (despesas.length == 0 && filtro == false) {
	despesas = bd.recuperarTodosRegistros() // inserindo o array despesas do metodo recuperarTodosRegistros dentro 
	}
										//do array despesas criado na funcao carregaListaDespesas
    //recuperando o tbody 
    let listaDespesas = document.getElementById('listaDespesas')	
    listaDespesas.innerHTML = ''										

    //forEach pega cada elemento da sua posição ordenada e executa a logica para cada elemento
    despesas.forEach(function(d){ //d é o valor do objeto contido na indice atual
    	
    	//inserindo linha na tabela  de ID 'listaDespesas'
    	//criando linha (tr)
    	var linha = listaDespesas.insertRow()

    	//inserindo na nova linha uma coluna que vai receber dia mes e ano do array despesas 
    	//criando coluna (td)
    	linha.insertCell(0).innerHTML =`${d.dia}/${d.mes}/${d.ano}`
		
    	//ajustando tipo, pois ele é apresentado em valor numerico e temos que exibir em forma da string 
    	switch(d.tipo){    		
    		case '1': d.tipo = 'Alimentação'
    		break
    		case '2': d.tipo = 'Educação'
    		break
    		case '3': d.tipo = 'Lazer'
    		break
    		case '4': d.tipo = 'Saude'
    		break
    		case '5': d.tipo='Transporte'
    		break
    	}

    	//inserindo a coluna o valor de 'tipo' atualizada com seu respectivo valor
    	linha.insertCell(1).innerHTML = d.tipo
    	linha.insertCell(2).innerHTML = d.descricao
    	linha.insertCell(3).innerHTML = d.valor

    	let btn = document.createElement('button')
    	btn.className = 'btn btn-danger btn-sm'
    	btn.innerHTML= '<i class ="fas fa-times"></i>'
    	btn.id = `id_despesa_${d.id}`
    	btn.onclick = function(){
    	//recuperar valor , replace para apagar o id_despesa_
    	 let id = this.id.replace('id_despesa_','')

       		console.log(id)
       		bd.remover(id)
    	}

    	linha.insertCell(4).append(btn)
    	
       }) 
   
}


//onclick no icone da lupa em consulta.html
function pesquisarDespesa(){
	let ano = document.getElementById('ano').value
	let mes = document.getElementById('mes').value
	let dia = document.getElementById('dia').value
	let tipo = document.getElementById('tipo').value
	let descricao = document.getElementById('descricao').value
	let valor = document.getElementById('valor').value

	let despesa = new Despesa(ano,mes,dia,tipo,descricao,valor)

	
	let despesas = []
	despesas = bd.pesquisar(despesa)

	carregaListaDespesas(despesas,true)	

// inserindo um icone de voltar toda vez que for acionado o pesquisar
//o if estamos verificando se esse elemento ja existe, caso existe nao criaremos novamente
	if(document.getElementById('testado')===null){ //caso o resultado do get for Null é pq nao existe ainda
		var btn = document.createElement('button')
		btn.className='btn btn-primary ml-2'
		btn.id = 'testado'
		btn.onclick = function(){
		window.location.href = 'consulta.html'		
		}

		btn.innerHTML = '<i class="fas fa-undo"></i>'
				
		let div = document.getElementById('teste')
		div.append(btn)	

			}
			
			
 }	




