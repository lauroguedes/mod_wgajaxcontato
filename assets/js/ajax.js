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
(function($){
	$(document).ready(function(){
		// ação que oculta a mensagem ao clicar no x
		$(".close").on('click',function(){
			$(this).parent().fadeOut();
		})
		// REQUISIÇÃO AJAX ENVIO DE E-MAIL
		$("#enviaEmail").on("submit",function(event){
			event.preventDefault();
			$(".loading").fadeIn().css('display','table');
			$("#enviar").attr("disabled",true);
			var urlArquivoAjax = $(this).attr("action");
			var msnErro1 = $("#mensagem_erro1").val();
			var msnErro2 = $("#mensagem_erro2").val();
			$.ajax({
				type: 'post',
				data: {nome: $("#nome").val(), email: $("#email").val(), assunto: $("#assunto").val(), msn: $("#msn").val(), destinatario: $("#destinatario").val(), mensagem_retorno: $("#mensagem_retorno").val()},
				url: urlArquivoAjax,
				success: function(dados){

					if (dados == 0){
						$(".alert-error").fadeIn();
						$(".alert-error span").html(msnErro1);
					}else{
						$(".alert-success").fadeIn();
						$(".alert-success span").html(dados);
					}

				},
				error: function(dados){

					$(".alert-error").fadeIn();
					$(".alert-error span").html(msnErro2);

				},
				complete: function(){
					$(".loading").fadeOut().css('display','none');
					$("#enviar").attr("disabled",false);
					$("#nome").val("");
					$("#email").val("");
					$("#assunto").val("");
					$("#msn").val("");
				}
			});
		});
	});	 	
})(jQuery);