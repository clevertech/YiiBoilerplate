<?php
/**
 * @var UserController $this
 * @var User $model
 * @var CActiveForm $form
 */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model, 'username'); ?>
		<?php echo $form->textField($model, 'username', array('size'=>45, 'maxlength'=>45)); ?>
		<?php echo $form->error($model, 'username'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'password'); ?>
		<?php echo $form->passwordField($model, 'password', array('size'=>60, 'maxlength'=>255)); ?>
		<?php echo $form->error($model, 'password'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'salt'); ?>
		<?php echo $form->textField($model, 'salt', array('size'=>60, 'maxlength'=>255)); ?>
		<?php echo $form->error($model, 'salt'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'password_strategy'); ?>
		<?php echo $form->textField($model, 'password_strategy', array('size'=>50, 'maxlength'=>50)); ?>
		<?php echo $form->error($model, 'password_strategy'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'requires_new_password'); ?>
		<?php echo $form->textField($model, 'requires_new_password'); ?>
		<?php echo $form->error($model, 'requires_new_password'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'email'); ?>
		<?php echo $form->textField($model, 'email', array('size'=>60, 'maxlength'=>255)); ?>
		<?php echo $form->error($model, 'email'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'login_attempts'); ?>
		<?php echo $form->textField($model, 'login_attempts'); ?>
		<?php echo $form->error($model, 'login_attempts'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'login_time'); ?>
		<?php echo $form->textField($model, 'login_time'); ?>
		<?php echo $form->error($model, 'login_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'login_ip'); ?>
		<?php echo $form->textField($model, 'login_ip', array('size'=>32, 'maxlength'=>32)); ?>
		<?php echo $form->error($model, 'login_ip'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'validation_key'); ?>
		<?php echo $form->textField($model, 'validation_key', array('size'=>60, 'maxlength'=>255)); ?>
		<?php echo $form->error($model, 'validation_key'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'create_id'); ?>
		<?php echo $form->textField($model, 'create_id'); ?>
		<?php echo $form->error($model, 'create_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'create_time'); ?>
		<?php echo $form->textField($model, 'create_time'); ?>
		<?php echo $form->error($model, 'create_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'update_id'); ?>
		<?php echo $form->textField($model, 'update_id'); ?>
		<?php echo $form->error($model, 'update_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'update_time'); ?>
		<?php echo $form->textField($model, 'update_time'); ?>
		<?php echo $form->error($model, 'update_time'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->