
/*$(window).load(function(){
 
    
    
});*/

$(document).ready(function(){
    
    $("#empresas-atuais").hide();
    
    $("#empresas-cadastradas").hide();
    
    /*$("#associacoes").change(function(){

        $("#lista-empresas").show();

    });*/
    
});

function getData() {
    
    var value = $("#sel1").val();
    //console.log(opcao);
    //alert(opcao);
    
    if (value == 'A'){
        $("#empresas-atuais").hide();
        $("#empresas-cadastradas").hide();
    }
    else if (value == 'B'){
        $("#empresas-cadastradas").show();
        $("#empresas-atuais").hide();
    }
    else if (value == 'C'){
        $("#empresas-atuais").show();
        $("#empresas-cadastradas").hide();
    }
        
}





