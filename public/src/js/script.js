$(document).ready(() => {
    //home
    $("#home").on('click',()=>{
        $.post('src/pages/home.phtml',(data)=>{
            $("#pagina").html(data);
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
    $.post('src/dados.php',(data)=>{
        $info = JSON.parse(data)
        $("#numero_vendas").html($info.numeroVendas);
        $("#total_vendas").html($info.totalVendas);
    })
})