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
?>
<div class="conteudo_form" style="width: <?php echo $largura?>; height: <?php echo $altura?>">
	<div class="loading" style="height: <?php echo $altura?>">
		<div class="gif"><img src="<?php echo JURI::root().'modules/mod_wgajaxcontato/assets/img/loading.png'?>" alt="Carregando..." /></div>
	</div>
	<div class="alert alert-success">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
		<strong><i class="icon-ok"></i></strong> <span></span>
	</div>
	<div class="alert alert-error">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
		<strong><i class="icon-ban-circle"></i></strong> <span></span>
	</div>
	<form class="form-<?php echo $posicaolabel; ?>" id="enviaEmail" method="post" action="<?php echo $urlArquivoAjax; ?>">
		<fieldset>
			<!-- Text input-->
			<div class="control-group">
				<label class="control-label" for="nome"><?php echo JText::_('MOD_WGAJAXCONTATO_SITE_NOME_LABEL');?></label>
				<div class="controls">
					<input id="nome" name="nome" class="<?php echo $tamanhocampo; ?>" required="" type="text">
				</div>
			</div>

			<!-- Text input-->
			<div class="control-group">
				<label class="control-label" for="email"><?php echo JText::_('MOD_WGAJAXCONTATO_SITE_EMAIL_LABEL');?></label>
				<div class="controls">
					<input id="email" name="email" class="<?php echo $tamanhocampo; ?>" required="" type="text">

				</div>
			</div>

			<!-- Text input-->
			<div class="control-group">
				<label class="control-label" for="assunto"><?php echo JText::_('MOD_WGAJAXCONTATO_SITE_ASSUNTO_LABEL');?></label>
				<div class="controls">
					<input id="assunto" name="assunto" class="<?php echo $tamanhocampo; ?>" required="" type="text">

				</div>
			</div>

			<!-- Textarea -->
			<div class="control-group">
				<label class="control-label" for="msn"><?php echo JText::_('MOD_WGAJAXCONTATO_SITE_MENSAGEM_LABEL');?></label>
				<div class="controls">                     
					<textarea id="msn" required="" name="msn" class="<?php echo $tamanhocampo; ?>"></textarea>
				</div>
			</div>

			<!-- Button -->
			<div class="control-group">
				<label class="control-label" for="enviar"></label>
				<div class="controls">
					<button id="enviar" name="enviar" class="btn btn-primary"><?php echo JText::_('MOD_WGAJAXCONTATO_SITE_ENVIAR_LABEL');?></button>
				</div>
			</div>

			<input id="destinatario" name="destinatario" value="<?php echo $destinatario; ?>" class="input-xlarge" type="hidden">
			<input id="mensagem_retorno" name="mensagem_retorno" value="<?php echo $mensagem; ?>"  class="input-xlarge" type="hidden">
			<input id="mensagem_erro1" name="mensagem_erro1" value="<?php echo JText::_('MOD_WGAJAXCONTATO_SITE_ERROA_MSN');?>"  class="input-xlarge" type="hidden">
			<input id="mensagem_erro2" name="mensagem_erro2" value="<?php echo JText::_('MOD_WGAJAXCONTATO_SITE_ERROB_MSN');?>"  class="input-xlarge" type="hidden">

		</fieldset>
	</form>
</div>
