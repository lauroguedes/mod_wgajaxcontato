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
(function($){
	$(document).ready(function(){
		// ação que oculta a mensagem ao clicar no x
		$(".close").on('click',function(){
			$(this).parent().fadeOut();
		})
		// REQUISIÇÃO AJAX ENVIO DE E-MAIL
		$("#enviaEmail").on("submit",function(event){
			event.preventDefault();

			// pega todos inputs
			var value = $(this).serializeArray(),
	            // objeto de dados para requisição
	            request = {
	                'option' : 'com_ajax',
	                'module' : 'wgajaxcontato',
	                'data'   : value,
	                'format' : 'jsonp'
	            };

			// requisição ajax
			$.ajax({
				type: 'POST',
				data: request,
				beforeSend: function(){
                    $('.loading').fadeIn().css('display','table');
                    $("#enviar").attr("disabled",true);
                },
				success: function(resposta){
					$("#resposta").fadeIn().html(resposta).delay(5000).fadeOut(500);
				},
				complete: function(){
					$(".loading").fadeOut().css('display','none');
					$("#enviar").attr("disabled",false);
					$("#nome").val("");
					$("#email").val("");
					$("#assunto").val("");
					$("#msn").val("");
					$("#sccaptcha").val("");
				}
			});
		});
	});	 	
})(jQuery);