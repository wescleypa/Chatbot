<?php
require('config.php');
$cc = $_GET['cc']; 
$cliente=mysql_query("SELECT * FROM clientes WHERE codigo='$cc'");
$clinha=mysql_fetch_assoc($cliente);
$crows=mysql_num_rows($cliente);
$hoje2= date("Y-m-d");
$hoje= date('d/m/Y H:i:s');
$cvenc=$clinha['vencimento'];
$vence=date('d/m/Y', strtotime($cvenc. ' + 3 days'));
$vhoje = strtotime($hoje2);
$vexp = strtotime($vence);
$hora = date('h');
$dia = date('d');
$tm = false;
$tn = false;
$tp = false;
$vendas=mysql_query("SELECT * FROM vendas WHERE cliente='$cc'");
$exv=mysql_fetch_assoc($vendas);
//
$pb9991=mysql_query("SELECT * FROM vendas WHERE cliente='$cc' AND produto='9991'");
$p9991=mysql_num_rows($pb9991);
//
$pb9992=mysql_query("SELECT * FROM vendas WHERE cliente='$cc' AND produto='9992'");
$p9992=mysql_num_rows($pb9992);
//
$pb9993=mysql_query("SELECT * FROM vendas WHERE cliente='$cc' AND produto='9993'");
$p9993=mysql_num_rows($pb9993);
//
if($crows <= 0){
die();
}else if($vence > $hoje2){
die();
}
if($clinha['onoff'] == "off"){
die();
}
//
$s=mysql_query("SELECT * FROM bot WHERE cliente='$cc'");
$messagelo = strtolower($_POST['message']);
$message = str_replace(array("á", "à", "â", "ã", "ä"), "a", $messagelo);
$message5 = $_POST['message'];
$sender = $_POST['sender'];

$sc=mysql_query("SELECT * FROM c_$cc WHERE sender='$sender'");
$linha=mysql_fetch_assoc($sc); 
$rows=mysql_num_rows($sc);
$ultimamsg5=date('d-m-Y H:i');

mysql_query("UPDATE c_$cc SET dia='$dia', hora='$hora', ultimamsg='$ultimamsg5' WHERE sender='$sender'");
$ultimoacesso = date('d/m/Y');
mysql_query("UPDATE clientes SET ultimoacesso='$ultimoacesso' WHERE codigo='$cc'");

$msgwelcome = $clinha['msgwelcome'];
$emailwelcome = $clinha['emailwelcome'];
$create = date('d/m/Y H:i');
$day = date('d');
$hour = date('H');
$destravall = date('i:s');
$nomerobo = $clinha['nomerobo'];
$nomeempresa = $clinha['nomeempresa'];
$scc = mysql_query("SELECT * FROM c_$cc WHERE sender='$sender'");
$escc=mysql_fetch_assoc($scc);
$oopcao=$escc['opcao'];
$newuser = false;


//Audioon
if($clinha['audioon'] == "on" && $rows > 0){
 for ($i = 0; $i < 99; $i++) {
  for ($j=0; $j < 99; $j++){
	if($message5 == "🎤 Mensagem de voz ($i:0$j)"){
		$reply = array("reply" => "*".$escc['nome']."*, não é permitido áudios, por favor escreva para que eu possa lhe ajudar");
		echo json_encode($reply);	
	}else if($message5 == "🎤 Mensagem de voz ($i:$j)"){
	$reply = array("reply" => "*".$escc['nome']."*, não é permitido áudios, por favor escreva para que eu possa lhe ajudar");
	echo json_encode($reply);	
	}
   }
 }
return 1;
}
//

//Iniciar Atendimento
if($rows > 0 && $message == "0"){
   $respat = $clinha['respat'];
   $alterar = $escc['nome'];
   $alterar2 = $message5;
   $alterar3 = uniqid();
   $tn3 = false;
   $tm3 = false;
   $tp3 = false;
   
   //Verifica se tem termo dentro de responde3
   if(preg_match("{nome}", $respat)){
   //substitui {nome} por $alterar
   $substitui = str_replace('{nome}', $alterar, $respat);
   $respondeatt = $substitui;
   $tn3 = true;
   }else if(preg_match("{msg}", $respat)){
   $substitui = str_replace('{msg}', $alterar2, $respat);
   $respondeatt = $substitui;
   $tm3 = true;
   }else if(preg_match("{protocolo}", $respat)){
   $substitui = str_replace('{protocolo}', $alterar3, $respat);
   $respondeatt = $substitui;
   $tp3 = true;
   }else if($tm != true && $tn != true && $tp != true) {
   $respondeatt = $clinha['respat'];
   }
   
 $reply = array("reply" => $respondeatt);
 echo json_encode($reply);
 mysql_query("UPDATE c_$cc SET opcao='atendimento' WHERE sender='$sender'");
 return 1;
}
//

if($rows <= 0 && $msgwelcome == "on"){//Pergunta 1
 $ultimamsg2 = date('d-m-Y H:i');
 $reply = array("reply" => "Olá 👋 eu sou *$nomerobo*, assistente virtual da *$nomeempresa*.\nAntes de prosseguir, *Qual seu nome ❓*");
 echo json_encode($reply);
 mysql_query("INSERT INTO c_$cc (sender, opcao, criado, dia, hora, destrava, ultimamsg) VALUES ('$sender', 'cnome', '$create', '$day', '$hour', '$destravall', '$ultimamsg2')");
 return 1;
}else if($oopcao == "cnome" && $rows >= 0 && $msgwelcome == "on"){//Pergunta 2
 $reply = array("reply" => "Você se chama *".$message5."*, está correto ?\n Responda com *Sim* ou *Não*");
 mysql_query("UPDATE c_$cc SET nome='$message5', opcao='cnome2' WHERE sender='$sender'");
 echo json_encode($reply);
 return 1;
}else if($message == "nao" && $oopcao == "cnome2"){
$reply = array("reply" => "*Ok*, então *como posso te chamar ❓*");
mysql_query("UPDATE c_$cc SET opcao='cnome' WHERE sender='$sender'");
echo json_encode($reply);
return 1;
}else if($message == "sim" && $oopcao == "cnome2"){
 if($emailwelcome == "on"){
  $reply = array("reply" => "Agora eu preciso que me informe seu *E-mail*, não se preocupe, *não enviarei Spam*.\n*Qual é seu E-mail ?*");
  echo json_encode($reply);
  mysql_query("UPDATE c_$cc SET opcao='cemail' WHERE sender='$sender'");
 return 1;
 }
else if($emailwelcome == "off"){
   $seoff=mysql_query("SELECT * FROM bot WHERE cliente='$cc' AND id='bemvindo'");
   $mail=mysql_fetch_assoc($seoff);
   $opcao19=$mail['popcao'];
   $rep = $mail['responde'];
   $alterar = $escc['nome'];
   $alterar2 = $message5;
   $alterar3 = uniqid();
   //Verifica se tem termo dentro de responde3
   if(preg_match("{nome}", $rep)){
   //substitui {nome} por $alterar
   $substitui = str_replace('{nome}', $alterar, $rep);
   $resp = $substitui;
   $tn = true;
   }else if(preg_match("{msg}", $rep)){
   $substitui = str_replace('{msg}', $alterar2, $rep);
   $resp = $substitui;
   $tm = true;
   }else if(preg_match("{protocolo}", $rep)){
   $substitui = str_replace('{protocolo}', $alterar3, $rep);
   $resp = $substitui;
   $tp = true;
   }else if($tm != true && $tn != true && $tp != true) {
   $resp = $mail['responde'];
   }
   $reply = array("reply" => $resp);
   echo json_encode($reply);
   //update
   mysql_query("UPDATE c_$cc SET opcao='$opcao19' WHERE sender='$sender'");
   return 1;
 }}else if($oopcao == "cemail" && $emailwelcome == "on"){
  $reply = array("reply" => "Seu E-mail é *$message5*, está correto ?\nResponda com *Sim* ou *Não*.");
  echo json_encode($reply);
  mysql_query("UPDATE c_$cc SET opcao='cemail2', email='$message5' WHERE sender='$sender'");
  return 1;
 }else if($message == "sim" && $oopcao == "cemail2"){
 $seoff=mysql_query("SELECT * FROM bot WHERE cliente='$cc' AND id='bemvindo'");
 $mail=mysql_fetch_assoc($seoff);
 $opcao=$mail['popcao'];
 $rep = $mail['responde'];
 $alterar = $escc['nome'];
 $alterar2 = $message5;
 $alterar3 = uniqid();
 //Verifica se tem termo dentro de responde3
 if(preg_match("{nome}", $rep)){
 //substitui {nome} por $alterar
 $substitui = str_replace('{nome}', $alterar, $rep);
 $resp = $substitui;
 $tn = true;
 }else if(preg_match("{msg}", $rep)){
 $substitui = str_replace('{msg}', $alterar2, $rep);
 $resp = $substitui;
 $tm = true;
 }else if(preg_match("{protocolo}", $rep)){
 $substitui = str_replace('{protocolo}', $alterar3, $rep);
 $resp = $substitui;
 $tp = true;
 }else if($tm != true && $tn != true && $tp != true) {
 $resp = $mail['responde'];
 }
 $reply = array("reply" => $resp);
 echo json_encode($reply);
 //update
 mysql_query("UPDATE c_$cc SET opcao='$opcao19' WHERE sender='$sender'");
 return 1;
 }else if($message == "nao" && $oopcao == "cemail2"){
   $reply = array("reply" => "*Ok*, então *Qual é seu E-mail ❓*");
   echo json_encode($reply);
   mysql_query("UPDATE c_$cc SET opcao='cemail' WHERE sender='$sender'");
   return 1;
 }
 
//
if($rows <= 0 && $msgwelcome == "off"){
 while($row = mysql_fetch_assoc($s)){
  $noresponde2=$row['responde'];
  //
  $alterar = $linha['nome'];
  $alterar2 = $message5;
  $alterar3 = uniqid();
  //Verifica se tem termo dentro de responde3
  if(preg_match("{nome}", $noresponde2)){
  //substitui {nome} por $alterar
  $substitui = str_replace('{nome}', $alterar, $noresponde2);
  $noresponde = $substitui;
  $tn = true;
  }else if(preg_match("{msg}", $noresponde2)){
  $substitui = str_replace('{msg}', $alterar2, $noresponde2);
  $noresponde = $substitui;
  $tm = true;
  }else if(preg_match("{protocolo}", $noresponde2)){
  $substitui = str_replace('{protocolo}', $alterar3, $noresponde2);
  $noresponde = $substitui;
  $tp = true;
  }else if($tm != true && $tn != true && $tp != true) {
  $noresponde = $row['responde'];
  }
  //
  $message23 = strtolower($row['recebe']);
  $nomessage2 = str_replace(array("á", "à", "â", "ã", "ä"), "a", $message23);
  $notipo=$row['tipo'];
  $nocreate=date('d/m/Y H:m');
  $nodia=date('d');
  $nohora=date('h');
  $nodestrava=date('i:s');
  $noopcao=$row['popcao'];
  $hojem2=date('d-m-Y H:i');
   if($message == $nomessage2){
    $reply = array("reply" => $noresponde);
    echo json_encode($reply);
    mysql_query("INSERT INTO c_$cc (sender, criado, dia, hora, opcao, destrava, ultimamsg) VALUES ('$sender', '$nocreate', '$nodia', '$nohora', '$noopcao', '$nodestrava', '$hojem2')");
    return 1;
   }else if($nomessage2 == "*"){
     $reply = array("reply" => $noresponde);
     echo json_encode($reply);
     mysql_query("INSERT INTO c_$cc (sender, criado, dia, hora, opcao, destrava, ultimamsg) VALUES ('$sender', '$nocreate', '$nodia', '$nohora', '$noopcao', '$nodestrava', '$hojem2')");
    return 1;
   }
  }
 }
//	 
	 
if($rows >= 1){

$hojem=date('d-m-Y H:i');
$date2 = strtotime($hojem);
$linhamsg= $linha['ultimamsg'];
$date1 = strtotime($linhamsg);
$minutes2 = ($clinha['apostime'] * 3600);
$buscatime=mysql_query("SELECT * FROM bot WHERE cliente='$cc' AND id='bemvindo'");
$extime=mysql_fetch_assoc($buscatime);

if( $date2 - $date1 >= $minutes2) {
   // 1800 segundos = 30 minutos
 if($p9992 > 0 || $p9993 > 0){
   while($row = mysql_fetch_assoc($s)){
   $noresponde2=$row['responde'];
   //
   $alterar = $linha['nome'];
   $alterar2 = $message5;
   $alterar3 = uniqid();
   //Verifica se tem termo dentro de responde3
   if(preg_match("{nome}", $noresponde2)){
   //substitui {nome} por $alterar
   $substitui = str_replace('{nome}', $alterar, $noresponde2);
   $noresponde = $substitui;
   $tn = true;
   }else if(preg_match("{msg}", $noresponde2)){
   $substitui = str_replace('{msg}', $alterar2, $noresponde2);
   $noresponde = $substitui;
   $tm = true;
   }else if(preg_match("{protocolo}", $noresponde2)){
   $substitui = str_replace('{protocolo}', $alterar3, $noresponde2);
   $noresponde = $substitui;
   $tp = true;
   }else if($tm != true && $tn != true && $tp != true) {
   $noresponde = $row['responde'];
   }
   $poption = $row['popcao'];
   
   $reply = array("reply" => $noresponde);
   echo json_encode($reply);
   mysql_query("UPDATE c_$cc SET opcao='$poption' WHERE sender='$sender'");
   return 1;
   }
  }
}
   $opcaowel=$linha['opcao'];
   $mwel=mysql_query("SELECT * FROM bot WHERE cliente='$cc' AND id='bemvindo'");
   $mwel2=mysql_query("SELECT * FROM bot WHERE cliente='$cc' AND id='finalizar'");
   $replywel=mysql_fetch_assoc($mwel);
   $replywel2=mysql_fetch_assoc($mwel2);
   $recebesys=strtolower($replywel2['recebe']);
   $respwel7=$replywel['responde'];
   $respwel3=$replywel2['responde'];
   $polop2=$replywel['popcao'];
   $destravaaa = $linha['destrava'];
   $sggg = date('i:s');
   $msgencerra2=$clinha['msgencerra'];
  //
  $alterar = $linha['nome'];
  $alterar2 = $message5;
  $alterar3 = uniqid();
  if(preg_match("{nome}", $respwel7)){
  //substitui {nome} por $alterar
  $substitui = str_replace('{nome}', $alterar, $respwel7);
  $respwel2 = $substitui;
  $tn = true;
  }else if(preg_match("{msg}", $respwel7)){
  $substitui = str_replace('{msg}', $alterar2, $respwel7);
  $respwel2 = $substitui;
  $tm = true;
  }else if(preg_match("{protocolo}", $respwel7)){
  $substitui = str_replace('{protocolo}', $alterar3, $respwel7);
  $respwel2 = $substitui;
  $tp = true;
  }else if($tm != true && $tn != true && $tp != true) {
  $respwel2 = $replywel['responde'];
  }
  //222222
  if(preg_match("{nome}", $msgencerra2)){
  //substitui {nome} por $alterar
  $substitui = str_replace('{nome}', $alterar, $msgencerra2);
  $msgencerra = $substitui;
  $tn = true;
  }else if(preg_match("{msg}", $msgencerra2)){
  $substitui = str_replace('{msg}', $alterar2, $msgencerra2);
  $msgencerra = $substitui;
  $tm = true;
  }else if(preg_match("{protocolo}", $msgencerra2)){
  $substitui = str_replace('{protocolo}', $alterar3, $msgencerra2);
  $msgencerra = $substitui;
  $tp = true;
  }else if($tm != true && $tn != true && $tp != true) {
  $msgencerra = $replywel['responde'];
  }
  $palavraencerra = strtolower($clinha['palavraencerra']);
  //
  if($p9992 > 0 || $p9991 > 0 && $destravaaa != $sggg){
   if($opcaowel == "finalizar"){
   $reply = array("reply" => "".$respwel2."");
   echo json_encode($reply);
   mysql_query("UPDATE c_$cc SET opcao='$polop2' WHERE sender='$sender'");
   return 1;
   }else if($messagelo == $palavraencerra){
    $reply = array("reply" => $msgencerra);
    echo json_encode($reply);
    mysql_query("UPDATE c_$cc SET opcao='finalizar' WHERE sender='$sender'");
    return 1;
   }
  }
//Cliente 53
/*
if($linha['hora'] != $hora || $linha['dia'] != $dia){ 
	 $nome=$linha['nome'];
	 if($cc == "53"){
	 $reply = array("reply" => "".$nome.", Você está em um atendimento especializado, para ter uma solução rápida por favor selecione uma das opções abaixo.
	 
	 *1* - Orçamento
	 *2* - Verificar ordem de serviço
	 *3* - Compra e venda de aparelho
	 *4* - Acessórios
	 *5* - Informações");
	 mysql_query("UPDATE c_$cc SET opcao='0', nome='$message5' WHERE sender='$sender'"); 
	 echo json_encode($reply);
	 }
  return 1;
}

else if($linha['opcao'] == "N" && $cc == "53"){
$reply = array("reply" => "".$message5.", Você está em um atendimento especializado, para ter uma solução rápida por favor selecione uma das opções abaixo.

*1* - Orçamento
*2* - Verificar ordem de serviço
*3* - Compra e venda de aparelho
*4* - Acessórios
*5* - Informações");
echo json_encode($reply);
mysql_query("UPDATE c_$cc SET nome='$message5', opcao='0' WHERE sender='$sender'");
return 1;
}
//Fim cliente 53
*/
//WHILE
while($row = mysql_fetch_assoc($s)){
$message23 = strtolower($row['recebe']);
$message2 = str_replace(array("á", "à", "â", "ã", "ä"), "a", $message23);

$responde3 = $row['responde'];
$alterar = $linha['nome'];
$alterar2 = $message5;
$alterar3 = uniqid();
//Verifica se tem termo dentro de responde3
if(preg_match("{nome}", $responde3)){
  //substitui {nome} por $alterar
  $substitui = str_replace('{nome}', $alterar, $responde3);
  $responde2 = $substitui;
  $tn = true;
}else if(preg_match("{msg}", $responde3)){
  $substitui = str_replace('{msg}', $alterar2, $responde3);
  $responde2 = $substitui;
  $tm = true;
}else if(preg_match("{protocolo}", $responde3)){
  $substitui = str_replace('{protocolo}', $alterar3, $responde3);
  $responde2 = $substitui;
  $tp = true;
}else if($tm != true && $tn != true && $tp != true) {
$responde2 = $row['responde'];
}


$opcao2 = $row['id'];
$opcao = $linha['opcao'];
$popcao = $row['popcao'];
$mid = $row['mid'];
$tipo = $row['tipo'];
$sg = date('i:s');
$destrava = $linha['destrava'];


if($message2 == "*" && $tipo == "Mensagem"){
 $reply = array("reply" => "".$responde2."");
 echo json_encode($reply);
  return 1;
}

//Tipo: Menu
else if($tipo == "Menu"){
if($p9992 > 0 || $p9993 > 0){

$svo=mysql_query("SELECT * FROM bot WHERE cliente='$cc' AND id='bemvindo'");
$receb=mysql_fetch_assoc($svo);
$respwel=$receb['responde'];
$polop = $receb['popcao'];
 if($message == $receb['recebe'] && $destrava != $sg){
 $reply = array("reply" => "".$respwel."");
 echo json_encode($reply);
 mysql_query("UPDATE c_$cc SET opcao='$polop' WHERE sender='$sender'");
 return 1;
 }
 
 
 else if($message == $message2 && $opcao == $opcao2 && $destrava != $sg){
  $select36=mysql_query("SELECT * FROM bot WHERE cliente='$cc' AND recebe='$message' AND id='$opcao'");
  $row36=mysql_fetch_assoc($select36);
  $responde336=$row36['responde'];
  $alterar = $linha['nome'];
  $alterar2 = $message5;
  $alterar3 = uniqid();
  $tn36 = false;
  $tm36 = false;
  $tp36 = false;
  //Verifica se tem termo dentro de responde3
  if(preg_match("{nome}", $responde336)){
  //substitui {nome} por $alterar
  $substitui36 = str_replace('{nome}', $alterar, $responde336);
  $responde36 = $substitui36;
  $tn36 = true;
  }else if(preg_match("{msg}", $responde336)){
  $substitui36 = str_replace('{msg}', $alterar2, $responde336);
  $responde36 = $substitui36;
  $tm36 = true;
  }else if(preg_match("{protocolo}", $responde336)){
  $substitui36 = str_replace('{protocolo}', $alterar3, $responde336);
  $responde36 = $substitui36;
  $tp36 = true;
  }if($tm36 != true && $tn36 != true && $tp36 != true) {
  $responde36 = $row36['responde'];
  }
  
  
  if($popcao == "" || $popcao == null){
    $reply = array("reply" => "".$responde36."");
    echo json_encode($reply);
    mysql_query("UPDATE c_$cc SET opcao='bemvindo' sender='$sender'");
    return 1;
  }
  else if($popcao != "" && $popcao != null) {
    $reply = array("reply" => "".$responde36."");
    echo json_encode($reply);
    mysql_query("UPDATE c_$cc SET opcao='$popcao', destrava='$sg' WHERE sender='$sender'");
    return 1;
  } 
  return 1;
 } 
 }
}

//Tipo: Mensagem
else if($tipo == "Mensagem" && $message == $message2){
  if($p9991 > 0){
   $reply = array("reply" => "".$responde2."\n\n(Estou utilizando um sistema Xtreme Technology. https://xtremetec.com.br )");
  }else {
   $reply = array("reply" => "".$responde2."");
  }
 echo json_encode($reply);
 //mysql_query("UPDATE c_$cc SET opcao='bemvindo' WHERE sender='$sender'");
return 1;
}

//Tipo: MySQL
else if($tipo == "MySQL" && $message == $message2 && $p9993 > 0){
  $servidorc = $row['servidor'];
  $uc = $row['usuariobd'];
  $sc = $row['senhabd'];
  $bdc = $row['bd'];
  $tabelac = $row['tabela'];
  $where = $row['twhere'];
  $where2 = $row['where2'];
 //Conectando
  $conc=mysql_pconnect($servidorc, $uc, $sc);
  mysql_set_charset('utf8', $conc);
  mysql_select_db($bdc); 
 //Selecionando
 if($where2 == "" || $where2 == null){
   $tc = mysql_query("SELECT * FROM $tabelac");
 }else {
   if($where == "Mensagem"){ $where3 = $message; }else if($where == "Celular"){ $while3 == $sender; }
   $tc = mysql_query("SELECT * FROM $tabelac WHERE $where2='$where3'");
 }
 
 while($mysql1 = mysql_fetch_assoc($tc)){
 $cr = $row['responde'];
 $mysql = $mysql1[''.$cr.''];
//Respondendo
$reply = array("reply" => "".$mysql."");
echo json_encode($reply);
return 1;
   }
 }
}
//
} 
//Cliente 53
/*
else if($rows <= 0 && $cc == "53"){
$reply = array("reply" => "Olá, a Celular Consertado agradece seu contato.

Para iniciarmos seu atendimento, por favor diga seu nome.");
mysql_query("INSERT INTO c_$cc (sender, opcao, criado, dia, hora) VALUES ('$sender', 'N', '$hoje', '$dia', '$hora')");
echo json_encode($reply);
return 1;
}
*/
?>
