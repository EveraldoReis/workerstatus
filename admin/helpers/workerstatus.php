<?php

// No direct access to this file
defined('_JEXEC') or die;

/**
 * HelloWorld component helper.
 */
abstract class WorkerstatusHelper
{

    /**
     * Configure the Linkbar.
     */
    public static function addSubmenu($submenu)
    {
        JSubMenuHelper::addEntry(JText::_('COM_WORKERSTATUS_SUBMENU_BUSINESSES'),
                'index.php?option=com_workerstatus&view=businesses', $submenu == 'businesses');
        JSubMenuHelper::addEntry(JText::_('COM_WORKERSTATUS_SUBMENU_SIZES'), 'index.php?option=com_workerstatus&view=sizes',
                $submenu == 'sizes');
        JSubMenuHelper::addEntry(JText::_('COM_WORKERSTATUS_SUBMENU_PERSONS'), 'index.php?option=com_workerstatus&view=persons',
                $submenu == 'persons');
        // set some global property
        $document = JFactory::getDocument();
        if ($submenu == 'businesses')
        {
            $document->setTitle(JText::_('COM_WORKERSTATUS_ADMINISTRATION_BUSINESSES'));
        }
        if ($submenu == 'persons')
        {
            $document->setTitle(JText::_('COM_WORKERSTATUS_ADMINISTRATION_PERSONS'));
        }
        if ($submenu == 'workerstatus')
        {
            $document->setTitle(JText::_('COM_WORKERSTATUS_ADMINISTRATION_WORKERSTATUSES'));
        }
        if ($submenu == 'sizes')
        {
            $document->setTitle(JText::_('COM_WORKERSTATUS_ADMINISTRATION_SIZES'));
        }
    }

    /**
     * Get the actions
     */
    public static function getActions($businessId = 0)
    {
        jimport('joomla.access.access');
        $user   = JFactory::getUser();
        $result = new JObject;

        if (empty($businessId))
        {
            $assetName = 'com_workerstatus';
        }
        else
        {
            $assetName = 'com_workerstatus.business.' . (int) $businessId;
        }

        $actions = JAccess::getActions('com_workerstatus', 'component');

        foreach ($actions as $action)
        {
            $result->set($action->name, $user->authorise($action->name, $assetName));
        }

        return $result;
    }

}
