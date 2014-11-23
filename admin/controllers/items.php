<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

jimport('joomla.application.component.controlleradmin');

class CardapioControllerItems extends JControllerAdmin
{

    function __construct($config = array())
    {
        parent::__construct($config);
        JFactory::getApplication()->setUserState('com_cardapio.price_type', 0);
        JFactory::getApplication()->setUserState('com_cardapio.item.data', array());
    }
    /**
     * Proxy for getModel.
     * @since	1.6
     */
    public function getModel($name = 'Items', $prefix = 'CardapioModel')
    {
        $model = parent::getModel($name, $prefix, array(
                    'ignore_request' => true));
        return $model;
    }

}
