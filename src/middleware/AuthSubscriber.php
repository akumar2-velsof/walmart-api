<?php
namespace Walmart\middleware;

use GuzzleHttp1\Event\BeforeEvent;
use GuzzleHttp1\Event\RequestEvents;
use GuzzleHttp1\Event\SubscriberInterface;
use phpseclib\Crypt\Random;
use Walmart\Auth\Signature;
use Walmart\Utils;

class AuthSubscriber implements SubscriberInterface
{
    public function getEvents()
    {
        return [
            // need to attach before request
            'before'   => ['addAuthHeaders', RequestEvents::PREPARE_REQUEST],
        ];
    }

    public function addAuthHeaders(BeforeEvent $event)
    {
        /*
         * Get Consumer ID and Private Key from auth and then unset it
         */
        $auth = $event->getClient()->getDefaultOption('auth');
        if ($auth === null) {
            throw new \Exception('Http client is missing \'auth\' parameters', 1466965269);
        }
        $consumerId = $auth[0];
        $privateKey = $auth[1];
        $event->getClient()->setDefaultOption('auth', null);

        /*
         * Get Request URL, method, and timestamp to calculate signature
         */
        $requestUrl = $event->getRequest()->getUrl();

        //decode url back to normal to nextCursor issue. automatic url encoding
        //$requestUrl = rawurldecode($requestUrl);
        $event->getRequest()->setUrl($requestUrl);

        $requestMethod = $event->getRequest()->getMethod();
        $timestamp = Utils::getMilliseconds();
        $accessToken = Signature::calculateSignature($consumerId, $privateKey, $requestUrl, $requestMethod, $timestamp);
        $authorization = base64_encode($consumerId . ":" . $privateKey);

        /*
         * Add required headers to request
         */
        $headers = [
            'WM_SVC.NAME' => 'Walmart Marketplace',
            'WM_QOS.CORRELATION_ID' => uniqid(),
            'WM_SEC.ACCESS_TOKEN' => $accessToken,
            'Authorization' => 'Basic '.$authorization,
            'Host' => 'marketplace.walmartapis.com',
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Accept' =>  'application/xml',
            'WM_SVC.VERSION' =>  '1.0.0'
        ];
        
        $currentHeaders = $event->getRequest()->getHeaders();
        $updatedHeaders = array_merge($currentHeaders, $headers);
        unset($updatedHeaders['WM_CONSUMER.CHANNEL.TYPE']);
        unset($updatedHeaders['WM_SEC.TIMESTAMP']);
        unset($updatedHeaders['User-Agent']);
        $event->getRequest()->setHeaders($updatedHeaders);
    }

}
