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

	// informações do captcha
	$formcaptcha		= $params->get('formcaptcha', 1);
	$captcha_question	= $params->get('captcha_question');
	$captcha_answer		= $params->get('captcha_answer');

	// pega o valor da classe do módulo
	$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));

	// traz o arquivo default.php(visão) para ser mostrado
	require( JModuleHelper::getLayoutPath('mod_wgajaxcontato'));

	// declarando dependências
	$doc = JFactory::getDocument();
	$doc->addStyleSheet(JURI::root().'modules/mod_wgajaxcontato/assets/css/ajax.css');
	$doc->addScript(JURI::root().'modules/mod_wgajaxcontato/assets/js/ajax.js');
?>