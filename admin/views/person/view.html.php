<?php

defined('_JEXEC') or exit('Restricted access');



class WorkerstatusViewPerson extends SmartyView
{

    public $canDo;

    function display($tpl = null)
    {
        $this->form   = $this->get('Form');
        $this->person   = $this->get('Person');
        $this->script = $this->get('Script');
        
        $this->form->bind($this->person->id ? $this->person : JFactory::getApplication()->getUserState('com_workerstatus.person.data', array(), 'ARRAY'));
        
        $this->person->complex_price = json_decode($this->person->complex_price);

        // What Access Permissions does this user have? What can (s)he do?
        $this->canDo = WorkerstatusHelper::getActions($this->person->id);

        $this->addToolBar();

        parent::display($tpl);

        $this->setDocument();
    }

    public function addToolBar()
    {
        $input = JFactory::getApplication()->input;

        $input->set('hidemainmenu', true);

        $isNew = ($this->person->id == 0);

        JToolbarHelper::title($isNew ? JText::_('COM_WORKERSTATUS_MANAGER_PERSON_NEW') : JText::_('COM_WORKERSTATUS_MANAGER_PERSON_EDIT'));

        // Access check: is this user allowed to access the backend of this component?
        if (!JFactory::getUser()->authorise('core.manage', 'com_workerstatus'))
        {
            return JError::raiseWarning(404, JText::_('JERROR_ALERTNOAUTHOR'));
        }

        // Build the actions for new and existing records.
        if ($isNew)
        {
            // For new records, check the create permission.
            if ($this->canDo->get('core.create'))
            {
                JToolBarHelper::apply('person.apply', 'JTOOLBAR_APPLY');
                JToolBarHelper::save('person.save', 'JTOOLBAR_SAVE');
                JToolBarHelper::custom('person.save2new', 'save-new.png', 'save-new_f2.png',
                        'JTOOLBAR_SAVE_AND_NEW', false);
            }
            JToolBarHelper::cancel('person.cancel', 'JTOOLBAR_CANCEL');
        }
        else
        {
            if ($this->canDo->get('core.edit'))
            {
                // We can save the new record
                JToolBarHelper::apply('person.apply', 'JTOOLBAR_APPLY');
                JToolBarHelper::save('person.save', 'JTOOLBAR_SAVE');

                // We can save this record, but check the create permission to see
                // if we can return to make a new one.
                if ($this->canDo->get('core.create'))
                {
                    JToolBarHelper::custom('person.save2new', 'save-new.png', 'save-new_f2.png',
                            'JTOOLBAR_SAVE_AND_NEW', false);
                }
            }
            if ($this->canDo->get('core.create'))
            {
                JToolBarHelper::custom('person.save2copy', 'save-copy.png', 'save-copy_f2.png',
                        'JTOOLBAR_SAVE_AS_COPY', false);
            }
            JToolBarHelper::cancel('person.cancel', 'JTOOLBAR_CLOSE');
        }
    }

    /**
     * Method to set up the document properties
     *
     * @return void
     */
    public function setDocument()
    {
        $isNew    = ($this->person->id < 1);
        $document = JFactory::getDocument();
        $document->setTitle($isNew ? JText::_('COM_WORKERSTATUS_PERSON_CREATING') : JText::_('COM_WORKERSTATUS_PERSON_EDITING'));
        $document->addScript(JURI::root() . $this->script);
        $document->addScript(JURI::root() . "/administrator/components/com_workerstatus"
                . "/views/person/submitbutton.js");
        JText::script('COM_WORKERSTATUS_PERSON_ERROR_UNACCEPTABLE');
    }

}
