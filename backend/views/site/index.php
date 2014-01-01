<?php
/**
 * @var BackendSiteController $this
 */
$this->pageTitle=Yii::app()->name; ?>

<h1>Welcome to <i><?php echo CHtml::encode(Yii::app()->name); ?></i></h1>

<p>
    This is the administrative side ("backend") of your application.
    Everything related to it is contained inside <code>/backend</code> subdirectory.
    You can treat this directory as a <code>/protected</code> subdirectory equivalent.
    Backend includes YiiBooster as a widget toolkit, which is composed of both Twitter Bootstrap and jQuery UI toolkits.
</p>

<p>Points of interest:</p>

<ul>
    <li>
        <p>
            <code>/backend/components/BackendController.php</code> is the base for all backend controllers.
            It registers all required styles and scripts for common backend UI.
        </p>
    </li>
    <li>
        <p>Layout is <code>/backend/views/layouts/main.php</code>.</p>
    </li>
    <li>
        <p>
            Password-based login is already implemented for the backend.
            You can look at its mechanics starting at <code>/backend/controllers/actions/PasswordLoginAction.php</code>.
        </p>
        <p>
            Login/password can be seen in plaintext inside the second migration in <code>/console/migrations/</code>,
            which creates users in DB.
        </p>
    </li>
</ul>




