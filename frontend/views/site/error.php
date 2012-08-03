<?php
/**
 * error.php
 *
 * General view file to display error messages
 * Change to suit your needs.
 *
 * @see errHandler at the main.php configuration file
 *
 * @author: antonio ramirez <antonio@clevertech.biz>
 * Date: 7/22/12
 * Time: 8:27 PM
 */
$this->pageTitle .= ' - Error';
?>

<div class="error_page">
	<div><?php echo CHtml::encode($message) ?></div>

	<small>(Error <?php echo $code ?>)</small>
</div><!-- .error_page -->