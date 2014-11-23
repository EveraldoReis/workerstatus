<?php

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla modelform library
jimport('joomla.application.component.modeladmin');

/**
 * HelloWorld Model
 */
class WorkerstatusModelBusiness extends JModelAdmin
{

    /**
     * @var object person
     */
    protected $person;

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
        // Get the business id
        $input = JFactory::getApplication()->input;
        $id    = $input->getInt('id');
        $this->setState('business.id', $id);

        // Load the parameters.
        $params = JComponentHelper::getParams('com_workerstatus');
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
    public function getTable($type = 'Business', $prefix = 'WorkerstatusTable', $config = array())
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
        $form = $this->loadForm('com_workerstatus.business', 'business',
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
        return 'administrator/components/com_workerstatus/models/forms/business.js';
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
        $data = JFactory::getApplication()->getUserState('com_workerstatus.edit.business.data', array());
        if (empty($data))
        {
            $data = $this->getPerson();
        }
        return $data;
    }

    /**
     * Get the business
     * @return object The business to be displayed to the user
     */
    public function getPerson()
    {
        if (!isset($this->person))
        {
            $id         = $this->getState('business.id');
            $this->_db->setQuery($this->_db->getQuery(true)
                            ->from('#__workerstatus_businesses as h')
                            ->select('*')
                            ->where('h.id=' . (int) $id));
            if (!$this->person = $this->_db->loadObject())
            {
                $this->setError($this->_db->getError());
            }
            else
            {
                // Load the JSON string
                $params             = new JRegistry;
                // loadJSON is @deprecated    12.1  Use loadString passing JSON as the format instead.
                //$params->loadString($this->person->params, 'JSON');
                $params->loadJSON($this->person->params);
                $this->person->params = $params;

                // Merge global params with person params
                $params             = clone $this->getState('params');
                $params->merge($this->person->params);
                $this->person->params = $params;
            }
        }
        return parent::getItem();
    }

    /**
     * Method to check if it's OK to delete a business. Overwrites JModelAdmin::canDelete
     */
    protected function canDelete($record)
    {
        if (!empty($record->id))
        {
            $user = JFactory::getUser();
            return $user->authorise("core.delete", "com_workerstatus.business." . $record->id);
        }
    }

}
