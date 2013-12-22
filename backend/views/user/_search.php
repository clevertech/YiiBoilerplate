<?php
/**
 * @var UserController $this
 * @var User $model
 * @var CActiveForm $form
 */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model, 'id'); ?>
		<?php echo $form->textField($model, 'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'username'); ?>
		<?php echo $form->textField($model, 'username', array('size'=>45, 'maxlength'=>45)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'salt'); ?>
		<?php echo $form->textField($model, 'salt', array('size'=>60, 'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'email'); ?>
		<?php echo $form->textField($model, 'email', array('size'=>60, 'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'login_attempts'); ?>
		<?php echo $form->textField($model, 'login_attempts'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'login_time'); ?>
		<?php echo $form->textField($model, 'login_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'login_ip'); ?>
		<?php echo $form->textField($model, 'login_ip', array('size'=>32, 'maxlength'=>32)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'validation_key'); ?>
		<?php echo $form->textField($model, 'validation_key', array('size'=>60, 'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'create_id'); ?>
		<?php echo $form->textField($model, 'create_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'create_time'); ?>
		<?php echo $form->textField($model, 'create_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'update_id'); ?>
		<?php echo $form->textField($model, 'update_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'update_time'); ?>
		<?php echo $form->textField($model, 'update_time'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->