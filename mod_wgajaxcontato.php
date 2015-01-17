<?php
/**
 * @package     mod_wgajaxcontato - WG Ajax Contato Módulo
 * @version     1.2
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
	defined('_JEXEC') or die;

	// insere a classe de ajuda (métodos específicos de tratamento)
	require_once( dirname(__FILE__) . '/helper.php' );

	$doc = JFactory::getDocument();

	// recebendo os parâmetros
	$destinatario = $params->get('email');
	$mensagem = $params->get('mensagem');
	$posicaolabel = $params->get('posicaolabel');
	$tamanhocampo = $params->get('tamanhocampo');

	// tratando o valor da altura e da largura
	$largura = modWgAjaxContatoHelper::trataAlturaLargura($params->get('largura'));
	$altura = modWgAjaxContatoHelper::trataAlturaLargura($params->get('altura'));

	$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));
	$urlArquivoAjax = JURI::root().'modules/mod_wgajaxcontato/lib/enviar.php';

	// traz o arquivo default.php(visão) para ser mostrado
	require( JModuleHelper::getLayoutPath('mod_wgajaxcontato'));

	// declarando dependências
	$doc->addStyleSheet(JURI::root().'modules/mod_wgajaxcontato/assets/css/ajax.css');
	$doc->addScript(JURI::root().'modules/mod_wgajaxcontato/assets/js/ajax.js');
?>