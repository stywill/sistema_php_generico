<?php

function email($destino,$nome,$titulo, $mensagem, $responder_para=false, $anexo=false)
{
	
//===============================================================by jdl php mailer

  if(! $responder_para)
  {
		$responder_para='incentivocpa@brandworks.com.br';  
  }

require_once("class.phpmailer.php");//inclui a classe PHPMAILER que (caso nao tenha deve ser baixada)

$mail = new PHPMailer();//instancia o objeto

$mail->IsSMTP();//enviar via SMTP

$mail->Port = 587; // SMTP servers


 
//$mail->Host = "108.179.252.25";//seu servidor smtp / dominio no meu caso "mail" mas pode mudar verifique o seu!
$mail->Host = "smtp.brandworks.com.br";//seu servidor smtp / dominio no meu caso "mail" mas pode mudar verifique o seu!

$mail->SMTPAuth = true;//habilita smtp autenticado

$mail->Username = "incentivocpa@brandworks.com.br";//usu�rio deste servidor smtp. Aqui esta a solucao
$mail->Password = "!incentivo4321?"; // senha

$mail->From = $responder_para;//email utilizado para o envio, pode ser o mesmo de username
$mail->FromName = "Tabloides";//nome para exibicao

$mail->AddAddress($destino,$nome);//Enderecos que devem receber a mensagem
$mail->WordWrap = 50;//wrap seta o tamanhdo do texto por linha



#anexando arquivos no email (supondo estar no mesmo diretorio)
//if($_SERVER["REMOTE_ADDR"] == '177.158.68.32')
	//die('<pre>'.print_r($anexo,true).'</pre>');

if($anexo)
{
	if(is_array($anexo))
	{
		foreach($anexo as $arquivo)
		{
			//echo "{$arquivo[0]},{$arquivo[1]} <br/>";
			$mail->AddAttachment($arquivo[0],$arquivo[1]);	
		}
	}
	else
		$mail->AddAttachment($anexo);
}

$mail->IsHTML(true); //enviar em HTML
$mail->SetLanguage("br");
//$mail->CharSet = 'UTF-8';


if(!$responder_para)
 $mail->AddReplyTo($responder_para,"Tabloides"); //informando a quem devemos responder. o mail inserido no formulario
 else
 $mail->AddReplyTo($responder_para,"Tabloides"); //informando a quem devemos responder. o mail inserido no formulario
 
 ;//criando o codigo html para enviar no email, voce pode utilizar qualquer tag html
 

$mail->Subject = $titulo;//assunto

$mail->Body = $mensagem;//adicionando o html no corpo do email







return $mail->Send();//enviando e retornando o status de envio


}



                
          
                
                
//======================================================================================fim by jdl
?> 