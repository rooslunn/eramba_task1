<?php
declare(strict_types=1);

namespace DebugKitExtras\Panel;

use Cake\Core\Configure;
use Cake\Error\Debugger;
use Cake\Event\EventInterface;
use DebugKit\DebugPanel;

class ReadConfigurePanel extends DebugPanel
{
    public $plugin = 'DebugKitExtras';

    /**
     * Panel title
     *
     * @return string
     */
    public function title(): string
    {
        return 'Config';
    }

    /**
     * Shutdown event
     *
     * @param \Cake\Event\EventInterface $event The event
     * @return void
     */
    public function shutdown(EventInterface $event): void
    {
        $filterVars = Configure::read('DebugKitExtras.filter', []);

        if (!empty($filterVars)) {
            foreach ($filterVars as $var) {
                $vars[$var] = Configure::read($var, null);
            }
        } else {
            $vars = Configure::read();
        }

        $varsMaxDepth = (int)Configure::read('DebugKit.variablesPanelMaxDepth', 5);

        $variables = [];

        foreach ($vars as $k => $v) {
            $variables[$k] = Debugger::exportVarAsNodes($v, $varsMaxDepth);
        }

        $this->_data = compact('variables', 'varsMaxDepth', 'filterVars');
    }

    /**
     * Get summary data for the variables panel.
     *
     * @return string
     */
    public function summary(): string
    {
        if (!isset($this->_data['variables'])) {
            return '0';
        }

        return (string)count($this->_data['variables']);
    }
}
