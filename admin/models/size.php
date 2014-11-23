<?php

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla modelform library
jimport('joomla.application.component.modeladmin');

/**
 * HelloWorld Model
 */
class CardapioModelSize extends JModelAdmin
{

    /**
     * @var object item
     */
    protected $item;

    /**
     * Method to auto-populate the model state.
     *
     * This method should only be called once per instantiation and is designed
     * to be called on the first call to the getState() method unless the model
     * configuration flag to ignore the request is set.
     *
     * Note. Calling getState in this method will result in recursion.
     *
     * @return      void
     * @since       2.5
     */
    protected function populateState()
    {
        $app   = JFactory::getApplication();
        // Get the size id
        $input = JFactory::getApplication()->input;
        $id    = $input->getInt('id');
        $this->setState('size.id', $id);

        // Load the parameters.
        $params = JComponentHelper::getParams('com_cardapio');
        $this->setState('params', $params);
        parent::populateState();
    }

    /**
     * Returns a reference to the a Table object, always creating it.
     *
     * @param       type    The table type to instantiate
     * @param       string  A prefix for the table class name. Optional.
     * @param       array   Configuration array for model. Optional.
     * @return      JTable  A database object
     * @since       2.5
     */
    public function getTable($type = 'Size', $prefix = 'CardapioTable', $config = array())
    {
        return JTable::getInstance($type, $prefix, $config);
    }

    /**
     * Method to get the record form.
     *
     * @param       array   $data           Data for the form.
     * @param       boolean $loadData       True if the form is to load its own data (default case), false if not.
     * @return      mixed   A JForm object on success, false on failure
     * @since       2.5
     */
    public function getForm($data = array(), $loadData = true)
    {
        // Get the form.
        $form = $this->loadForm('com_cardapio.size', 'size',
                array(
            'control'   => 'jform',
            'load_data' => $loadData));
        if (empty($form))
        {
            return false;
        }
        return $form;
    }

    /**
     * Method to get the script that have to be included on the form
     *
     * @return string       Script files
     */
    public function getScript()
    {
        return 'administrator/components/com_cardapio/models/forms/size.js';
    }

    /**
     * Method to get the data that should be injected in the form.
     *
     * @return      mixed   The data for the form.
     * @since       2.5
     */
    protected function loadFormData()
    {
        // Check the session for previously entered form data.
        $data = JFactory::getApplication()->getUserState('com_cardapio.edit.size.data', array());
        if (empty($data))
        {
            $data = $this->getItem();
        }
        return $data;
    }

    /**
     * Get the size
     * @return object The size to be displayed to the user
     */
    public function getItem()
    {
        if (!isset($this->item))
        {
            $id         = $this->getState('size.id');
            $this->_db->setQuery($this->_db->getQuery(true)
                            ->from('#__cardapio_sizes as h')
                            ->select('*')
                            ->where('h.id=' . (int) $id));
            if (!$this->item = $this->_db->loadObject())
            {
                $this->setError($this->_db->getError());
            }
            else
            {
                // Load the JSON string
                $params             = new JRegistry;
                // loadJSON is @deprecated    12.1  Use loadString passing JSON as the format instead.
                //$params->loadString($this->item->params, 'JSON');
                $params->loadJSON($this->item->params);
                $this->item->params = $params;

                // Merge global params with item params
                $params             = clone $this->getState('params');
                $params->merge($this->item->params);
                $this->item->params = $params;
            }
        }
        return parent::getItem();
    }

    /**
     * Method to check if it's OK to delete a size. Overwrites JModelAdmin::canDelete
     */
    protected function canDelete($record)
    {
        if (!empty($record->id))
        {
            $user = JFactory::getUser();
            return $user->authorise("core.delete", "com_cardapio.size." . $record->id);
        }
    }

}
