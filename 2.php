<?php include('c_chatbot.php');
 $hora = date('h');
 $dia = date('d');
 $sender  = $_POST["sender"];
 //$sender2 = limpar_texto($sender2);
 $t=mysql_query("SELECT * FROM clientes WHERE celular='$sender'");
 $r=mysql_num_rows($t);
 $f=mysql_fetch_assoc($t);
 $p=mysql_query("SELECT * FROM produtos");
 $pp=mysql_query("SELECT * FROM pedidos");
 $ppo=mysql_query("SELECT * FROM orcamentos");
 $pps=mysql_query("SELECT * FROM suportes");
 $cb=mysql_query("SELECT * FROM chatbot WHERE cliente='$sender'");
 $fcb=mysql_fetch_assoc($cb);
 $cpftwo=$fcb['cpf'];
 $rrcpf=mysql_query("SELECT * FROM clientes WHERE cpf='$cpftwo'");
 $rcpf=mysql_num_rows($rrcpf);
 $ecpf=mysql_fetch_assoc($rrcpf);
 $nome=$fcb['nome'];
 $status=$fcb['status'];
 $opcao=$fcb['opcao'];
 $status3m=$fcb['status2'];
 $status2=mysql_num_rows($cb);
 $message   = $_POST["message"];
$username = "adminxtreme";
$password = "badkill1";
	 //
	  //
	 if($status2 <= 0){//Pergunta 1
	 $reply = array("reply" => "Antes de começarmos, *Qual seu nome ❓*");
	 $upm=mysql_query("INSERT INTO chatbot (opcao, cliente, dia, hora) VALUES ('p1', '$sender', '$dia', '$hora')");
	 echo json_encode($reply);
	 }else if($opcao == "p1"){//Pergunta 2
	 $reply = array("reply" => "Você se chama *".$message."*, está correto ?\n Responda com *Sim* ou *Não*");
	 mysql_query("UPDATE chatbot SET nome='$message', opcao='p2' WHERE cliente='$sender'");
	 echo json_encode($reply);
	 }else if($message == "Não" && $opcao == "p2"){
	 $reply = array("reply" => "*Ok*, então *como posso te chamar ❓*");
	 mysql_query("UPDATE chatbot SET opcao='p1' WHERE cliente='$sender'");
	 echo json_encode($reply);
	 }else if($message == "Sim" && $opcao == "p2"){
	 $reply = array("reply" => "Olá *".$nome."*, 👋 eu sou *Mário* 👦, Robô 🤖 da xTreme.
	 
	 *Para começarmos, escolha uma opção:*
	 *1* - Já sou cliente 😍
	 *2* - Quero ser cliente/Conhecer produtos 😘
	 *#* - Principais dúvidas ⁉️
	 *0* - Falar com Humano 😓
	 
	 *_Você pode falar comigo a qualquer momento, basta dizer_ Mário* 
	 "); 
	 echo json_encode($reply);
	 mysql_query("UPDATE chatbot SET opcao='0' WHERE cliente='$sender'");
	 }
	 
	  if($fcb['hora'] != $hora || $fcb['dia'] != $dia){
	   if($fcb['nome'] != "" && $fcb['nome'] != null){
	  $reply = array("reply" => "Olá *".$nome."*, 👋 eu sou *Mário* 👦, Robô 🤖 da xTreme.
	  
*Para começarmos, escolha uma opção:*
*1* - Já sou cliente 😍
*2* - Quero ser cliente/Conhecer produtos 😘
*#* - Principais dúvidas ⁉️
*0* - Falar com Humano 😓
	  
*_Você pode falar comigo a qualquer momento, basta dizer_ Mário* 
	  "); 
	  mysql_query("UPDATE chatbot SET opcao='0', hora='$hora', dia='$dia' WHERE cliente='$sender'");
	  echo json_encode($reply);
	  }
	  }else {
	 if($message == "3" && $opcao == "1") {
     if($r == 0){
     $reply = array("reply" => "*Xii...* Você *não* tem um cadastro em nosso sistema, prosseguida pela opção *2*, ou chame um *Humano*.");
     }else if($r != 0){
        $reply = array("reply" => "*Hmm*, E qual o *número da solicitação* ?");
        }
		$upm=mysql_query("UPDATE chatbot SET status='0', opcao='0' WHERE cliente='$sender'");
		echo json_encode($reply);
      }
	  //
	 if($message == "4" && $opcao == "1") {
     if($r == 0){
     $reply = array("reply" => "*Xii...* Você *não* tem um cadastro em nosso sistema, prosseguida pela opção *2*, ou chame um *Humano*.");
     }else if($r != 0){
        $reply = array("reply" => "*Hmm*, E qual o *número da Compra* ?");
        }
		$upm=mysql_query("UPDATE chatbot SET status='0', opcao='0' WHERE cliente='$sender'");
		echo json_encode($reply);
      }
	  //
   	 if($message == "1" && $opcao == "n2") {
        $reply = array("reply" => "*Hmm*, E qual o *número do Pedido* ?");		echo json_encode($reply);
		$upm=mysql_query("UPDATE chatbot SET status='0', opcao='w1' WHERE cliente='$sender'");
      }
      //
      if($message == "1" && $opcao == "n3") {
      $reply = array("reply" => "*Hmm*, E qual o *número da Compra* ?");		echo json_encode($reply);
      $upm=mysql_query("UPDATE chatbot SET status='0', opcao='w2' WHERE cliente='$sender'");
      }
      //
      if($message == "1" && $opcao == "n4") {
      $reply = array("reply" => "*Hmm*, E qual o *número do Orçamento* ?");		echo json_encode($reply);
      $upm=mysql_query("UPDATE chatbot SET status='0', opcao='w3' WHERE cliente='$sender'");
      }
      if($message == "1" && $opcao == "n5") {
      $reply = array("reply" => "*Ok*, Escolha uma opção\n\n*1* - Nota de Compra\n*2* - Atendimento");		echo json_encode($reply);
      $upm=mysql_query("UPDATE chatbot SET status='0', opcao='w4' WHERE cliente='$sender'");
      }
      if($message == "2" && $opcao == "n5"){
      $reply = array("reply" => " *Acesse nossa lista de produtos:*\nhttps://xtremetec.com.br/produtos.php\n*Para adquirir um Produto*, basta dizer o código do produto a qualquer momento.");
      echo json_encode($reply);	 
      mysql_query("UPDATE chatbot SET status='0', opcao='0' WHERE cliente='$sender'");
      }
	  //
	 else if($message == "mario" || $message == "Mario" || $message == "mário" || $message == "Mário" && $status2 != 0){
	 $reply = array("reply" => "Olá *".$nome."*, 👋 eu sou *Mário* 👦, Robô 🤖 da xTreme.
	 
*Para começarmos, escolha uma opção:*
*1* - Já sou cliente 😍
*2* - Quero ser cliente/Conhecer produtos 😘
*#* - Principais dúvidas ⁉️
*0* - Falar com Humano 😓
	 
	 *_Você pode falar comigo a qualquer momento, basta dizer_ Mário* 
	 ");
	 echo json_encode($reply);
		 mysql_query("UPDATE chatbot SET opcao='0', hora='$hora', dia='$dia' WHERE cliente='$sender'");
	 }//
	if($message == "2" && $status2 != 0 && $opcao == "0")		{
			 $reply = array("reply" => "*Ok, escolha uma opção*

*1* - Ver produtos 🛒
*2* - Solicitar orçamento/Pedido 📃
*3* - Realizar cadastro ⌨
		");
     echo json_encode($reply);
	 mysql_query("UPDATE chatbot SET status='0', opcao='3' WHERE cliente='$sender'"); 
     }	 if($message == "1" && $status2 != 0 && $opcao == "3")		{			 $reply = array("reply" => " *Acesse nossa lista de produtos:*\nhttps://xtremetec.com.br/produtos.php\n*Para adquirir um Produto*, basta dizer o código do produto a qualquer momento.");     echo json_encode($reply);	 mysql_query("UPDATE chatbot SET status='0', opcao='0' WHERE cliente='$sender'");      }
	 //
	  if($message == "2" && $opcao == "3") {// mensagem 2 opção 3
		$reply = array("reply" => "*".$nome."*, Qual o título da solicitação ? _(Ex: Reparo no J7 Prime)_");
		echo json_encode($reply);
		mysql_query("UPDATE chatbot SET status='0', opcao='3p1' WHERE cliente='$sender'");
	  }
	  if($message == "3" && $opcao == "3") {// mensagem 2 opção 3
		$reply = array("reply" => "*Para realizar seu Cadastro*
Você deve acessar nosso sistema, em alguns cliques seu cadastro será realizado...
Para prosseguir, clique: https://xtremetec.com.br/cliente");
		mysql_query("UPDATE chatbot SET status='0', opcao='0' WHERE cliente='$sender'");
		echo json_encode($reply);
	  }
	 //
  if($message == "0" && $opcao == "0")
	 {
   $reply = array("reply" => "Olá *".$nome."*, por segurança, para iniciar seu atendimento preciso que me informe um Código de atendimento.\nPara gerar um código de atendimento,vá até o site https://xtremetec.com.br, logo após *clique sobre sua foto*, depois *clique em Suporte*.\n\n*Após pegar seu código de atendimento, volte aqui e digite-o:*");
	 	  echo json_encode($reply);
	 	  mysql_query("UPDATE chatbot SET opcao='atendimento', hora='$hora', dia='$dia' WHERE cliente='$sender'");
  }
  if($message == "1" && $opcao == "0")
	 {//Pergunta 3
	 if($r != 0 || $rcpf != 0){
	 $reply = array("reply" => "Olá *".$nome."*, Que bom ver você aqui novamente.\n\n*Escolha uma opção*	 
*1* - Pedidos 📋
*2* - Prestação de Serviços 🛠️
*3* - Orçamentos 📃
*4* - Compras & Produtos 🛒
*5* - Meu cadastro 👤
*6* - Tenho um problema 🆘"); 
	 echo json_encode($reply);
	 mysql_query("UPDATE chatbot SET opcao='n1' WHERE cliente='$sender'");
	 }else if($r == 0 && $rcpf == 0){
	 $reply = array("reply" => "*".$nome."*, Não encontrei nenhum cadastro com seu número do WhatsApp.
	 *Escolha uma opção para prosseguir*
	 *1* - Prosseguir com CPF/CNPJ
	 *2* - Voltar ao Menu principal");
	 echo json_encode($reply);
	 mysql_query("UPDATE chatbot SET opcao='p3' WHERE cliente='$sender'");
	 }
	 }
	 
	 //
	 else if($message == "1" && $opcao == "n1")
	 { 
	 $reply = array("reply" => "*Entendi*, E qual opção melhor lhe atende ?\n*1* - Acompanhar pedido 📋\n*2* - Fazer novo pedido 💻");
	 mysql_query("UPDATE chatbot SET opcao='n2' WHERE cliente='$sender'");
	 echo json_encode($reply);
	 }
	 else if($message == "2" && $opcao == "n1")
	 { 
	 $reply = array("reply" => "*Entendi*, E qual opção melhor lhe atende ?\n*1* - Acompanhar Serviço 🛠️\n*2* - Fazer nova solicitação 💻");
	 mysql_query("UPDATE chatbot SET opcao='n3' WHERE cliente='$sender'");
	 echo json_encode($reply);
	 }
	 else if($message == "3" && $opcao == "n1")
	 { 
	 $reply = array("reply" => "*Entendi*, E qual opção melhor lhe atende ?\n*1* - Resultado orçamento 📃️\n*2* - Fazer novo orçamento 💻");
	 mysql_query("UPDATE chatbot SET opcao='n4' WHERE cliente='$sender'");
	 echo json_encode($reply);
	 }
	 else if($message == "4" && $opcao == "n1")
	 { 
	 $reply = array("reply" => "*Entendi*, E qual opção melhor lhe atende ?\n*1* - Minhas compras 🛍️️\n*2* - Ver produtos 🛒");
	 mysql_query("UPDATE chatbot SET opcao='n5' WHERE cliente='$sender'");
	 echo json_encode($reply);
	 }
	 else if($message == "5" && $opcao == "n1")
	 { if($fcb['cpf'] != "" && $fcb['cpf'] != null){
	 $reply = array("reply" => "*Cadastro de ".$nome.".*

*Nome:* ".$ecpf['nome']."
*Celular:* ".$ecpf['celular']."
*E-mail:* ".$ecpf['email']."
*CPF:* ".$ecpf['cpf']."	 
_Por segurança não posso acessar seus outros dados, pois são criptografados. Mas se quiser você pode fazer alterações através do site: https://xtremetec.com.br_

_*Você pode falar comigo a qualquer momento, basta dizer Mário*_
	 ");
	 mysql_query("UPDATE chatbot SET opcao='0' WHERE cliente='$sender'");
	 echo json_encode($reply);
	 }
	 }
	 else if($message == "6" && $opcao == "n1")
	 { 
	 $reply = array("reply" => "*Contate-nos*
*E-mail:* contato@xtremetec.com.br
*Site:* https://xtremetec.com.br

Se preferir, você pode solicitar atendimento por aqui mesmo, basta dizer *Atendimento*.
");
	 mysql_query("UPDATE chatbot SET opcao='n5' WHERE cliente='$sender'");
	 echo json_encode($reply);
	 }
	 //
	 
	 else if($message == "1" && $opcao == "p3")
	 { //P3-2
	 $reply = array("reply" => "*".$nome."*, Qual seu *CPF* ou *CNPJ* ?");
	 mysql_query("UPDATE chatbot SET opcao='p4' WHERE cliente='$sender'");
	 echo json_encode($reply);
	 }else if($message == "2" && $opcao == "p3")
	 { //P3-3
	 $reply = array("reply" => "Olá *".$nome."*, 👋 eu sou *Mário* 👦, Robô 🤖 da xTreme.
	 
	 *Para começarmos, escolha uma opção:*
	 *1* - Já sou cliente 😍
	 *2* - Quero ser cliente/Conhecer produtos 😘
	 *#* - Principais dúvidas ⁉️
	 *0* - Falar com Humano 😓
	 
	 *_Você pode falar comigo a qualquer momento, basta dizer_ Mário* 
	 "); 
	 echo json_encode($reply);
	 mysql_query("UPDATE chatbot SET opcao='0' WHERE cliente='$sender'");
	 }else if($opcao == "p4"){//Pergunta 4
	 $reply = array("reply" => "*".$nome."*, o *CPF/CNPJ* _*".$message."*_, está correto ?
Responda com *Sim* ou *Não*.");
	 mysql_query("UPDATE chatbot SET cpf='$message', opcao='p4-r' WHERE cliente='$sender'");
	 echo json_encode($reply);
	 }else if($opcao == "3p1"){
	 $reply = array("reply" => "*".$nome."*, O título da Solicitação será *".$message."*, está correto ?\nResponda com *Sim* ou *Não*.");
	 echo json_encode($reply);
	 mysql_query("UPDATE chatbot SET opcao='3p1-r', titulo='$message' WHERE cliente='$sender'");
	 }else if($message == "Não" && $opcao == "3p1-r"){
	 $reply = array("reply" => "*".$nome."*, Então qual o *Título da Solicitação* ? _(Ex: Reparo em J7 Prime)_");
	 echo json_encode($reply);
	 mysql_query("UPDATE chatbot SET opcao='3p1-r' WHERE cliente='$sender'");
	 }else if($message == "Sim" && $opcao == "3p1-r"){
	 $reply = array("reply" => "*".$nome."*, Agora descreva sua solicitação, com o máximo de detalhes possíveis.");
	 echo json_encode($reply);
	 mysql_query("UPDATE chatbot SET opcao='3p2' WHERE cliente='$sender'");
	 }else if($opcao == "3p2"){
	 $reply = array("reply" => "*".$nome."*, Confirme se os detalhes de sua solicitação estão corretos:\n\n*Título:* ".$fcb['titulo']."\n*Mensagem:* ".$message."\n\nEstão corretos ?\nResponda com *Sim* ou *Não*.");
	 echo json_encode($reply);
	 mysql_query("UPDATE chatbot SET opcao='3p2-r', solicitacao='$message' WHERE cliente='$sender'");
	 }else if($message == "Sim" && $opcao == '3p2-r'){
	 $reply = array("reply" => "*".$nome."*, Sua solicitação já foi salva em nosso sistema, entraremos em contato nas próximas horas...\n\n*Título:* ".$fcb['titulo']."\n*Mensagem:* ".$fcb['solicitacao']."\n*Código da solicitação*:");
	 echo json_encode($reply);
	 mysql_query("UPDATE chatbot SET opcao='0' WHERE cliente='$sender'");
	 }
	 else if($message == "Não" && $opcao == "p4-r")
	 {
	 $reply = array("reply" => "*".$nome."*, Então Qual seu *CPF* ou *CNPJ* ?");
	 mysql_query("UPDATE chatbot SET opcao='p4' WHERE cliente='$sender'");
	 echo json_encode($reply);
	 }else if($message == "Sim" && $opcao == "p4-r")
	 {
	 $cpfcc = $fcb['cpf'];
	 $sc2=mysql_query("SELECT * FROM clientes WHERE cpf='$cpfcc'");
	 $rsc2=mysql_num_rows($sc2);
	  if($rsc2 <= 0)
	  {
	  $reply = array("reply" => "*".$nome."*, *Não* encontrei nenhum cadastro com o CPF/CNPJ *".$cpfcc."*\nNavegue pela opção *2*.");
	  echo json_encode($reply);
	  mysql_query("UPDATE chatbot SET cpf='', opcao='0' WHERE cliente='$sender'");
	  }else if($rsc2 != 0){
	   $reply = array("reply" => "*".$nome."*, *Encontrei* seu cadastro no sistema, agora já você pode navegar pela opção *Cliente*.

Para começarmos, *escolha um opção*
*1* - Acompanhar pedido
*2* - Acompanhar serviço
*3* - Resultado orçamento
*4* - Nota de Compra
*5* - Tenho um problema

*Você pode acessar o Menu principal a qualquer momento, basta dizer _Mário_*");
	   echo json_encode($reply);
	   mysql_query("UPDATE chatbot SET opcao='0' WHERE cliente='$sender'");
	  }
	 }
	 	if($opcao == "w1"){	
	 	$my=mysql_query("SELECT * FROM pedidos WHERE codigo='$message'");
	 	$emy=mysql_fetch_assoc($my);
	 	$emyr=mysql_num_rows($my);
	 	 $pedido=$emy['codigo'];
	 	 if($emyr != 0) {	
	 	 $reply = array("reply" => "Olá *".$nome."*, verifiquei no sistema que seu pedido N° *".$pedido."*, Está: *".$emy['status']."*.");
	 	 echo json_encode($reply);
	 	  }else if($emyr == 0) {
	 	   $reply = array("reply" => "Não encontrei o código informado no sistema, tente novamente.\n\n_*Para voltar ao Menu principal, basta dizer Mário*_");
	 	   echo json_encode($reply);
	 	    }
	 	    }
	 	  if($opcao == "w2"){	
	 	  $my=mysql_query("SELECT * FROM vendas WHERE codigo='$message'");
	 	  $emy=mysql_fetch_assoc($my);
	 	  $emyr=mysql_num_rows($my);
	 	  $pedido=$emy['codigo'];
	 	  if($emyr != 0) {	
	 	  $reply = array("reply" => "Olá *".$nome."*, verifiquei no sistema que sua compra N° *".$pedido."*, Está: *Concluída*.\nVocê pode emitir uma nota navegando pelas opções *1 > 4*\n\n_*Se precisar falar comigo, é só dizer Mário*_");
	 	  echo json_encode($reply);
	 	  }else if($emyr == 0) {
	 	  $reply = array("reply" => "Não encontrei o código informado no sistema, tente novamente.\n\n_*Para voltar ao Menu principal, basta dizer Mário*_");
	 	  echo json_encode($reply);
	 	  }
	 	  }
	 	  if($opcao == "w3"){	
	 	  $my=mysql_query("SELECT * FROM orcamentos WHERE codigo='$message'");
	 	  $emy=mysql_fetch_assoc($my);
	 	  $emyr=mysql_num_rows($my);
	 	  $pedido=$emy['codigo'];
	 	  if($emyr != 0) {	
	 	   if($emy['status'] == "Concluído" || $emy['status'] == "Respondido"){
	 	    $reply = array("reply" => "Olá *".$nome."*, verifiquei no sistema que seu orçamento de N° *".$pedido."*, Está: *".$emy['status']."*.\n\n*Código de orçamento:* ".$emi['codigo']."\n*Sua mensagem:* ".$emy['mensagem']."\n*Resposta:* ".$emy['resposta']."\n*Respondido por:* ".$emy['atendente']."\n\n_*Se precisar falar comigo, é só dizer Mário*_");
	 	    echo json_encode($reply);
	 	   }else if($emy['status'] == "Em Andamento" || $emy['status'] == "Em análise"){
	 	    $reply = array("reply" => "*".$nome."*, O status do seu orçamento de N° *".$emy['codigo']."*, está *".$emy['status']."*");
	 	    echo json_encode($reply);
	 	   }
	 	  }else if($emyr == 0) {
	 	  $reply = array("reply" => "Não encontrei o código informado no sistema, tente novamente.\n\n_*Para voltar ao Menu principal, basta dizer Mário*_");
	 	  echo json_encode($reply);
	 	  }
	 	  }
	 	  else if($message == "1" && $opcao == "w4"){
	 	  $reply = array("reply" => "Olá *".$nome."*, gerei uma nota para você, pode acessa-la clicando no link: https://xtremetec.com.br/gerar/nota.php?CPF=476.746.168-51\n\n_*Se precisar falar comigo, é só dizer Mário*_");
	 	  echo json_encode($reply);
	 	  mysql_query("UPDATE chatbot SET opcao='0', hora='$hora', dia='$dia' WHERE cliente='$sender'");
	 	  }
	 	  else if($message == "2" && $opcao == "w4"){
	 	  $reply = array("reply" => "*Contate-nos*
*E-mail:* contato@xtremetec.com.br
*Site:* https://xtremetec.com.br
	 	  
Se preferir, você pode solicitar atendimento por aqui mesmo, basta dizer *Atendimento*.
	 	  ");
	 	  echo json_encode($reply);
	 	  mysql_query("UPDATE chatbot SET opcao='0', hora='$hora', dia='$dia' WHERE cliente='$sender'");
	 	  }
	 	  else if($message == "Atendimento"){
	 	  $reply = array("reply" => "Olá *".$nome."*, por segurança, para iniciar seu atendimento preciso que me informe um Código de atendimento.\nPara gerar um código de atendimento,vá até o site https://xtremetec.com.br, logo após *clique sobre sua foto*, depois *clique em Suporte*.\n\n*Após pegar seu código de atendimento, volte aqui e digite-o:*");
	 	  echo json_encode($reply);
	 	  mysql_query("UPDATE chatbot SET opcao='atendimento', hora='$hora', dia='$dia' WHERE cliente='$sender'");
	 	  }
	 	  else if($opcao == "atendimento"){
	 	  $st=mysql_query("SELECT * FROM clientes WHERE cpf='$cpftwo' AND atendimento='$message'");
	 	  $rst=mysql_num_rows($st);
	 	  if($rst != 0){
	 	  $reply = array("reply" => "*".$nome."*, Seu atendimento já foi iniciado.\n\nAguarde até que um(a) responsável lhe atenda.\n*Codigo de atendimento:* $message");
	 	  echo json_encode($reply);
	 	  mysql_query("UPDATE chatbot SET opcao='ematendimento', hora='$hora', dia='$dia' WHERE cliente='$sender'");
	 	  }else if($rst == 0){
	 	  $reply = array("reply" => "*Código de atendimento inválido!*\nTente novamente ou digite *Mário*.");
	 	  echo json_encode($reply);
	 	  }
	 	    }
	 	  //
	 
	 	  //
		 
	 /*
	
		//orcamentos
	while($wo=mysql_fetch_array($ppo)){
     $orcamento=$wo['codigo'];
     if($message == $orcamento) {
     $reply2 = array();
     $reply2[] = "Olá *".$f['nome']."*, verifiquei no sistema que seu orçamento N° *".$orcamento."*, Está: *".$wo['status']."*.";
     }
     echo json_encode(array("reply"=>$reply2));
     }
	 
	 
	
	 //suportes
	while($ws=mysql_fetch_assoc($pps)){
     $suporte=$ws['codigo'];
     if($message == $orcamento) {
     $reply = array();
     $reply[] = "Olá *".$f['nome']."*, verifiquei no sistema que sua solicitação de Suporte N° *".$suporte."*, Está: *".$ws['status']."*.";
     }
     echo json_encode(array("reply"=>$reply));
     }
	//
	 }
    */
    }
     //WHILES		 //pedidos	
 ?>
