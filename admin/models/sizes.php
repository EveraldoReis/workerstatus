<?php

// No direct access to this file
defined('_JEXEC') or die('Restricted access');
// import the Joomla modellist library
jimport('joomla.application.component.modellist');

/**
 * HelloWorldList Model
 */
class WorkerstatusModelSizes extends JModelList
{

    //Add this handy array with database fields to search in
    protected $searchInFields = array(
        'a.name'
    );

    //Override construct to allow filtering and ordering on our fields
    public function __construct($config = array())
    {
        if (empty($config['filter_fields']))
        {
            $config['filter_fields'] = array(
                'a.id',
                'a.name',
                'a.alias',
                'a.state',
                'a.ordering',
                'a.language',
                'a.checked_out',
                'a.checked_out_time',
                'a.created',
                'a.views',
                'a.publish_up',
                'a.publish_down',
                'a.state',
            );
        }

        parent::__construct($config);
    }

    /**
     * Returns a reference to the a Table object, always creating it.
     *
     * @param	type	The table type to instantiate
     * @param	string	A prefix for the table class name. Optional.
     * @param	array	Configuration array for model. Optional.
     * @return	JTable	A database object
     * @since	1.6
     */
    public function getTable($type = 'Size', $prefix = 'WorkerstatusTable', $config = array())
    {
        return JTable::getInstance($type, $prefix, $config);
    }

    /**
     * Method to build an SQL query to load the list data.
     *
     * @return      string  An SQL query
     */
    protected function getListQuery()
    {
        $db    = JFactory::getDBO();
        $query = $db->getQuery(true);

        //CHANGE THIS QUERY AS YOU NEED...
        $query->select('*')
                ->from('#__workerstatus_sizes AS a')
                ->order($db->escape($this->getState('list.ordering', 'a.cid')) . ' ' .
                        $db->escape($this->getState('list.direction', 'desc')));



        // Filter search // Extra: Search more than one fields and for multiple words
        $regex = str_replace(' ', '|', $this->getState('filter.search'));
        if (!empty($regex))
        {
            $regex = ' REGEXP ' . $db->quote($regex);
            $query->where('(' . implode($regex . ' OR ', $this->searchInFields) . $regex . ')');
        }

        // Filter company
        $company = $db->escape($this->getState('filter.name'));
        if (!empty($company))
        {
            $query->where('(a.name=' . $company . ')');
        }

        // Filter language
        $language = $db->escape($this->getState('filter.language'));
        if (!empty($language))
        {
            $query->where('(a.language=' . $language . ')');
        }

        // Filter by state (published, trashed, etc.)
        $state = $db->escape($this->getState('filter.state'));
        if (is_numeric($state))
        {
            $query->where('a.state = ' . (int) $state);
        }
        elseif ($state === '')
        {
            $query->where('(a.state = 0 OR a.state = 1)');
        }

        //echo $db->replacePrefix( (string) $query );//debug
        return $query;
    }

    /**
     * Method to get a store id based on model configuration state.
     *
     * This is necessary because the model is used by the component and
     * different modules that might need different sets of data or different
     * ordering requirements.
     *
     * @param	string		$id	A prefix for the store id.
     * @return	string		A store id.
     * @since	1.6
     */
    protected function getStoreId($id = '')
    {
        // Compile the store id.
        $id .= ':' . $this->getState('filter.search');
        $id .= ':' . $this->getState('filter.access');
        $id .= ':' . $this->getState('filter.cid');
        $id .= ':' . $this->getState('filter.state');
        $id .= ':' . $this->getState('filter.language');

        return parent::getStoreId($id);
    }

    /**
     * Method to auto-populate the model state.
     *
     * Note. Calling getState in this method will result in recursion.
     *
     * @since       1.6
     */
    protected function populateState($ordering = null, $direction = null)
    {
        // Initialise variables.
        $app = JFactory::getApplication('administrator');

        // Load the filter state.
        $search = $app->getUserStateFromRequest($this->context . '.filter.search', 'filter_search');
        //Omit double (white-)spaces and set state
        $this->setState('filter.search', preg_replace('/\s+/', ' ', $search));

        //Filter (dropdown) state
        $state = $app->getUserStateFromRequest($this->context . '.filter.state', 'filter_state', '', 'string');
        $this->setState('filter.state', $state);

        //Filter (dropdown) languge
        $language = $app->getUserStateFromRequest($this->context . '.filter.language', 'filter_language', '', 'string');
        $this->setState('filter.language', $language);

        //Takes care of states: list. limit / start / ordering / direction
        parent::populateState('a.name', 'asc');
    }

    function publish($cid, $value)
    {
        $cids   = implode("','", $cid);
        $db     = JFactory::getDBO();
        $query  = $db->getQuery(true);
        $query->update('#__workerstatus_sizes');
        $query->set(array($db->quoteName('state') . '=' . $value));
        $query->where(array(
            "id IN ('$cids')"));
        $db->setQuery($query);
        return $result = $db->query();
    }

    function delete($cid)
    {
        $cids   = implode("','", $cid);
        $db     = JFactory::getDBO();
        $query  = $db->getQuery(true);
        $query->delete('#__workerstatus_sizes');
        $query->where(array(
            "id IN ('$cids')"));
        $db->setQuery($query);
        return $result = $db->query();
    }
    
    function reorder($ids, $inc){
        return true;
    }
    
    function saveorder($pks, $order){
        
    }
    
    function checkin($ids){
        
    }

}
