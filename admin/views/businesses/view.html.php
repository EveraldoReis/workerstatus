<?php

// No direct access to this file
defined('_JEXEC') or die('Restricted Access');


class WorkerstatusViewBusinesses extends SmartyView
{

    protected $persons;
    protected $pagination;
    protected $canDo;

    function display($tpl = null)
    {
        $this->persons      = $this->get('Persons');
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
        $this->canOrder  = $this->user->authorise('core.edit.state', 'com_workerstatus.business');
        $this->saveOrder = $this->listOrder == 'ordering';
        $this->params    = (isset($this->state->params)) ? $this->state->params : new JObject();

        // What Access Permissions does this user have? What can (s)he do?
        $this->canDo = WorkerstatusHelper::getActions();

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
        $canDo = WorkerstatusHelper::getActions($this->state->get('filter.business_id'));
        $user  = JFactory::getUser();
        JToolBarHelper::title(JText::_('COM_WORKERSTATUS_MANAGER_BUSINESSES'));
        if ($canDo->get('core.create'))
        {
            JToolBarHelper::addNew('business.add');
        }

        if (($canDo->get('core.edit')))
        {
            JToolBarHelper::editList('business.edit');
        }

        if ($canDo->get('core.edit.state'))
        {
            JToolBarHelper::divider();
            JToolBarHelper::publish('businesses.publish', 'JTOOLBAR_PUBLISH', true);
            JToolBarHelper::unpublish('businesses.unpublish', 'JTOOLBAR_UNPUBLISH', true);
        }

        if ($canDo->get('core.delete'))
        {
            JToolBarHelper::deleteList('', 'businesses.delete');
            JToolBarHelper::divider();
        }

        if ($canDo->get('core.admin'))
        {
            JToolBarHelper::preferences('com_businesses');
            JToolBarHelper::divider();
        }
    }

}
