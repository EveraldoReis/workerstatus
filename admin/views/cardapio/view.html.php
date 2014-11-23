<?php

defined('_JEXEC') or exit('Restricted access');

jimport('joomla.application.component.view');

class CardapioViewCardapio extends Jview
{

    protected $canDo;

    function display($tpl = null)
    {
        $this->form   = $this->get('Form');
        $this->item   = $this->get('Item');
        $this->script = $this->get('Script');

        // What Access Permissions does this user have? What can (s)he do?
        $this->canDo = CardapioHelper::getActions($this->item->id);

        $this->addToolBar();

        parent::display($tpl);

        $this->setDocument();
    }

    protected function addToolBar()
    {
        $input = JFactory::getApplication()->input;

        $input->set('hidemainmenu', true);

        $isNew = ($this->item->id == 0);

        JToolbarHelper::title($isNew ? JText::_('COM_CARDAPIO_MANAGER_CARDAPIO_NEW') : JText::_('COM_CARDAPIO_MANAGER_CARDAPIO_EDIT'));

        // Access check: is this user allowed to access the backend of this component?
        if (!JFactory::getUser()->authorise('core.manage', 'com_cardapio'))
        {
            return JError::raiseWarning(404, JText::_('JERROR_ALERTNOAUTHOR'));
        }

        // Build the actions for new and existing records.
        if ($isNew)
        {
            // For new records, check the create permission.
            if ($this->canDo->get('core.create'))
            {
                JToolBarHelper::apply('cardapio.apply', 'JTOOLBAR_APPLY');
                JToolBarHelper::save('cardapio.save', 'JTOOLBAR_SAVE');
                JToolBarHelper::custom('cardapio.save2new', 'save-new.png', 'save-new_f2.png',
                        'JTOOLBAR_SAVE_AND_NEW', false);
            }
            JToolBarHelper::cancel('cardapio.cancel', 'JTOOLBAR_CANCEL');
        }
        else
        {
            if ($this->canDo->get('core.edit'))
            {
                // We can save the new record
                JToolBarHelper::apply('cardapio.apply', 'JTOOLBAR_APPLY');
                JToolBarHelper::save('cardapio.save', 'JTOOLBAR_SAVE');

                // We can save this record, but check the create permission to see
                // if we can return to make a new one.
                if ($this->canDo->get('core.create'))
                {
                    JToolBarHelper::custom('cardapio.save2new', 'save-new.png', 'save-new_f2.png',
                            'JTOOLBAR_SAVE_AND_NEW', false);
                }
            }
            if ($this->canDo->get('core.create'))
            {
                JToolBarHelper::custom('cardapio.save2copy', 'save-copy.png', 'save-copy_f2.png',
                        'JTOOLBAR_SAVE_AS_COPY', false);
            }
            JToolBarHelper::cancel('cardapio.cancel', 'JTOOLBAR_CLOSE');
        }
    }

    /**
     * Method to set up the document properties
     *
     * @return void
     */
    protected function setDocument()
    {
        $isNew    = ($this->item->id < 1);
        $document = JFactory::getDocument();
        $document->setTitle($isNew ? JText::_('COM_CARDAPIO_CARDAPIO_CREATING') : JText::_('COM_CARDAPIO_CARDAPIO_EDITING'));
        $document->addScript(JURI::root() . $this->script);
        $document->addScript(JURI::root() . "/administrator/components/com_cardapio"
                . "/views/cardapio/submitbutton.js");
        JText::script('COM_CARDAPIO_CARDAPIO_ERROR_UNACCEPTABLE');
    }

}