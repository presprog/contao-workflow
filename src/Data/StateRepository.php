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

namespace Netzmacht\Contao\Workflow\Data;

use Netzmacht\Contao\Workflow\Model\StateModel;
use Netzmacht\Workflow\Data\EntityId;
use Netzmacht\Workflow\Data\StateRepository as WorkflowStateRepository;
use Netzmacht\Workflow\Flow\State;

/**
 * Class StateRepository manages workflow states.
 *
 * @package Netzmacht\Contao\Workflow\Data
 */
class StateRepository implements WorkflowStateRepository
{
    /**
     * Find last worfklow state of an entity.
     *
     * @param EntityId $entityId The entity id.
     *
     * @return State[]
     */
    public function find(EntityId $entityId)
    {
        $collection = StateModel::findBy(
            array('tl_workflow_state.entityId=?'),
            array((string) $entityId),
            array('order' => 'tl_workflow_state.reachedAt')
        );

        $states = array();

        if ($collection) {
            while ($collection->next()) {
                $states[] = $this->createState($collection->current());
            }
        }

        return $states;
    }

    /**
     * Add a new state.
     *
     * @param State $state The new state.
     *
     * @return void
     */
    public function add(State $state)
    {
        // state is immutable. only store new states.
        if ($state->getStateId()) {
            return;
        }

        $model = $this->convertStateToModel($state);
        $model->save();

        // dynamically add state id.
        $reflector = new \ReflectionObject($state);
        $property  = $reflector->getProperty('stateId');
        $property->setAccessible(true);
        $property->setValue($state, $model->id);
    }

    /**
     * Convert state object to model representation.
     *
     * @param State $state The state being persisted.
     *
     * @return StateModel
     */
    private function convertStateToModel(State $state)
    {
        $model = new StateModel();

        $model->workflowName   = $state->getWorkflowName();
        $model->entityId       = (string) $state->getEntityId();
        $model->transitionName = $state->getTransitionName();
        $model->stepName       = $state->getStepName();
        $model->success        = $state->isSuccessful();
        $model->errors         = $this->serialize($state->getErrors());
        $model->data           = $this->serialize($state->getData());
        $model->reachedAt      = $state->getReachedAt()->getTimestamp();
        $model->tstamp         = time();

        return $model;
    }

    /**
     * Create the state object.
     *
     * @param StateModel $model The state model.
     *
     * @return State
     */
    private function createState(StateModel $model)
    {
        $reachedAt = new \DateTime();
        $reachedAt->setTimestamp($model->reachedAt);

        $state = new State(
            EntityId::fromString($model->entityId),
            $model->workflowName,
            $model->transitionName,
            $model->stepName,
            (bool) $model->success,
            (array) json_decode($model->data, true),
            $reachedAt,
            (array) json_decode($model->errors, true),
            $model->id
        );

        return $state;
    }

    /**
     * Serialize data.
     *
     * @param mixed $data The data being serialized.
     *
     * @return string
     */
    private function serialize($data)
    {
        $data = $this->prepareSerialize($data);

        return json_encode($data);
    }

    /**
     * Prepare serializsation.
     *
     * @param mixed $data The data being serialized.
     *
     * @return mixed
     */
    private function prepareSerialize($data)
    {
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                $data[$key] = $this->prepareSerialize($value);
            }
        } elseif(\Validator::isBinaryUuid($data)) {
            $data = \String::binToUuid($data);
        }

        return $data;
    }
}