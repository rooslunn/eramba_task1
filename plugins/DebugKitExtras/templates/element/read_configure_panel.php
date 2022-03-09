<?php

/**
 * @var \DebugKit\View\AjaxView $this
 * @var bool $sort
 * @var array $variables
 */

?>

<?php

if (isset($varsMaxDepth)) {
    $msg = sprintf(__d('debug_kit', '%s levels of nested data shown.'), $varsMaxDepth);
    $msg .= ' ' . __d('debug_kit', 'You can overwrite this via the config key');
    $msg .= ' <strong>DebugKit.variablesPanelMaxDepth</strong><br>';
    $msg .= __d('debug_kit', 'Increasing the depth value can lead to an out of memory error.');
    printf('<p class="info">%s</p>', $msg);
}

if (isset($filterVars)) {
    $msg = sprintf('Config vars filtered by: [%s]', implode(', ', $filterVars));
    printf('<p class="info">%s</p>', $msg);
}

if (!empty($variables)) {
    printf('<label class="toggle-checkbox"><input type="checkbox" class="neat-array-sort"%s>%s</label>', $sort ? ' checked="checked"' : '', __d('debug_kit', 'Sort variables by name'));
    $this->Toolbar->setSort($sort);
    echo $this->Toolbar->dumpNodes($variables);
}
