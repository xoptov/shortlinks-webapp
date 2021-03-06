<?php

namespace App\EventListener;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ContentRequestSubscriber implements EventSubscriberInterface
{
    /**
     * @inheritDoc
     */
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => 'onKernelRequest'
        ];
    }

    /**
     * @param RequestEvent $event
     */
    public function onKernelRequest(RequestEvent $event): void
    {
        if (!$event->isMasterRequest()) {
            return;
        }

        $request = $event->getRequest();

        if ('application/json' !== $request->headers->get('content-type')) {
            return;
        }

        $params = json_decode($request->getContent(), true);

        if (empty($params)) {
            return;
        }

        //todo: тут заточил только под POST метод иначе можно утонуть в over engineering.
        if ($request->isMethod(Request::METHOD_POST)) {
            $this->fillBag($request->request, $params);
        }
    }

    /**
     * @param ParameterBag $bag
     * @param array        $params
     */
    public function fillBag(ParameterBag $bag, array &$params): void
    {
        foreach ($params as $key => $value) {
            $bag->set($key, $value);
        }
    }
}