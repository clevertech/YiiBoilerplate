<?php
/** hijarian @ 12.11.13 13:00 */

class GoogleAnalyticsWidget extends CWidget
{
    /** @var string Google Analytics ID */
    public $gaid = '';

    public function run()
    {
        Yii::app()->clientScript->registerScript(
            $this->makeScriptId(),
            $this->makeScriptBody(),
            CClientScript::POS_READY
        );
    }

    /**
     * @return string
     */
    private function makeScriptId()
    {
        return sprintf('google-analytics-%s', $this->id);
    }

    /**
     * @return string
     */
    private function makeScriptBody()
    {
        return <<<ENDL
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', '{$this->gaid}']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
ENDL;
    }
} 