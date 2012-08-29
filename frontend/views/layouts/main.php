<?php
/**
 * main.php
 *
 * @author: antonio ramirez <antonio@clevertech.biz>
 * Date: 7/23/12
 * Time: 12:31 AM
 */
?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

	<!-- Place favicon.ico and apple-touch-icon.png in the root directory -->

	<!-- Use the .htaccess and remove these lines to avoid edge case issues. More info: h5bp.com/b/378 -->
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

	<title><?php echo h($this->pageTitle); /* using shortcut for CHtml::encode */ ?></title>
	<meta name="description" content="">
	<meta name="keywords" content="">
	<meta name="viewport" content="width=device-width,initial-scale=1">

	<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css">
	<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/normalize.css">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/styles.css"/>
	<!--using less instead? file not included-->
	<!--<link rel="stylesheet/less" type="text/css" href="/less/styles.less">-->

	<!-- create your own: http://modernizr.com/download/-->
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/modernizr-2.6.1.js"></script>

	<!--<script src="/less/less-1.3.0.min.js"></script>-->
	<link rel="shortcut icon" href="<?php echo Yii::app()->request->baseUrl; ?>/images/favicon.ico">
</head>

<body>
<div class="container">
	<?php echo $content?>
</div>

<script>
	window._gaq = [['_setAccount','<?php echo param('google.analytics.account'); // check global.php shortcut file at "common/lib/" ?>'],['_trackPageview'],['_trackPageLoadTime']];
	Modernizr.load({
		load: ('https:' == location.protocol ? '//ssl' : '//www') + '.google-analytics.com/ga.js'
	});
</script>
<script type="text/javascript">
	function trackClick(link, action, category) {
		action=action || link.href;
		category=category || 'Outbound Links';
		try {
			_gaq.push(['site._trackEvent', category, action]);
			setTimeout('document.location = "' + link.href + '"', 250);
		}catch(err){}
		return false;
	}
</script>
</body>
</html>