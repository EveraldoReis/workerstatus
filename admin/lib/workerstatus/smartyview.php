<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

jimport('joomla.application.component.view');

class SmartyView extends JView
{

    public $smarty;

    /**
     * Layout extension
     *
     * @var    string
     */
    protected $_layoutExt = 'tpl';

    function __construct($config = array())
    {
        parent::__construct($config);
        $path                         = end($this->_path['template']);
        $this->smarty                 = new Smarty;
        $this->smarty->caching        = true;
        $this->smarty->cache_lifetime = 30;
        $this->smarty
                ->setCacheDir(JPATH_CACHE . DS . 'com_workerstatus')
                ->setCompileDir(JPATH_COMPONENT . DS . 'template_c')
                ->setTemplateDir($path);
        $this->smarty->assign('this', $this);
    }

    function display($tpl = null)
    {
        $tpl = $tpl ? $tpl : $this->getLayout();
        $this->smarty->display($tpl . '.' . $this->_layoutExt);
    }

    function loadTemplate($tpl = null)
    {
        $tmpl = $this->smarty->getTemplateDir();
        $this->smarty->display($this->getLayout() . $this->getLayoutTemplate() . $tpl . '.' . $this->_layoutExt);
    }

}
