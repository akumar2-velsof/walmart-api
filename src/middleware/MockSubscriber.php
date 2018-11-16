<?php
namespace Walmart\middleware;

use GuzzleHttp1\Event\BeforeEvent;
use GuzzleHttp1\Event\RequestEvents;
use GuzzleHttp1\Event\SubscriberInterface;
use Walmart\mock\MockResponse;

class MockSubscriber implements SubscriberInterface
{
    public function getEvents()
    {
        return [
            // need to attach before request, but after AuthSubscriber
            'before'   => ['interceptResponse', RequestEvents::PREPARE_REQUEST - 1],
        ];
    }

    public function interceptResponse(BeforeEvent $event)
    {
        $response = MockResponse::getResponse($event->getRequest());
        $event->intercept($response);
        $event->stopPropagation();
    }
}