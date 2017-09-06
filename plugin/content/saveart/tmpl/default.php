<?php
defined('_JEXEC') or die;
$uri = clone JUri::getInstance();

?>


<form id="form-savenameinternal"
		action="index.php?option=com_save&task=savenameinternal.save"
				method="post" class="" enctype="multipart/form-data">		
				<?php echo $this->form->renderField('created_by'); ?>
					<input type="hidden" name="jform[state]" id="jform_state" value="1" size="11"  maxlength="11">
					<input type="hidden" name="jform[art_id]" id="jform_art_id" value="<?php echo $this->id_artid; ?>" size="11"  maxlength="11">
					<input type="hidden" name="jform[created_by]" id="jform_art_id" value="<?php echo $this->id_user; ?>" size="11"  maxlength="11">
						<input type="submit" class=" btn btn-primary" value="OK-SAVE"></input>

			<input type="hidden" name="option" value="com_save"/>
			<input type="hidden" name="return" value="<?php echo htmlspecialchars($uri->getPath(), ENT_COMPAT, 'UTF-8'); ?>" />
			<input type="hidden" name="task"
				   value="savenameinternalform.save"/>
			<?php echo JHtml::_('form.token'); ?>
		</form>