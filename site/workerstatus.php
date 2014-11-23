<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

defined('_JEXEC') or exit('Restricted access');

require(JPATH_COMPONENT_ADMINISTRATOR . DS . 'lib' . DS . 'vendor' . DS . 'autoload.php');
// require helper file
JLoader::register('WorkerstatusView', JPATH_COMPONENT_ADMINISTRATOR . DS . 'lib' . DS . 'workerstatus' . DS . 'smartyview.php');

jimport('joomla.application.component.controller');

$controller = JController::getInstance('Workerstatus');

$input = JFactory::getApplication()->input;

$controller->execute($input->getCmd('task'));

$controller->redirect();
