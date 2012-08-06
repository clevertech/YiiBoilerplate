<?php
$this->pageTitle = Yii::app()->name . ' - Contact Us';
$this->breadcrumbs = array(
	'Contact',
);
?>

<h1>Contact Us</h1>

<?php if (Yii::app()->user->hasFlash('contact')): ?>

<div class="flash-success">
	<?php echo Yii::app()->user->getFlash('contact'); ?>
</div>

<?php else: ?>

<p>
	If you have business inquiries or other questions, please fill out the following form to contact us. Thank you.
</p>

<div class="form">

	<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id' => 'contact-form',
	'enableClientValidation' => true,
	'htmlOptions' => array('class' => 'well'),
	'clientOptions' => array(
		'validateOnSubmit' => true,
	),
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>


	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model, 'name'); ?>
	<?php echo $form->textFieldRow($model, 'email'); ?>
	<?php echo $form->textFieldRow($model, 'subject', array('size' => 60, 'maxlength' => 128)); ?>
	<?php echo $form->textAreaRow($model, 'body', array('rows' => 6, 'cols' => 50)); ?>
	<div style="clear:both"></div>
	<?php if (CCaptcha::checkRequirements()): ?>
	<?php $this->widget('CCaptcha'); ?>
	<?php echo $form->textFieldRow($model, 'verifyCode'); ?>
	<p class="help-block">Please, enter the letters as they are shown in the image above. Letters are not
		case-sensitive</p>
	<?php endif; ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'submit', 'type' => 'primary', 'label' => 'Submit', 'icon' => 'ok'));?>
		<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'reset', 'label' => 'Reset'));?>
	</div>
	<?php $this->endWidget(); ?>

</div><!-- form -->
<?php  endif; ?>