//animçao para menus de senha

function configuraCampoSenha(nome, eyeName){
  var senha = $(`#${nome}`);
  var olho= $(`#${eyeName}`);
  var olhoDocument = document.getElementById(eyeName);
  var inputDocument = document.getElementById(nome);

  olhoDocument.onclick = (function() {
    if(inputDocument.type == "password"){
      olhoDocument.className = "fa fa-eye olho posicaoOlho";
      senha.attr("type", "text");
    }
    else{
      olhoDocument.className = "fa fa-eye-slash olho posicaoOlho"
      senha.attr("type", "password");
    }
  });
}
