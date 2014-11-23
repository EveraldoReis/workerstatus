<fieldset id="filter-bar">
    <div class="filter-search fltlft">
        <input type="text" name="filter_search" id="filter_search" value="{$this->escape($this->searchterms)}" title="{JText::_('Search in company, etc.')}" />
        <button type="submit">
            {JText::_('JSEARCH_FILTER_SUBMIT')}
        </button>
        <button type="button" onclick="document.id('filter_search').value = '';
                this.form.submit();">
            {JText::_('JSEARCH_FILTER_CLEAR')}
        </button>
    </div>
</fieldset>