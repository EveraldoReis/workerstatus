<?php

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla modelitem library
jimport('joomla.application.component.modelitem');

/**
 * HelloWorld Model
 */
class CardapioModelItems extends JModelItem
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
        if ($catid            = $this->menuparams->get('cardapio_id'))
        {
            $catid = implode(' OR cardapio_id = ', $catid);
            $query->where("a.cardapio_id = $catid");
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
        $query->from('#__cardapio_prices AS a');
        $query->join('inner', '#__cardapio_items AS b ON b.id = a.item_id');
        $query->join('inner', '#__cardapio_cardapios AS c ON c.id = b.cardapio_id');
        $query->where(array('a.label != ""'));
        $input            = JFactory::getApplication()->input;
        $menuitemid       = $input->getInt('Itemid');  // this returns the menu id number so you can reference parameters
        $menu             = JSite::getMenu();
        $this->menuparams = $menu->getParams($menuitemid);
        if ($catid            = $this->menuparams->get('cardapio_id'))
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
            $this->_pagination = new JPagination(count($this->getItems()), $this->getState('limitstart'),
                    $this->getState('limit'));
        }
        return $this->_pagination;
    }

}
