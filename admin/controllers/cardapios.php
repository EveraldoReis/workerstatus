<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

jimport('joomla.application.component.controlleradmin');

class CardapioControllerCardapios extends JControllerAdmin
{

    /**
     * Proxy for getModel.
     * @since	1.6
     */
    public function getModel($name = 'Cardapios', $prefix = 'CardapioModel')
    {
        $model = parent::getModel($name, $prefix, array(
                    'ignore_request' => true));
        return $model;
    }

}
