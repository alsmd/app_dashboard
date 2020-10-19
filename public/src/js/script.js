$(document).ready(() => {
    //home
    $("#home").on('click',()=>{
        $.post('src/pages/home.phtml',(data)=>{
            $("#pagina").html(data);
            inserindoDados()
        })
    })
    $('#home').trigger('click');

    //documentacao
    $("#documentacao").on('click',()=>{
        $.post('src/pages/documentacao.phtml',(data)=>{
            $("#pagina").html(data);
        })
    })
    //suporte
    $("#suporte").on('click',()=>{
        $.post('src/pages/suporte.phtml',(data)=>{
            $("#pagina").html(data);
        })
    })
    //Inserindo informações no Dash
    function inserindoDados(){
        $("#competencia").on('change',function(e){
            let data = $(e.target).val()
            //recupera os dados
            let $dados = $.ajax({
                type: 'POST',
                url: 'src/dados.php',
                data: 'competencia='+data, //x-www-form-urlencoded
                dataType: 'json',
                success: (success)=>{ console.log(success)},
                error:  (erro)=>{ console.log(erro)}

            })
            //metodo, url, dados, sucesso,erro
            //renderiza os dados na tela
            $dados.then((d)=>{
                let $info = JSON.parse(d);
                $("#numero_vendas").html($info.numeroVendas);
                $("#total_vendas").html($info.totalVendas);
                $("#clientes_ativos").html($info.clientes_ativos);
                $("#clientes_inativos").html($info.clientes_inativos);
            })
        })
        $("#competencia").trigger("change");

    }
    

    

})