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
        $query->join('inner', '#__workerstatus_businesses AS c ON c.id = a.business_id');
        $query->from('#__workerstatus_persons AS a');
        $input            = JFactory::getApplication()->input;
        $menupersonid       = $input->getInt('Personid');  // this returns the menu id number so you can reference parameters
        $menu             = JSite::getMenu();
        $this->menuparams = $menu->getParams($menupersonid);
        if ($catid            = $this->menuparams->get('business_id'))
        {
            $catid = implode(' OR business_id = ', $catid);
            $query->where("a.business_id = $catid");
        }
        if ($carid = $this->menuparams->get('workerstatus_id'))
        {
            $carid = implode(' OR workerstatus_id = ', $carid);
            $query->where("a.workerstatus_id = $carid");
        }
        $db->setQuery($query);
        $result = $db->loadObjectList();
        return $result;
    }

    public function getSizes()
    {
        $db = JFactory::getDbo();

        $query  = $db->getQuery(true);
        $query->select('a.*');
        $query->from('#__workerstatus_sizes AS a');
        $db->setQuery($query);
        $result = $db->loadObjectList();
        $sizes  = array();

        foreach ($result as $size)
        {
            $sizes[$size->name] = $size->image;
        }
        return $sizes;
    }

    public function getPricesLabel()
    {
        $db = JFactory::getDbo();

        $query            = $db->getQuery(true);
        $query->select('a.label');
        $query->group('label');
        $query->from('#__workerstatus_prices AS a');
        $query->join('inner', '#__workerstatus_persons AS b ON b.id = a.person_id');
        $query->join('inner', '#__workerstatus_businesses AS c ON c.id = b.business_id');
        $query->join('inner', '#__workerstatus_workerstatuses AS d ON d.id = b.workerstatus_id');
        $query->where(array(
            'a.label != ""'));
        $input            = JFactory::getApplication()->input;
        $menupersonid       = $input->getInt('Personid');  // this returns the menu id number so you can reference parameters
        $menu             = JSite::getMenu();
        $this->menuparams = $menu->getParams($menupersonid);
        if ($catid            = $this->menuparams->get('business_id'))
        {
            $catid = implode(' OR c.id = ', $catid);
            $query->where("c.id = $catid");
        }
        if ($carid = $this->menuparams->get('workerstatus_id'))
        {
            $carid = implode(' OR d.id = ', $carid);
            $query->where("d.id = $carid");
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
