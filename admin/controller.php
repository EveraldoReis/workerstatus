<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

defined('_JEXEC') or exit('Restricted access');

jimport('joomla.application.component.controller');

class CardapioController extends JController
{

    function display($cacheable = false, $urlparams = false)
    {
        $input = JFactory::getApplication()->input;
        $input->set('view', $input->getCmd('view', 'Cardapios'));

        parent::display($cacheable);
        
        // Set the submenu
        CardapioHelper::addSubmenu('messages');
    }

}
