<?php
/**
 * @package     mod_wgajaxcontato - WG Ajax Contato Módulo
 * @version     1.0
 * @created     Jan 2015
 *
 * @author      Lauro W. Guedes
 * @email       leo-ti@eagletecnologia.comn
 * @website     http://leowgweb.com.br
 * @support     Suporte - http://leowgweb.com.br/contato
 * @copyright   Copyright (C) 2015 Lauro W. Guedes.Todos os Direitos Reservados.
 * @license     http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 *
 */

$quebra_linha = "\n";
 
// Passando os dados obtidos pelo formulário para as variáveis abaixo
$nome = $_POST['nome']; //PEGA O NOME DO REMETENTE

$email = $_POST['email']; //PEGA O E-MAIL DO REMETENTE

$assunto = $_POST['assunto']; //PEGA O ASSUNTO

$msn = "<h3>Contato enviado do site.</h3><p><strong>Nome: </strong>$nome</p><p><strong>E-mail: <strong>$email</p><p><strong>Mensagem</strong></p>";
    
$msn .= $_POST['msn']; //PEGA A MENSAGEM

$para = $_POST['destinatario']; //E-MAIL DO DESTINATÁRIO

$mensagem_retorno = $_POST['mensagem_retorno']; //PEGA A MENSAGEM DE ENVIADO COM SUCESSO
 
 
/* Montando o cabeçalho da mensagem */
$headers = "MIME-Version: 1.1" .$quebra_linha;
$headers .= "Content-type: text/html; charset=utf-8" .$quebra_linha;
// Perceba que a linha acima contém "text/html", sem essa linha, a mensagem não chegará formatada.
$headers .= "From: <".$email.">".$quebra_linha;
$headers .= "Reply-To: ".$para.$quebra_linha;
// Note que o e-mail do remetente será usado no campo Reply-To (Responder Para)
 
/* Enviando a mensagem */

//É obrigatório o uso do parâmetro -r (concatenação do "From na linha de envio"), aqui na Locaweb:

if(mail($para, $assunto, $msn, $headers)){ // Se for Postfix
  echo $mensagem_retorno;
}else{
  echo 0;
}
?>