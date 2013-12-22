<?php
/**
 * @var BackendController $this
 * @var BackendLoginForm $model
 */

$this->pageTitle = Yii::app()->name . ' - Login';
$this->breadcrumbs = ['Login'];
?>

<p>Please fill out the following form with your login credentials:</p>

<!-- Login Form BEGIN -->
<div class="form">

<?php
/** @var TbActiveForm $form */
$form = $this->beginWidget(
	'bootstrap.widgets.TbActiveForm',
	array(
		'id' => 'login-form',
		'enableClientValidation' => true,
		'htmlOptions' => ['class' => 'well'],
		'clientOptions' => array(
			'validateOnSubmit'=>true,
		),
	)
);

echo CHtml::errorSummary($model, null, null, array('class' => 'alert alert-error'));
?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?= $form->textFieldRow($model, 'username', array('class'=>'span3'));?>
	<?= $form->passwordFieldRow($model, 'password', array('class'=>'span3'));?>
	<?= $form->checkBoxRow($model, 'rememberMe');?>

	<?php if ($model->isCaptchaRequired()): ?>
		<?php $this->widget('CCaptcha'); ?>
		<?= $form->textField($model, 'verifyCode'); ?>
	<?php endif; ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit','type'=>'primary','label'=>'Submit', 'icon'=>'ok'));?>
		<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'reset','label'=>'Reset'));?>
	</div>

<?php $this->endWidget(); ?>

</div>
<!-- Login Form END -->
