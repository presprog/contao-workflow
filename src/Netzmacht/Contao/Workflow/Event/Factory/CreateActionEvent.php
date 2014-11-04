<?php

/**
 * @package    dev
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2014 netzmacht creative David Molineus
 * @license    LGPL 3.0
 * @filesource
 *
 */

namespace Netzmacht\Contao\Workflow\Event\Factory;

use Netzmacht\Workflow\Flow\Action;
use Netzmacht\Contao\Workflow\Contao\Model\ActionModel;
use Netzmacht\Workflow\Flow\Workflow;

class CreateActionEvent
{
    const NAME = 'workflow.factory.create-action';

    /**
     * @var ActionModel
     */
    private $model;

    /**
     * @var Action
     */
    private $action;

    /**
     * Workflow the action is in
     * @var \Netzmacht\Workflow\Flow\Workflow
     */
    private $workflow;

    /**
     * Construct.
     *
     * @param \Netzmacht\Workflow\Flow\Workflow    $workflow Current workflow.
     * @param ActionModel $model    Action model.
     */
    function __construct(Workflow $workflow, ActionModel $model)
    {
        $this->workflow = $workflow;
        $this->model    = $model;
    }

    /**
     * Get the action model.
     *
     * @return ActionModel
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @return Workflow
     */
    public function getWorkflow()
    {
        return $this->workflow;
    }

    /**
     * Get the action.
     *
     * @return Action
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * Set the action.
     *
     * @param Action $action
     */
    public function setAction(Action $action)
    {
        $this->action = $action;
    }
}
