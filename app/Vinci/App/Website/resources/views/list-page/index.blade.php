<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <link rel="shortcut icon" href="/assets/imagens/icons/favicon.ico" type="image/x-icon">
  <title>Índice de páginas « Vinci</title>
  <script type="text/javascript" src="assets/js/jquery-1.9.1.min.js"></script>
</head>
<body>
  <style>
    body,html{width: 100%;height:100%;}
    body{overflow-y:hidden;}
    * {margin:0 auto;padding:0;text-decoration: none;font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;
    box-sizing:border-box;
    -webkit-box-sizing:border-box;
    -moz-box-sizing:border-box;
    -ms-box-sizing:border-box;
    -o-box-sizing:border-box;
  }
  ul {overflow:hidden; }
  ul li {list-style: none;float:left;width:38%;font-size:13px;text-align: left;position: relative}
  ul.ok li a {width: 100%;display:block;}
  ul li a:link:hover{text-decoration: underline;}
  ul li a:link {color:#3e3e3e;font-weight:bold;text-decoration:none;}
  ul li a:visited{color:#3e3e3e;}
  ul.ok li a:hover {color:#173081;}
  ul.ok li {font-size:16px;}
  /*ul.head {position: fixed;top:0;}*/
  ul li+li {width:8%;text-align:center;font-size:13px;}
  ul li+li+li {width:40%;} 
  ul li+li+li+li {width:40%;font-size:13px;} 
  ul li.linha {clear:both;overflow:hidden;width:100%;}
  ul.head,ul.modulo{width:100%;z-index: 9}
  ul.head{background:#16b1ef;padding:10px 20px;color:#fff;}
  ul.modulo{background:#e9e9e9;padding:10px 30px;color:#5e5e5e;}
  ul.head li {font-size: 14px}
  ul li li+li {border-left:1px solid #b7b7b7;color:#5e5e5e;font-weight:bold;}
  ul ul li+li+li+li {text-align:left;padding:0 2%;font-size:12px!important;}
  ul.ok li a {font-size: 16px;color:#4960af;text-decoration:underline;}
  ul ul {padding:7px 20px 7px 40px;border-top:1px solid #ddd;}
  ul.ok {background:#fff;}
  ul {background:#f1f1f1;}
  .logo {background:#fff url(/public/assets/imagens/logos/logo-footer.png) no-repeat 20px center;width:100%;height:100px;padding:15px 0;}
  .logo p{font-size:30px; color:#16b1ef;margin-left: 40px;}
  li.concluido {background:url('http://www.webeleven.com.br/homolog/img_ok.png') 90% 50% no-repeat;background-size:13%;}
  /*icon-github*/
  .icon-github{position: absolute;bottom:20px;right:20px;}
  .icon-github img{width:40px;height:40px;opacity: 0.4;}
  .icon-github:hover img{opacity: 1;}
</style>
<div class="logo"><p>Vinci</p></div>

<ul class="head">
 <li>Nome da página</li>
<!--         <li>Status</li>
  <li>Comentários</li>  -->
</ul>
<ul>
	<!-- Links Pages -->
  <li class="linha">
   <ul>
    <li><a href="/" target="_blank">Home</a></li>
    <li>V1</li>
    <li></li>
  </ul>
  <ul>
    <li><a href="/categoria" target="_blank">Categoria</a></li>
    <li>V1</li>
    <li></li>
  </ul>
  <ul>
    <li><a href="/busca" target="_blank">Resultado de Busca</a></li>
    <li>V1</li>
    <li></li>
  </ul>

  <ul>
    <li><a href="/cadastro" target="_blank">Cadastro</a></li>
    <li>V2</li>
    <li></li>
  </ul>

  <ul>
    <li><a href="/produto" target="_blank">Produto</a></li>
    <li>V1</li>
    <li></li>
  </ul>
  <ul>
    <li><a href="/carrinho" target="_blank">Carrinho</a></li>
    <li>V2</li>
    <li></li>
  </ul> 

  <ul>
    <li><a href="/entrega" target="_blank">Entrega</a></li>
    <li>V2</li>
    <li></li>
  </ul> 
  <ul>
    <li><a href="/pagamento" target="_blank">Pagamento</a></li>
    <li>V2</li>
    <li></li>
  </ul> 
  <ul>
  <li><a href="/confirmacao" target="_blank">Confirmação</a></li>
    <li>V2</li>
    <li></li>
  </ul> 
</li>
</ul>

<!--     <div class="icon-github">
        <a href="#" target="_blank" title="Ir para o Repositório no Github">
            <img src="#" title="Ir para o Repositório no Github" alt="Imagem Icon Github">
        </a>
      </div> -->
      <script type="text/javascript">
        $(document).ready(function() {
          $(".v100").each(function() {
            if( $(this).text() == '100%' ){
              $(this).addClass('concluido');
              $(this).parent("ul").addClass('ok');
            } 
          });  
          $(".linha ul").each(function() {
            if( $(this).is(":first-child") && $(this).find("a").attr("href")=="") {
              $(this).find("a").removeAttr("href", "");
            }

          });
//  $(".linha ul").each(function() {
//         if($(this).is(":first-child") && !$(this).hasClass("ok")) {
//             $(this).find("a").removeAttr("href", "");
//         }

// });
$(window).scroll(function() {

  if ($(window).scrollTop() <= 95) {

    $(".head").css('position','relative');
  } else {

    $(".head").css('position','fixed').css('top','0');
  }
});
});
</script>
</body>
</html>