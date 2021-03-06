<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

jimport('joomla.application.component.controllerform');

class WorkerstatusControllerPerson extends JControllerForm
{
    
    function __construct($config = array())
    {
        parent::__construct($config);
        $this->registerTask('reload', 'reload');
        $this->registerTask('rpt', 'reset_price_type');
    }
 
    /**
     * Implement to allowAdd or not 
     *
     * Not used at this time (but you can look at how other components use it....)
     * Overwrites: JControllerForm::allowAdd
     *
     * @param array $data
     * @return bool
     */
    protected function allowAdd($data = array())
    {
        return parent::allowAdd($data);
    }

    /**
     * Implement to allow edit or not
     * Overwrites: JControllerForm::allowEdit
     *
     * @param array $data
     * @param string $key
     * @return bool
     */
    protected function allowEdit($data = array(), $key = 'id')
    {
        $id = isset($data[$key]) ? $data[$key] : 0;
        if (!empty($id))
        {
            $user = JFactory::getUser();
            return $user->authorise("core.edit", "com_workerstatus.person." . $id);
        }
    }

    function reload()
    {
        $input = JFactory::getApplication()->input->get('jform', array(), 'ARRAY');
        JFactory::getApplication()->setUserState('com_workerstatus.price_type', $input['price_type']);
        JFactory::getApplication()->setUserState('com_workerstatus.person.data', $input);
        header('location: index.php?option=com_workerstatus&layout=edit&view=person&price_type='.$input['price_type']);
    }

    function reset_price_type()
    {
        $input = JFactory::getApplication()->input->get('jform', array(), 'ARRAY');
        JFactory::getApplication()->setUserState('com_workerstatus.price_type', 0);
        JFactory::getApplication()->setUserState('com_workerstatus.person.data', $input);
        header('location: index.php?option=com_workerstatus&layout=edit&view=person');
    }

    function cancel($key = null)
    {
        parent::cancel($key);
        JFactory::getApplication()->setUserState('com_workerstatus.price_type', 0);
    }

}
