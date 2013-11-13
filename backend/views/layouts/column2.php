<?php $this->beginContent('//layouts/main'); ?>
<div class="span8">
    <?php echo $content; ?>
</div>
<div class="span4">
    <div id="sidebar">
		<?php
			$this->beginWidget('zii.widgets.CPortlet', array(
				'title'=>'Operations',
			));
			$this->widget('zii.widgets.CMenu', array(
				'items'=>$this->menu,
				'htmlOptions'=>array('class'=>'operations'),
			));
			$this->endWidget();
		?>
	</div>
</div>
<?php $this->endContent(); ?>