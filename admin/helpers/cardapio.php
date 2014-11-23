<?php

// No direct access to this file
defined('_JEXEC') or die;

/**
 * HelloWorld component helper.
 */
abstract class CardapioHelper
{

    /**
     * Configure the Linkbar.
     */
    public static function addSubmenu($submenu)
    {
        JSubMenuHelper::addEntry(JText::_('COM_CARDAPIO_SUBMENU_CATEGORIES'),
                'index.php?option=com_cardapio&view=categories', $submenu == 'categories');
        JSubMenuHelper::addEntry(JText::_('COM_CARDAPIO_SUBMENU_SIZES'), 'index.php?option=com_cardapio&view=sizes',
                $submenu == 'sizes');
        JSubMenuHelper::addEntry(JText::_('COM_CARDAPIO_SUBMENU_ITEMS'), 'index.php?option=com_cardapio&view=items',
                $submenu == 'items');
        // set some global property
        $document = JFactory::getDocument();
        if ($submenu == 'categories')
        {
            $document->setTitle(JText::_('COM_CARDAPIO_ADMINISTRATION_CATEGORIES'));
        }
        if ($submenu == 'items')
        {
            $document->setTitle(JText::_('COM_CARDAPIO_ADMINISTRATION_ITEMS'));
        }
        if ($submenu == 'sizes')
        {
            $document->setTitle(JText::_('COM_CARDAPIO_ADMINISTRATION_SIZES'));
        }
    }

    /**
     * Get the actions
     */
    public static function getActions($categoryId = 0)
    {
        jimport('joomla.access.access');
        $user   = JFactory::getUser();
        $result = new JObject;

        if (empty($categoryId))
        {
            $assetName = 'com_cardapio';
        }
        else
        {
            $assetName = 'com_cardapio.category.' . (int) $categoryId;
        }

        $actions = JAccess::getActions('com_cardapio', 'component');

        foreach ($actions as $action)
        {
            $result->set($action->name, $user->authorise($action->name, $assetName));
        }

        return $result;
    }

}
