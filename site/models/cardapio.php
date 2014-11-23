<?php

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla modelitem library
jimport('joomla.application.component.modelitem');

/**
 * HelloWorld Model
 */
class CardapioModelItem extends JModelItem
{

    public $menuparams;

    public function getTable($type = 'Item', $prefix = 'CardapioTable', $config = array())
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
        $query->from('#__cardapio_items');
        return $query;
    }

    public function getItems()
    {
        $db = JFactory::getDbo();

        $query            = $db->getQuery(true);
        $query->select('a.*');
        $query->join('inner', '#__cardapio_cardapios AS c ON c.id = a.cardapio_id');
        $query->from('#__cardapio_items AS a');
        $input            = JFactory::getApplication()->input;
        $menuitemid       = $input->getInt('Itemid');  // this returns the menu id number so you can reference parameters
        $menu             = JSite::getMenu();
        $this->menuparams = $menu->getParams($menuitemid);
        if ($catid            = $this->menuparams->get('id'))
        {
            $catid = implode(' OR id = ', $catid);
            $query->where("a.id = $catid");
        }
        
        $id       = $input->getInt('id');
        if ($id)
        {
            $query->where("a.id = $id");
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
            $this->_pagination = new JPagination(count($this->getItems()), $this->getState('limitstart'),
                    $this->getState('limit'));
        }
        return $this->_pagination;
    }

    public function getPricesLabel()
    {
        $db = JFactory::getDbo();

        $query            = $db->getQuery(true);
        $query->select('a.label');
        $query->group('label');
        $query->from('#__cardapio_prices AS a');
        $query->join('inner', '#__cardapio_items AS b ON b.id = a.item_id');
        $query->where(array('a.label != ""'));
        $input            = JFactory::getApplication()->input;
        $menuitemid       = $input->getInt('Itemid');  // this returns the menu id number so you can reference parameters
        $menu             = JSite::getMenu();
        $this->menuparams = $menu->getParams($menuitemid);
        if ($catid            = $this->menuparams->get('id'))
        {
            $catid = implode(' OR b.id = ', $catid);
            $query->where("b.id = $catid");
        }
        
        $id       = $input->getInt('id');
        if ($id)
        {
            $query->where("b.id = $id");
        }
        $db->setQuery($query);
        $result = $db->loadObjectList();
        return $result;
    }

}
