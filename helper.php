<?php  
/**
 * @package     mod_egajaxcontato - WG Ajax Contato Módulo
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
}
?>