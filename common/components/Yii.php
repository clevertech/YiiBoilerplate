<?php
/**
 * Yii global class under our control.
 *
 * @package YiiBoilerplate
 */
class Yii extends YiiBase
{
    /**
     * We are overriding the YiiBase's implementation of app()
     * to have the DocBlock describing correct type of return value.
     * You can just write the @method and/or @property tags in `WebApplication`
     * DobBlock afterwards.
     *
     * @return WebApplication
     */
    public static function app()
    {
        return parent::app();
    }
}