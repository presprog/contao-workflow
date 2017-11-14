<?php

/**
 * This Contao-Workflow extension allows the definition of workflow process for entities from different providers. This
 * extension is a workflow framework which can be used from other extensions to provide their custom workflow handling.
 *
 * @package    workflow
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2014 netzmacht creative David Molineus
 * @license    LGPL 3.0
 * @filesource
 */

namespace Netzmacht\Contao\Workflow\Backend\Event;

use Netzmacht\Contao\Workflow\Model\WorkflowModel;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class GetWorkflowTypesEvent is dispatched when collection all available workflow types.
 *
 * @package Netzmacht\Contao\Workflow\Contao\Dca\Event
 */
class GetWorkflowActionsEvent extends Event
{
    const NAME = 'workflow.backend.get-workflow-types';

    /**
     * Collected workflow actions.
     *
     * @var array
     */
    private $actions = array();

    /**
     * Workflow model.
     *
     * @var WorkflowModel
     */
    private $workflowModel;

    /**
     * Construct.
     *
     * @param WorkflowModel $workflowModel Current workflow model.
     */
    public function __construct(WorkflowModel $workflowModel)
    {
        $this->workflowModel = $workflowModel;
    }

    /**
     * Get workflow model.
     *
     * @return WorkflowModel
     */
    public function getWorkflowModel()
    {
        return $this->workflowModel;
    }

    /**
     * Add a new action.
     *
     * @param string $category Category.
     * @param string $name     Action name.
     *
     * @throws \InvalidArgumentException If name does not start with 'prefix_'.
     *
     * @return $this
     */
    public function addAction($category, $name)
    {
        if (strpos($name, $category . '_') !== 0) {
            throw new \InvalidArgumentException('Action has to be prefixed with category');
        }

        if (!isset($this->actions[$category])) {
            $this->actions[$category] = array();
        }

        if (!in_array($name, $this->actions[$category])) {
            $this->actions[$category][] = $name;
        }

        return $this;
    }

    /**
     * Add new actions.
     *
     * @param string $category Category name.
     * @param array  $actions  Set of actions.
     *
     * @return $this
     */
    public function addActions($category, array $actions)
    {
        foreach ($actions as $type) {
            $this->addAction($category, $type);
        }

        return $this;
    }

    /**
     * Get all actions.
     *
     * @return array
     */
    public function getActions()
    {
        return $this->actions;
    }
}