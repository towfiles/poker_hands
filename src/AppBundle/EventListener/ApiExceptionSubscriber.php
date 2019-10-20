<?php
/**
 * Created by PhpStorm.
 * User: toby
 * Date: 7/28/19
 * Time: 12:01 AM
 */

namespace App\AppBundle\EventListener;
use App\Controller\BaseController;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpFoundation\JsonResponse;

class ApiExceptionSubscriber extends BaseController implements EventSubscriberInterface
{
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $e = $event->getException();

        $response = $this->resultServerError($e->getMessage());
        $event->setResponse($response);


    }

    public static function getSubscribedEvents()
    {
        return array(
            KernelEvents::EXCEPTION => 'onKernelException'
        );
    }
}