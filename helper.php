<?php  
/**
 * @package     mod_wgajaxcontato - WG Ajax Contato Módulo
 * @version     2.0
 * @created     Jul 2015
 *
 * @author      Lauro W. Guedes
 * @email       leo-ti@hotmail.comn
 * @website     http://leowgweb.com.br
 * @support     Suporte - http://leowgweb.com.br/contato
 * @copyright   Copyright (C) 2015 Lauro W. Guedes.Todos os Direitos Reservados.
 * @license     http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 *
 */
defined('_JEXEC') or die;

class modWgAjaxContatoHelper{
    /**
     * Trata a altura e a largura insiradas no backend
     * evitando que o usuário coloque uma string não numérica
     *
     * @param valor do campo de altura ou largura
     * @access public
     */    
    public static function trataAlturaLargura( $params )
    {
    	if ($params != 'auto'){
    		$valor = is_numeric($params) ? $params.'px' : 'auto';
    	}else{
    		$valor = 'auto';
    	}
    	return $valor;
    }

    /**
     * Trata o envio do e-mail via ajax
     * é utilizado a lib PHPMailler
     *
     * @access public
     */
    public static function getAjax()
    {
        jimport('joomla.application.module.helper');
        // Chama a biblioteca que trata campos de formulário
        $input = JFactory::getApplication()->input;
        // Chama biblioteca que trata os dados vindo das configurações no backend
        $module = JModuleHelper::getModule('wgajaxcontato');
        $params = new JRegistry();
        $params->loadString($module->params);

        // pega os valores cadastrados na configuração do módulo
        $sucesso = $params->get('sucesso');
        $falha = $params->get('falha');
        $openvio = $params->get('openvio');
        $destinatario = $params->get('email'); 
        $smtpautenticacao = $params->get('smtpautenticacao');
        $smtpseguranca = $params->get('smtpseguranca');
        $smtpporta = $params->get('smtpporta');
        $smtpusuario = $params->get('smtpusuario');
        $smtpsenha = $params->get('smtpsenha');
        $smtphost = $params->get('smtphost');
        
        // informações do captcha
        $failed_captcha     = $params->get('failed_captcha');
        $formcaptcha        = $params->get('formcaptcha', 1);
        $captcha_question   = $params->get('captcha_question');
        $captcha_answer     = $params->get('captcha_answer');

        // pega os campos digitados pelo usuário no formulário de contato
        $inputs = $input->get('data', array(), 'ARRAY');
        // atribui os campos nas variáveis
        foreach ($inputs as $input) {

            if( $input['name'] == 'email' )
            {
                $email = $input['value'];
            }

            if( $input['name'] == 'nome' )
            {
                $nome = $input['value'];
            }

            if( $input['name'] == 'assunto' )
            {
                $assunto = $input['value'];
            }

            if( $input['name'] == 'msn' )
            {
                $msn = nl2br( $input['value'] );
            }

            if($formcaptcha) {
                if( $input['name'] == 'sccaptcha' )
                {
                    $sccaptcha = $input['value'];
                }
            }
        }

        if($formcaptcha) {
            if ($sccaptcha != $captcha_answer) {
                return '<div class="alert alert-error">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong><i class="icon-ban-circle"></i></strong> <span>'.$failed_captcha.'</span>
    </div>';
            }
        }

        // instancia a classe PHPMailer
        $mail = JFactory::getMailer();

        $enviar = array($email, $nome);
        $mail->setSender($enviar);
        $mail->addRecipient($destinatario);
        $mail->setSubject($assunto);
        $mail->isHTML(true);
        $mail->Encoding = 'base64'; 
        $mail->setBody($msn);

        if ($openvio == 0 || !$mail->useSMTP($smtpautenticacao, $smtphost, $smtpusuario, $smtpsenha, $smtpseguranca, $smtpporta)){
            if ($mail->Send()) {
                return '<div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong><i class="icon-ok"></i></strong> <span>'.$sucesso.'</span>
    </div>';
            } else {
                return '<div class="alert alert-error">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong><i class="icon-ban-circle"></i></strong> <span>'.$falha.'</span>
    </div>';
            }
        }else{
           $mail->useSMTP($smtpautenticacao, $smtphost, $smtpusuario, $smtpsenha, $smtpseguranca, $smtpporta);
           if ($mail->Send()) {
                return '<div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong><i class="icon-ok"></i></strong> <span>'.$sucesso.'</span>
    </div>';
            } else {
                return '<div class="alert alert-error">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong><i class="icon-ban-circle"></i></strong> <span>'.$falha.'</span>
    </div>';
            } 
        }
    }
}
?>