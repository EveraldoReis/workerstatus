<fieldset id="filter-bar">
    <div class="filter-search fltlft">
        <input type="text" name="filter_search" id="filter_search" value="<?php echo $this->escape($this->searchterms); ?>" title="<?php echo JText::_('Search in company, etc.'); ?>" />
        <button type="submit">
            <?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?>
        </button>
        <button type="button" onclick="document.id('filter_search').value = '';
                this.form.submit();">
                    <?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?>
        </button>
    </div>
</fieldset>