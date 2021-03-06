<?php
// No direct access
defined('_JEXEC') or die('Restricted access');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
$params = $this->form->getFieldsets('params');
?>
<form enctype="multipart/form-data" action="<?php echo JRoute::_('index.php?option=com_workerstatus&layout=edit&id=' . (int) $this->person->id); ?>"
      method="post" name="adminForm" id="workerstatus-form" class="form-validate">

    <div class="width-60 fltlft">
        <fieldset class="adminform">
            <legend><?php echo JText::_('COM_WORKERSTATUS_GENERIC_DETAILS'); ?></legend>
            <ul class="adminformlist">
                <?php foreach ($this->form->getFieldset('details') as $field): ?>
                    <li><?php
                        echo $field->label;
                        echo $field->input;
                        ?></li>
                <?php endforeach; ?>
            </ul>
        </fieldset>
    </div>

    <div class="width-40 fltrt">
        <?php
        echo JHtml::_('sliders.start', 'size-slider');
        foreach ($params as $name => $fieldset):
            echo JHtml::_('sliders.panel', JText::_($fieldset->label), $name . '-params');
            if (isset($fieldset->description) && trim($fieldset->description)):
                ?>
                <p class="tip"><?php echo $this->escape(JText::_($fieldset->description)); ?></p>
            <?php endif; ?>
            <fieldset class="panelform" >
                <ul class="adminformlist">
                    <?php foreach ($this->form->getFieldset($name) as $field) : ?>
                        <li><?php echo $field->label; ?><?php echo $field->input; ?></li>
                    <?php endforeach; ?>
                </ul>
            </fieldset>
        <?php endforeach; ?>
        <?php
        echo JHtml::_('sliders.panel', JText::_('COM_WORKERSTATUS_GROUP_LABEL_PUBLISHING_DETAILS'), 'publishing-details');
        ?>
        <fieldset class="panelform">
            <ul class="adminformlist">
                <?php foreach ($this->form->getFieldset('publish') as $field): ?>
                    <li><?php echo $field->label; ?>
                        <?php echo $field->input; ?></li>
                <?php endforeach; ?>
            </ul>
        </fieldset>

        <?php echo JHtml::_('sliders.panel', JText::_('JGLOBAL_FIELDSET_METADATA_OPTIONS'), 'metadata'); ?>
        <fieldset class="panelform">
            <ul class="adminformlist">
                <?php foreach ($this->form->getFieldset('metadata') as $field): ?>
                    <li><?php echo $field->label; ?>
                        <?php echo $field->input; ?></li>
                <?php endforeach; ?>
            </ul>
        </fieldset>
        <?php echo JHtml::_('sliders.end'); ?>
    </div>

    <!-- begin ACL definition-->

    <div class="clr"></div>

    <?php if ($this->canDo->get('core.admin')): ?>
        <div class="width-100 fltlft">
            <?php
            echo JHtml::_('sliders.start', 'permissions-sliders-' . $this->person->id,
                    array(
                'useCookie' => 1));
            ?>

            <?php
            echo JHtml::_('sliders.panel', JText::_('COM_WORKERSTATUS_FIELDSET_RULES'), 'access-rules');
            ?>
            <fieldset class="panelform">
                <?php echo $this->form->getLabel('rules'); ?>
                <?php echo $this->form->getInput('rules'); ?>
            </fieldset>

            <?php echo JHtml::_('sliders.end'); ?>
        </div>
    <?php endif; ?>

    <!-- end ACL definition-->

    <div>
        <input type="hidden" name="task" value="business.edit" />
        <?php echo JHtml::_('form.token'); ?>
    </div>
</form>

<script type="text/javascript">
    /* Override joomla.javascript, as form-validation not work with ToolBar */
    function submitbutton(pressbutton) {
        if (pressbutton == 'cancel') {
            submitform(pressbutton);
        } else {
            var f = document.adminForm;
            if (document.formvalidator.isValid(f)) {
                f.check.value = '<?php echo JUtility::getToken(); ?>'; //send token
                submitform(pressbutton);
            }
            else {
                var msg = new Array();
                msg.push('Invalid input, please verify again!');
                if ($('title').hasClass('invalid')) {
                    msg.push('<?php echo JText::_('COM_WORKERSTATUS_ERROR_SCHEDULE_TITLE_IS_REQUIRED') ?>');
                }
                alert(msg.join('\n'));
            }
        }
    }
</script>