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
 * @copyright   Copyright (C) 2015 Lauro W. Guedes. Todos os Direitos Reservados.
 * @license     http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 *
 */
	defined('_JEXEC') or die;
	// insere a classe de ajuda (métodos específicos de tratamento)
	require_once( dirname(__FILE__) . '/helper.php' );

	$posicaolabel = $params->get('posicaolabel');
	$tamanhocampo = $params->get('tamanhocampo');

	// tratando o valor da altura e da largura
	$largura = modWgAjaxContatoHelper::trataAlturaLargura($params->get('largura'));
	$altura = modWgAjaxContatoHelper::trataAlturaLargura($params->get('altura'));

	$usecaptcha = $params->get('captcha');
	if ($usecaptcha){
		// implementação reCaptcha
		JPluginHelper::importPlugin('captcha');
		// pegando versão
		$plugin = JPluginHelper::getPlugin('captcha');
        $p = json_decode($plugin[0]->params);
        $versao = $p->version;
		if (JPluginHelper::isEnabled('captcha')){
			$dispatcher = JDispatcher::getInstance();
			$dispatcher->trigger('onInit');
			$captcha = $dispatcher->trigger('onDisplay');
			$publicado = true;
		}else{
			$publicado = false;
		}
	}

	// pega o valor da classe do módulo
	$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));

	// traz o arquivo default.php(visão) para ser mostrado
	require( JModuleHelper::getLayoutPath('mod_wgajaxcontato'));

	// declarando dependências
	$doc = JFactory::getDocument();
	$doc->addStyleSheet(JURI::base().'modules/mod_wgajaxcontato/assets/css/ajax.css');
	$doc->addScript(JURI::base().'modules/mod_wgajaxcontato/assets/js/ajax.js');
?>