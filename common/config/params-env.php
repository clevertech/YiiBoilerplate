<?php
/**
 * params-env.php
 *
 * @author: antonio ramirez <antonio@clevertech.biz>
 * Date: 7/22/12
 * Time: 1:39 PM
 */
/**
 * This file contains will contain application parameters that may vary in different environment. The configuration will
 * be run by the runPostDeploy.php command.
 *
 * Possible scenarios:
 *  - private: your local development
 *  - prod: production
 *
 * You can add as many environments as required. For example, you could have (private, stage, hotfix, development)
 * To use your own environments, make sure correspondent environment files in "environments" subfolder are declared, as they
 * will be processed by runPostDeploy.php command (you will also .
 *
 * @see runpostdeploy
 */
return array();