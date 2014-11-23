<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

defined('_JEXEC') or exit('Restricted access');

// Access check: is this user allowed to access the backend of this component?
if (!JFactory::getUser()->authorise('core.manage', 'com_workerstatus'))
{
    return JError::raiseWarning(404, JText::_('JERROR_ALERTNOAUTHOR'));
}

// require helper file
JLoader::register('WorkerstatusHelper', dirname(__FILE__) . DS . 'helpers' . DS . 'workerstatus.php');

jimport('joomla.application.component.controller');

$controller = JController::getInstance('Workerstatus');

$input = JFactory::getApplication()->input;

$controller->execute($input->get('task', '', 'STR'));

$controller->redirect();
