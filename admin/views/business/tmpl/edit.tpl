{JHtml::_('behavior.tooltip')}
{JHtml::_('behavior.formvalidation')}
{assign params $this->form->getFieldsets('params')}
<form enctype="multipart/form-data" action="{JRoute::_('index.php?option=com_workerstatus&layout=edit&id={$this->person->id}')}"
      method="post" name="adminForm" id="workerstatus-form" class="form-validate">

    <div class="width-60 fltlft">
        <fieldset class="adminform">
            <legend>{JText::_('COM_WORKERSTATUS_GENERIC_DETAILS')}</legend>
            <ul class="adminformlist">
                {foreach from=$this->form->getFieldset('details') item=field}
                    <li>
                        {$field->label}
                        {$field->input}
                    </li>
                {/foreach}
            </ul>
        </fieldset>
    </div>

    <div class="width-40 fltrt">
        {JHtml::_('sliders.start', 'business-slider')}
        {foreach from=$params key=name item=fieldset}
            {JHtml::_('sliders.panel', JText::_($fieldset->label), '{$name}-params')}
            {if isset($fieldset->description) && trim($fieldset->description)}
                ?>
                <p class="tip">{$this->escape(JText::_($fieldset->description))}</p>
            {/if}
            <fieldset class="panelform" >
                <ul class="adminformlist">
                    {foreach from=$this->form->getFieldset($name) item=field}
                        <li>
                            {$field->label}
                            {$field->input}
                        </li>
                    {/foreach}
                </ul>
            </fieldset>
        {/foreach}
        {JHtml::_('sliders.panel', JText::_('COM_WORKERSTATUS_GROUP_LABEL_PUBLISHING_DETAILS'), 'publishing-details')}
        <fieldset class="panelform">
            <ul class="adminformlist">
                {foreach from=$this->form->getFieldset('publish') item=field}
                    <li>
                        {$field->label}
                        {$field->input}
                    </li>
                {/foreach}
            </ul>
        </fieldset>

        {JHtml::_('sliders.panel', JText::_('JGLOBAL_FIELDSET_METADATA_OPTIONS'), 'metadata')}
        <fieldset class="panelform">
            <ul class="adminformlist">
                {foreach from=$this->form->getFieldset('metadata') item=field}
                    <li>
                        {$field->label}
                        {$field->input}
                    </li>
                {/foreach}
            </ul>
        </fieldset>
        {JHtml::_('sliders.end')}
    </div>

    <!-- begin ACL definition-->

    <div class="clr"></div>

    {if $this->canDo->get('core.admin')}
        <div class="width-100 fltlft">
            {JHtml::_('sliders.start', 'permissions-sliders-{$this->person->id}', {['useCookie' => 1]})}

            {JHtml::_('sliders.panel', JText::_('COM_WORKERSTATUS_FIELDSET_RULES'), 'access-rules')}
            <fieldset class="panelform">
                {$this->form->getLabel('rules')}
                {$this->form->getInput('rules')}
            </fieldset>

            {JHtml::_('sliders.end')}
        </div>
    {/if}

    <!-- end ACL definition-->

    <div>
        <input type="hidden" name="task" value="business.edit" />
        {JHtml::_('form.token')}
    </div>
</form>
{literal}
    <script type="text/javascript">
        /* Override joomla.javascript, as form-validation not work with ToolBar */
        function submitbutton(pressbutton) {
        if (pressbutton == 'cancel') {
        submitform(pressbutton);
        } else {
        var f = document.adminForm;
                if (document.formvalidator.isValid(f)) {
        f.check.value = '{JUtility::getToken()}'; //send token
                submitform(pressbutton);
        }
        else {
        var msg = new Array();
                msg.push('Invalid input, please verify again!');
                if ($('title').hasClass('invalid')) {
        msg.push('{JText::_('COM_WORKERSTATUS_ERROR_SCHEDULE_TITLE_IS_REQUIRED') ?>');
        }
        alert(msg.join('\n'));
        }
        }
        }
    </script>
{/literal}