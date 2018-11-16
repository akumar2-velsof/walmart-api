<?php
namespace Walmart\middleware;

use GuzzleHttp1\Event\CompleteEvent;
use GuzzleHttp1\Event\RequestEvents;
use GuzzleHttp1\Event\SubscriberInterface;
use GuzzleHttp1\Stream\Stream;
use Walmart\Utils;

class XmlNamespaceSubscriber implements SubscriberInterface
{
    public function getEvents()
    {
        return [
            // need to attach after response
            'complete' => ['stripXmlNamespaces', RequestEvents::VERIFY_RESPONSE - 1],
        ];
    }

    public function stripXmlNamespaces(CompleteEvent $event)
    {
        /**
         * Parsing XML with namespaces doesn't seem to work for Guzzle,
         * so using regex to remove them.
         */
        $xml = $event->getResponse()->getBody()->getContents();
        $xml = Utils::stripNamespacesFromXml($xml);

        /**
         * Intercept response and replace body with cleaned up XML
         */
        $stream = Stream::factory($xml);
        $response = $event->getResponse();
        $response->setBody($stream);
        $event->intercept($response);
    }

}