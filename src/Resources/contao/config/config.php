<?php

/**
 * This Contao-Workflow extension allows the definition of workflow process for entities from different providers. This
 * extension is a workflow framework which can be used from other extensions to provide their custom workflow handling.
 *
 * @package    workflow
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2014-2017 netzmacht David Molineus
 * @license    LGPL 3.0
 * @filesource
 */

array_insert(
    $GLOBALS['BE_MOD'],
    1,
    [
        'workflow' => [
            'workflows'        => [
                'icon'       => 'bundles/netzmachtcontaoworkflow/img/workflow.png',
                'stylesheet' => 'bundles/netzmachtcontaoworkflow/css/backend.css',
                'tables'     => [
                    'tl_workflow',
                    'tl_workflow_step',
                    'tl_workflow_transition',
                    'tl_workflow_action',
                ],
            ],
            'workflow_history' => [
                'icon'       => 'system/themes/default/images/news.gif',
                'stylesheet' => 'bundles/netzmachtcontaoworkflow/css/backend.css',
                'tables'     => ['tl_workflow_state'],
            ],
        ],
    ]
);


/*
 * Permissions
 */

$GLOBALS['TL_PERMISSIONS'][] = 'workflow';


/*
 * Models
 */

$GLOBALS['TL_MODELS']['tl_workflow']            = \Netzmacht\ContaoWorkflowBundle\Model\Workflow\WorkflowModel::class;
$GLOBALS['TL_MODELS']['tl_workflow_action']     = \Netzmacht\ContaoWorkflowBundle\Model\Action\ActionModel::class;
$GLOBALS['TL_MODELS']['tl_workflow_step']       = \Netzmacht\ContaoWorkflowBundle\Model\Step\StepModel::class;
$GLOBALS['TL_MODELS']['tl_workflow_state']      = \Netzmacht\ContaoWorkflowBundle\Model\State\StateModel::class;
$GLOBALS['TL_MODELS']['tl_workflow_transition'] = \Netzmacht\ContaoWorkflowBundle\Model\Transition\TransitionModel::class;
$GLOBALS['TL_MODELS']['tl_workflow_permission'] = \Netzmacht\ContaoWorkflowBundle\Model\Permission\PermissionModel::class;