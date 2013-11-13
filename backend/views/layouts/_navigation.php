<?php
/** hijarian @ 12.11.13 15:34 */
$this->widget(
    'bootstrap.widgets.TbNavbar',
    array(
        'type' => 'inverse',
        'brand' => 'Project name',
        'brandUrl' => '#',
        'collapse' => true,
        'items' => array(
            array(
                'class' => 'bootstrap.widgets.TbMenu',
                'items' => array(
                    array('label' => 'Home', 'url' => array('/site/index')),
                    array(
                        'label' => 'About',
                        'url' => array('/site/page', 'view' => 'about')
                    ),
                    array(
                        'label' => 'Login',
                        'url' => array('/site/login'),
                        'visible' => Yii::app()->user->isGuest
                    ),
                    array(
                        'label' => 'Logout (' . Yii::app()->user->name . ')',
                        'url' => array('/site/logout'),
                        'visible' => !Yii::app()->user->isGuest
                    ),
                    array(
                        'label' => 'Users list',
                        'url' => array('/user'),
                        'visible' => !Yii::app()->user->isGuest
                    )
                ),
            ),
            '<form class="navbar-search pull-left" action=""><input type="text" class="search-query span2" placeholder="Search"></form>',
            array(
                'class' => 'bootstrap.widgets.TbMenu',
                'htmlOptions' => array('class' => 'pull-right'),
                'items' => array(
                    array('label' => 'Link', 'url' => '#'),
                    '---',
                    array(
                        'label' => 'Dropdown',
                        'url' => '#',
                        'items' => array(
                            array('label' => 'Action', 'url' => '#'),
                            array('label' => 'Another action', 'url' => '#'),
                            array(
                                'label' => 'Something else here',
                                'url' => '#'
                            ),
                            '---',
                            array('label' => 'Separated link', 'url' => '#'),
                        )
                    ),
                ),
            ),
        ),
    )
);