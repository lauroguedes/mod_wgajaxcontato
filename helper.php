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
        $cc = $params->get('emailcc');
        $smtpautenticacao = $params->get('smtpautenticacao');
        $smtpseguranca = $params->get('smtpseguranca');
        $smtpporta = $params->get('smtpporta');
        $smtpusuario = $params->get('smtpusuario');
        $smtpsenha = $params->get('smtpsenha');
        $smtphost = $params->get('smtphost');
        
        // informações do captcha
        $usecaptcha = $params->get('captcha');
        $publicado = JPluginHelper::isEnabled('captcha');

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
            if($usecaptcha && $publicado) {
                if ( $input['name'] == 'g-recaptcha-response'){
                    $resp = $input['value'];
                }
            }
        }

        // validando o formulário
        if ($nome == null || $email == null || $assunto == null || $msn == null){
            return '<div class="alert alert-error">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong><i class="icon-ban-circle"></i></strong> <span>'.JText::_('MOD_WGAJAXCONTATO_SITE_FORM_ERRO1').'</span>
        </div>';
        }
         //validando o e-mail
        if (!ereg('^([a-zA-Z0-9.-])*([@])([a-z0-9]).([a-z]{2,3})',$email)){
            return '<div class="alert alert-error">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong><i class="icon-ban-circle"></i></strong> <span>'.JText::_('MOD_WGAJAXCONTATO_SITE_FORM_ERRO2').'</span>
        </div>';
        }else{
            //Valida o dominio
            $dominio=explode('@',$email);
            if(!checkdnsrr($dominio[1],'A')){
                return '<div class="alert alert-error">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong><i class="icon-ban-circle"></i></strong> <span>'.JText::_('MOD_WGAJAXCONTATO_SITE_FORM_ERRO3').'</span>
        </div>';
            }
        }

        // estruturação da mensagem
        $template = $params->get('template');
        if ($template === null){
            $body = '<h4>Contato enviado do site</h4>';
            $body .= '<strong>Nome: </strong>'.$nome;
            $body .= '<br><strong>E-mail: </strong>'.$email;
            $body .= '<br><strong>Assunto: </strong>'.$assunto;
            $body .= '<br><strong>Mensagem: </strong>'.$msn;
        }else{
            $masc = array('{{nome}}','{{email}}','{{assunto}}','{{mensagem}}');
            $sub = array($nome,$email,$assunto,$msn);
            $body = str_replace($masc, $sub, $template);
        }

        if ($usecaptcha && $publicado){
            // implementação reCaptcha
            JPluginHelper::importPlugin('captcha');
            $dispatcher = JDispatcher::getInstance();
            $plugin = JPluginHelper::getPlugin('captcha');
            $p = json_decode($plugin[0]->params);
            $key = $p->private_key;
            $versao = $p->version;
            $entrada = JFactory::getApplication()->input;
            $ip = $entrada->server->get('REMOTE_ADDR', '', 'string');
            
            // verificação da versão
            if ($versao == '2.0'){
                // verificação nos servidores da Google
                $verificacao = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$key."&response=".$resp."&remoteip=".$ip);
                $verificacao = json_decode($verificacao);

                 // verificação da marcação
                if(!$resp){
                    return '<div class="alert alert-error">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong><i class="icon-ban-circle"></i></strong> <span>'.JText::_('MOD_WGAJAXCONTATO_SITE_CAPTCHA_ERRO1').'</span>
            </div>';
                }

                // verificação do spam
                if($verificacao->success == false){
                    return '<div class="alert alert-error">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong><i class="icon-ban-circle"></i></strong> <span>'.JText::_('MOD_WGAJAXCONTATO_SITE_CAPTCHA_ERRO2').'</span>
            </div>';
                }
            }else{
                return '<div class="alert alert-error">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong><i class="icon-ban-circle"></i></strong> <span>'.JText::_('MOD_WGAJAXCONTATO_SITE_CAPTCHA_ERRO4').'</span>
            </div>';
            }
        }elseif ($usecaptcha && !$pluginCaptcha){
            return '<div class="alert alert-error">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong><i class="icon-ban-circle"></i></strong> <span>'.JText::_('MOD_WGAJAXCONTATO_SITE_CAPTCHA_ERRO3').'</span>
        </div>';
        }

        // instancia a classe PHPMailer
        $mail = JFactory::getMailer();

        $enviar = array($email, $nome);
        $mail->setSender($enviar);
        $mail->addRecipient($destinatario);
        if ($cc != null && strpos($cc,',') !== false){
            $cc = explode(',', $cc);
            $mail->addCC($cc);
        }elseif ($cc != null && strpos($cc, ',') === false){
            $mail->addCC($cc);
        }
        $mail->setSubject($assunto);
        $mail->isHTML(true);
        $mail->Encoding = 'base64'; 
        $mail->setBody($body);

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