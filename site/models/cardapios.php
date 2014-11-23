<?php

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla modelperson library
jimport('joomla.application.component.modelperson');

/**
 * HelloWorld Model
 */
class WorkerstatusModelPersons extends JModelPerson
{

    public $menuparams;

    public function getTable($type = 'Person', $prefix = 'WorkerstatusTable', $config = array())
    {
        return JTable::getInstance($type, $prefix, $config);
    }

    protected function getListQuery()
    {
        // Create a new query object.
        $db    = JFactory::getDBO();
        $query = $db->getQuery(true);
        // Select some fields
        $query->select('*');
        // From the hello table
        $query->from('#__workerstatus_persons');
        return $query;
    }

    public function getPersons()
    {
        $db = JFactory::getDbo();

        $query            = $db->getQuery(true);
        $query->select('a.*');
        $query->join('inner', '#__workerstatus_workerstatuses AS c ON c.id = a.workerstatus_id');
        $query->from('#__workerstatus_persons AS a');
        $input            = JFactory::getApplication()->input;
        $menupersonid       = $input->getInt('Personid');  // this returns the menu id number so you can reference parameters
        $menu             = JSite::getMenu();
        $this->menuparams = $menu->getParams($menupersonid);
        if ($catid            = $this->menuparams->get('workerstatus_id'))
        {
            $catid = implode(' OR workerstatus_id = ', $catid);
            $query->where("a.workerstatus_id = $catid");
        }
        $db->setQuery($query);
        $result = $db->loadObjectList();
        return $result;
    }

    public function getPricesLabel()
    {
        $db = JFactory::getDbo();

        $query            = $db->getQuery(true);
        $query->select('a.label');
        $query->group('label');
        $query->from('#__workerstatus_prices AS a');
        $query->join('inner', '#__workerstatus_persons AS b ON b.id = a.person_id');
        $query->join('inner', '#__workerstatus_workerstatuses AS c ON c.id = b.workerstatus_id');
        $query->where(array('a.label != ""'));
        $input            = JFactory::getApplication()->input;
        $menupersonid       = $input->getInt('Personid');  // this returns the menu id number so you can reference parameters
        $menu             = JSite::getMenu();
        $this->menuparams = $menu->getParams($menupersonid);
        if ($catid            = $this->menuparams->get('workerstatus_id'))
        {
            $catid = implode(' OR c.id = ', $catid);
            $query->where("c.id = $catid");
        }
        $db->setQuery($query);
        $result = $db->loadObjectList();
        return $result;
    }

    // Get pagination
    function getPagination()
    {
        // Lets load the content if it doesn't already exist
        if (empty($this->_pagination))
        {
            jimport('joomla.html.pagination');
            $this->_pagination = new JPagination(count($this->getPersons()), $this->getState('limitstart'),
                    $this->getState('limit'));
        }
        return $this->_pagination;
    }

}
