<?php

// No direct access to this file
defined('_JEXEC') or die('Restricted Access');




class WorkerstatusViewPersons extends SmartyView
{

    public $persons;
    public $pagination;
    public $canDo;

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
        $this->canOrder  = $this->user->authorise('core.edit.state', 'com_workerstatus.person');
        $this->saveOrder = $this->listOrder == 'ordering';
        $this->params    = (isset($this->state->params)) ? $this->state->params : new JObject();
        
        JFactory::getApplication()->setUserState('com_workerstatus.price_type', 0);
        JFactory::getApplication()->setUserState('com_workerstatus.person.data', array());

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
    public function addToolBar()
    {
        $canDo = WorkerstatusHelper::getActions($this->state->get('filter.person_id'));
        $user  = JFactory::getUser();
        JToolBarHelper::title(JText::_('COM_WORKERSTATUS_MANAGER_PERSONS'));
        if ($canDo->get('core.create'))
        {
            JToolBarHelper::addNew('person.add');
        }

        if (($canDo->get('core.edit')))
        {
            JToolBarHelper::editList('person.edit');
        }

        if ($canDo->get('core.edit.state'))
        {
            JToolBarHelper::divider();
            JToolBarHelper::publish('persons.publish', 'JTOOLBAR_PUBLISH', true);
            JToolBarHelper::unpublish('persons.unpublish', 'JTOOLBAR_UNPUBLISH', true);
        }

        if ($canDo->get('core.delete'))
        {
            JToolBarHelper::deleteList('', 'persons.delete');
            JToolBarHelper::divider();
        }

        if ($canDo->get('core.admin'))
        {
            JToolBarHelper::preferences('com_workerstatus');
            JToolBarHelper::divider();
        }
    }

}
