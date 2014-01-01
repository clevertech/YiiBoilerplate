<?php
/**
 * What visitor will see in case of any error.
 *
 * @var FrontendSiteController $this
 * @var string $message
 * @var string $code
 */
$this->pageTitle .= ' - Error';
?>

<div class="error_page">
	<div><?php echo CHtml::encode($message) ?></div>

	<small>(Error <?php echo $code ?>)</small>
</div>