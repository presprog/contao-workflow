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


use Netzmacht\Workflow\Form\Form;
use Symfony\Component\EventDispatcher\Event;

class CreateFormEvent extends Event
{
    const NAME = 'workflow.factory.create-form';

    /**
     * @var \Netzmacht\Workflow\Form\Form
     */
    private $form;

    /**
     * @var string
     */
    private $type;

    /**
     * @param $type
     */
    function __construct($type)
    {
        $this->type = $type;
    }

    /**
     * @return \Netzmacht\Workflow\Form\Form
     */
    public function getForm()
    {
        return $this->form;
    }

    /**
     * @param \Netzmacht\Workflow\Form\Form $form
     *
     * @return $this
     */
    public function setForm(Form $form)
    {
        $this->form = $form;

        return $this;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }
}
