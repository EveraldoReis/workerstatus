<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



class WorkerstatusViewPersons extends SmartyView
{

    public $labels = array();

    function display($tpl = null)
    {

        $this->persons      = $this->get('Persons');
        $this->pagination = $this->get('Pagination');
        $this->sizes = $this->get('Sizes');

        $this->labels = $this->get('PricesLabel');

        $this->document = JFactory::getDocument();

        $this->document->addStyleDeclaration('#person:last-child hr{display: none;}');

        $this->baseUrl = JUri::base();
        
        parent::display($tpl);
    }

}
