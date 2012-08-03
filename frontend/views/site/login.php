<?php
/**
 * login.php
 *
 * Example page <given as is, not even checked styles>
 * @author: antonio ramirez <antonio@clevertech.biz>
 * Date: 7/23/12
 * Time: 12:27 AM
 */
$this->pageTitle = 'Login';
$this->breadcrumbs = array(
	'Login',
);
?>
<h1>Login</h1>

<p>Please fill out the following form with your login credentials:</p>


<?php $form = $this->beginWidget('CActiveForm', array(
	'id' => 'login-form',
	'enableAjaxValidation' => false,
	'enableClientValidation' => true,
	'clientOptions' => array(
		'validateOnSubmit' => true,
	),
)); ?>
	<?php echo $form->label($model, 'username');?>
	<?php echo $form->textField($model, 'username'); ?>
	<?php echo $form->error($model, 'username');?>
	<br/>
	<?php echo $form->label($model, 'password');?>
	<?php echo $form->passwordField($model, 'password'); ?>
	<?php echo $form->label($model, 'password');?>
	<br/>
	<?php echo $form->checkBox($model, 'rememberMe'); ?>
	<?php if ($model->requireCaptcha): ?>
		<p>plain... :)) </p>
	<?php endif; ?>
	<div class="actions">
		<?php echo CHtml::submitButton('Login'); ?>
	</div>

<?php $this->endWidget(); ?>