<?php

use Netzmacht\Contao\Workflow\Factory;

define('TL_MODE', 'BE');
error_reporting('E_ALL');
ini_set('display_errors', '1');

require_once '/var/www/html/dev/workflow/system/initialize.php';

/** @var Factory $factory */
$factory = $GLOBALS['container']['workflow.factory'];

$manager  = $factory->createManager('default');
$workflow = $manager->getWorkflowByName('test');
$entity   = $factory->createEntity(\ContentModel::findByPk(1));
$item     = $manager->createItem($entity);
$handler  = $manager->handle($item, 'publish');
$stepName = $handler->getItem()->getCurrentStepName();
$step     = $workflow->getStep($stepName);

$GLOBALS['container']['event-dispatcher']->addListener(
    \Netzmacht\Contao\Workflow\Event\Action\ExecuteTransitionEvent::NAME,
    function ($event) {
        var_dump($event->getTransition()->getRoles());
    }
);

$workflow->getTransition('publish')->getActions()[0]->transit(
    $workflow->getTransition('publish'),
    $item,
    $handler->getContext()
);



//if ($handler->validate()) {
//    if ($handler->isWorkflowStarted()) {
//        $state = $handler->transit('publish');
//    }
//    else {
//        $handler->start();
//    }
//}
//else {
//    if ($handler->requiresInputData()) {
//        $view = new View();
//        echo $handler->getForm()->render($view);
//    }
//    else {
//        echo 'Something went wrong';
//    }
//}
