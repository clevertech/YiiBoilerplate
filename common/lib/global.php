<?php
/**
 * This file contains constants and shortcut functions that are commonly used.
 * Please only include functions are most widely used because this file
 * is included for every request. Functions are less often used are better
 * encapsulated as static methods in helper classes that are loaded on demand.
 */
/**
 * This is the shortcut to DIRECTORY_SEPARATOR
 */
defined('DS') or define('DS', DIRECTORY_SEPARATOR);

/**
 * This is the shortcut to Yii::app()->clientScript->registerCssFile
 */
function regCssFile($files, $url = 'css', $addBaseUrl = true)
{
	if (!is_array($files))
		$files = array($files);
	foreach ($files as $file)
	{
		$file = ($addBaseUrl) ? bu($url) . '/' . $file . '.css' : $url . '/' . $file . '.css';
		cs()->registerCssFile($file);
	}
}

/**
 * This is the shotcut to Yii::app()->clientScript->registerCoreScript
 */
function regCoreFile($files)
{
	if (!is_array($files))
		$files = array($files);
	foreach ($files as $file)
		cs()->registerCoreScript($file);
}

/**
 * This is the shortcut to Yii::app()->clientScript->registerScriptFile
 */
function regJsFile($files, $url = 'js', $pos = CClientScript::POS_HEAD)
{
	if (!is_array($files))
		$files = array($files);
	foreach ($files as $file)
		cs()->registerScriptFile(bu($url) . '/' . $file . '.js', $pos);
}

/**
 * Shortcut to display Icon image
 * @param string $img image file
 * @param string $size
 * @param string $options
 */
function icon($img, $size = '48', $options = array())
{
	return img(bu('/images/icons/' . $size . '/' . $img), '', $size, null, $options);
}

/**
 * Displays a variable.
 * This method achieves the similar functionality as var_dump and print_r
 * but is more robust when handling complex objects such as Yii controllers.
 * @param mixed variable to be dumped
 * @param integer maximum depth that the dumper should go into the variable. Defaults to 10.
 * @param boolean whether the result should be syntax-highlighted
 */
function dump($target, $depth=10, $highlight = true)
{
	echo CVarDumper::dumpAsString($target, $depth, $highlight);
}

/**
 * This is the shortcut to CHtml::encode
 */
function h($text, $limit = 0)
{
	if ($limit && strlen($text) > $limit && ($pos = strrpos(substr($text, 0, $limit), ' ')) !== false)
		$text = substr($text, 0, $pos) . ' ...';
	return htmlspecialchars($text, ENT_QUOTES, Yii::app()->charset);
}

/**
 * This is the shortcut to nl2br(CHtml::encode())
 * @param string the text to be formatted
 * @param integer the maximum length of the text to be returned. If 0, it means no truncation.
 * @param string the label of the "read more" button if $limit is greater than 0.
 * Set this to be false if the "read more" button should not be displayed.
 * @return string the formatted text
 */
function nh($text, $limit = 0, $readMore = 'read more')
{
	if ($limit && strlen($text) > $limit)
	{
		if (($pos = strpos($text, ' ', $limit)) !== false)
			$limit = $pos;
		$ltext = substr($text, 0, $limit);
		if ($readMore !== false)
		{
			$rtext = substr($text, $limit);
			return nl2br(htmlspecialchars($ltext, ENT_QUOTES, Yii::app()->charset))
				. ' ' . l(h($readMore), '#', array('class' => 'read-more', 'onclick' => '$(this).hide().next().show(); return false;'))
				. '<span style="display:none;">'
				. nl2br(htmlspecialchars($rtext, ENT_QUOTES, Yii::app()->charset))
				. '</span>';
		}
		else
			return nl2br(htmlspecialchars($ltext . ' ...', ENT_QUOTES, Yii::app()->charset));
	}
	else
		return nl2br(htmlspecialchars($text, ENT_QUOTES, Yii::app()->charset));
}

/**
 * This is the shortcut to CHtmlPurifier::purify().
 */
function ph($text)
{
	static $purifier;
	if ($purifier === null)
		$purifier = new CHtmlPurifier;
	return $purifier->purify($text);
}

/**
 * Converts a markdown text into purified HTML
 */
function mh($text)
{
	static $parser;
	if ($parser === null)
		$parser = new MarkdownParser;
	return $parser->safeTransform($text);
}

/**
 * This is the shortcut to CHtml::link()
 */
function l($text, $url = '#', $htmlOptions = array())
{
	return CHtml::link($text, $url, $htmlOptions);
}

/**
 * Generates an image tag.
 * @param string $url the image URL
 * @param string $alt the alt text for the image. Images should have the alt attribute, so at least an empty one is rendered.
 * @param integer the width of the image. If null, the width attribute will not be rendered.
 * @param integer the height of the image. If null, the height attribute will not be rendered.
 * @param array additional HTML attributes (see {@link tag}).
 * @return string the generated image tag
 */
function img($url, $alt = '', $width = null, $height = null, $htmlOptions = array())
{
	$htmlOptions['src'] = $url;
	if ($alt !== null)
		$htmlOptions['alt'] = $alt;
	else
		$htmlOptions['alt'] = '';
	if ($width !== null)
		$htmlOptions['width'] = $width;
	if ($height !== null)
		$htmlOptions['height'] = $height;
	return CHtml::tag('img', $htmlOptions);
}

/**
 * This is the shortcut to Yii::t().
 * Note that the category parameter is removed from the function.
 * It defaults to 'application'. If a different category needs to be specified,
 * it should be put as a prefix in the message, separated by '|'.
 * For example, t('backend|this is a test').
 */
function t($message, $params = array(), $source = null, $language = null)
{
	if (($pos = strpos($message, '|')) !== false)
	{
		$category = substr($message, 0, $pos);
		$message = substr($message, $pos + 1);
	}
	else
		$category = 'application';
	return Yii::t($category, $message, $params, $source, $language);
}

/**
 * This is the shortcut to Yii::app()->createUrl()
 */
function url($route, $params = array(), $ampersand = '&')
{
	return Yii::app()->getUrlManager()->createUrl($route, $params, $ampersand);
}

/**
 * This is the shortcut to Yii::app()->request->baseUrl
 * If the parameter is given, it will be returned and prefixed with the app baseUrl.
 */
function bu($url = '')
{
	static $baseUrl;
	if ($baseUrl === null)
		$baseUrl = Yii::app()->request->baseUrl;
	return $baseUrl . '/' . ltrim($url, '/');
}

/**
 * Returns the named application parameter.
 * This is the shortcut to Yii::app()->params[$name].
 */
function param($name)
{
	return Yii::app()->params[$name];
}

/**
 * This is the shortcut to Yii::app()->user.
 * @return WebUser
 */
function user()
{
	return Yii::app()->user;
}

/**
 * This is the shortcut to Yii::app()
 * @return CWebApplication
 */
function app()
{
	return Yii::app();
}

/**
 * This is the shortcut to Yii::app()->clientScript
 * @return CClientScript
 */
function cs()
{
	return Yii::app()->clientScript;
}

/**
 * This is the shortcut to Yii::app()->db
 * @return CDbConnection
 */
function db()
{
	return Yii::app()->db;
}

/**
 * This is the shortcut to Yii::app()->getRequest
 * @return CHttpRequest object
 */
function r()
{
	return Yii::app()->getRequest();
}

/**
 * This is the shortcut to Yii::app()->user->checkAccess().
 */
function allow($operation, $params = array(), $allowCaching = true)
{
	return Yii::app()->user->checkAccess($operation, $params, $allowCaching);
}

/**
 * Ensures the current user is allowed to perform the specified operation.
 * An exception will be thrown if not.
 * This is similar to {@link access} except that it does not return value.
 */
function ensureAllow($operation, $params = array(), $allowCaching = true)
{
	if (!Yii::app()->user->checkAccess($operation, $params, $allowCaching))
		throw new CHttpException(403, Yii::t('error','You are not allowed to perform this operation.'));
	return true;
}

/**
 * Shortcut to Yii::app()->format (utilities for formatting structured text)
 */
function format()
{
	return Yii::app()->format;
}

/**
 * Shortcut for json_encode
 * NOTE: json_encode exists in PHP > 5.2, so it's safe to use it directly without checking
 * @param array $json the PHP array to be encoded into json array
 * @param int $opts Bitmask consisting of JSON_HEX_QUOT, JSON_HEX_TAG, JSON_HEX_AMP, JSON_HEX_APOS, JSON_FORCE_OBJECT.
 */
function je($json, $opts=null)
{
	//return function_exists('json_encode')? json_encode($json) : CJSON::encode($json);
	return json_encode($json, $opts);
}

/**
 * Shortcut for json_decode
 * NOTE: json_encode exists in PHP > 5.2, so it's safe to use it directly without checking
 * @param string $json the PHP array to be decoded into json array
 * @param bool $assoc when true, returned objects will be converted into associative arrays.
 * @param int $depth User specified recursion depth.
 * @param int $opts Bitmask of JSON decode options. 
 *	Currently only JSON_BIGINT_AS_STRING is supported 
 *	(default is to cast large integers as floats)
 */
function jd($json, $assoc=null, $depth=512, $opts=0)
{
	return json_decode($json, $assoc, $depth);
}

/**
 * Adds trailing dots to a string if exceeds the length specified
 * @param string $txt the text to cut
 * @param integer $length the length
 * @param string $encoding the encoding type if multibyte, null otherwise
 * @return string 
 */
function trail($txt, $length, $encoding = 'utf-8')
{
	if (strlen($txt) > $length)
	{
		if (null != $encoding)
		{
			$txt = mb_substr($txt, 0, $length - 3, $encoding);
			$pos = mb_strrpos($txt, ' ', null, $encoding);
			$txt = mb_substr($txt, 0, $pos, $encoding) . '...';
		}
		else
		{
			$txt = substr($txt, 0, $length - 3);
			$pos = strrpos($txt, ' ');
			$txt = substr($txt, 0, $pos) . '...';
		}
	}
	return $txt;
}

/**
 * Email obfuscator script 2.1 by Tim Williams, University of Arizona.
 * Random encryption key feature by Andrew Moulden, Site Engineering Ltd
 * PHP version coded by Ross Killen, Celtic Productions Ltd
 * This code is freeware provided these six comment lines remain intact
 * A wizard to generate this code is at http://www.jottings.com/obfuscator/
 * The PHP code may be obtained from http://www.celticproductions.net/\n\n";
 * 
 * @param string $address the email address to obfuscate
 * @return string 
 */
function obfuscateEmail($address)
{
	$address = strtolower($address);
	$coded = "";
	$unmixedkey = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789.@";
	$inprogresskey = $unmixedkey;
	$mixedkey = "";
	$unshuffled = strlen($unmixedkey);
	for ($i = 0; $i <= strlen($unmixedkey); $i++)
	{
		$ranpos = rand(0, $unshuffled - 1);
		$nextchar = substr($inprogresskey, $ranpos, 1);
		$mixedkey .= $nextchar;
		$before = substr($inprogresskey, 0, $ranpos);
		$after = substr($inprogresskey, $ranpos + 1, $unshuffled - ($ranpos + 1));
		$inprogresskey = $before . '' . $after;
		$unshuffled -= 1;
	}
	$cipher = $mixedkey;

	$shift = strlen($address);

	$txt = "<script type=\"text/javascript\" language=\"javascript\">\n" .
		"<!-" . "-\n";

	for ($j = 0; $j < strlen($address); $j++)
	{
		if (strpos($cipher, $address{$j}) == -1)
		{
			$chr = $address{$j};
			$coded .= $chr;
		}
		else
		{
			$chr = (strpos($cipher, $address{$j}) + $shift) % strlen($cipher);
			$coded .= $cipher{$chr};
		}
	}


	$txt .= "\ncoded = \"" . $coded . "\"\n" .
		"  key = \"" . $cipher . "\"\n" .
		"  shift=coded.length\n" .
		"  link=\"\"\n" .
		"  for (i=0; i<coded.length; i++) {\n" .
		"    if (key.indexOf(coded.charAt(i))==-1) {\n" .
		"      ltr = coded.charAt(i)\n" .
		"      link += (ltr)\n" .
		"    }\n" .
		"    else {     \n" .
		"      ltr = (key.indexOf(coded.charAt(i))-
shift+key.length) % key.length\n" .
		"      link += (key.charAt(ltr))\n" .
		"    }\n" .
		"  }\n" .
		"document.write(\"<a href='mailto:\"+link+\"'>\"+link+\"</a>\")\n" .
		"\n" .
		"//-" . "->\n" .
		"<" . "/script><noscript>N/A" .
		"<" . "/noscript>";
	return $txt;
}
