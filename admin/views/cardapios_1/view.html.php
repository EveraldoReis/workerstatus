<?php

// No direct access to this file
defined('_JEXEC') or die('Restricted Access');

// import Joomla view library
jimport('joomla.application.component.view');

class CardapioViewCardapios extends JView
{

    protected $items;
    protected $pagination;
    protected $canDo;

    function display($tpl = null)
    {
        $this->items      = $this->get('Items');
        $this->pagination = $this->get('Pagination');
        $this->state      = $this->get('State');

        //Following variables used more than once
        $this->sortColumn    = $this->state->get('list.ordering');
        $this->sortDirection = $this->state->get('list.direction');
        $this->searchterms   = $this->state->get('filter.search');

        $this->user      = JFactory::getUser();
        $this->userId    = $this->user->get('id');
        $this->listOrder = $this->escape($this->state->get('list.ordering'));
        $this->listDirn  = $this->escape($this->state->get('list.direction'));
        $this->canOrder  = $this->user->authorise('core.edit.state', 'com_cardapio.cardapio');
        $this->saveOrder = $this->listOrder == 'ordering';
        $this->params    = (isset($this->state->params)) ? $this->state->params : new JObject();

        // What Access Permissions does this user have? What can (s)he do?
        $this->canDo = CardapioHelper::getActions();

        if (count($errors = $this->get('Erros')))
        {
            JError::raiseError(500, implode('</br>', $erros));
            return false;
        }

        $this->addToolBar();

        parent::display($tpl);
    }

    /**
     * Setting the toolbar
     */
    protected function addToolBar()
    {
        $canDo = CardapioHelper::getActions($this->state->get('filter.cardapio_id'));
        $user  = JFactory::getUser();
        JToolBarHelper::title(JText::_('COM_CARDAPIO_MANAGER_CARDAPIOS'));
        if ($canDo->get('core.create'))
        {
            JToolBarHelper::addNew('cardapio.add');
        }

        if (($canDo->get('core.edit')))
        {
            JToolBarHelper::editList('cardapio.edit');
        }

        if ($canDo->get('core.edit.state'))
        {
            JToolBarHelper::divider();
            JToolBarHelper::publish('cardapios.publish', 'JTOOLBAR_PUBLISH', true);
            JToolBarHelper::unpublish('cardapios.unpublish', 'JTOOLBAR_UNPUBLISH', true);
        }

        if ($canDo->get('core.delete'))
        {
            JToolBarHelper::deleteList('', 'cardapios.delete');
            JToolBarHelper::divider();
        }

        if ($canDo->get('core.admin'))
        {
            JToolBarHelper::preferences('com_cardapios');
            JToolBarHelper::divider();
        }
    }

}