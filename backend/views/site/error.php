<?php
/**
 * @var BackendController $this
 * @var string $code
 * @var string $message
 */

$this->pageTitle=Yii::app()->name . ' - Error';
$this->breadcrumbs=array(
	'Error',
);
?>

<h2>Error <?= $code; ?></h2>

<div class="error">
<?= CHtml::encode($message); ?>
</div>