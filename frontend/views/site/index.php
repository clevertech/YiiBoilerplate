<?php
/**
 * Landing page view file
 *
 * @var FrontendSiteController $this
 */
?>
<h1>Hello <?php echo Yii::app()->user->name;?></h1>

<p>
    This is the public side ("frontend") of your application.
    Everything related to it is contained inside <code>/frontend</code> subdirectory.
    You can treat this directory as a <code>/protected</code> subdirectory equivalent.
    Frontend is crystal clear HTML5 Boilerplate.
    It's expected that you are going to write your own 100% custom design anyway.
</p>

<p>Points of interest:</p>

<ul>
    <li>
        <p>
            <code>/backend/components/FrontendController.php</code> is the base for all frontend controllers.
            It registers all required styles and scripts for common frontend UI.
        </p>
    </li>
    <li>
        <p>Layout is <code>/frontend/views/layouts/main.php</code>.</p>
    </li>
    <li>
        <p>
            Note that in this layout there is the Google Analytics code already inserted as a widget.
            Just provide your GA ID in the <code>['params']['google.analytics.id']</code> section of a config,
            by specifying it in the <code>/frontend/config/environments/prod.php</code>, for example.
        </p>
    </li>
</ul>

