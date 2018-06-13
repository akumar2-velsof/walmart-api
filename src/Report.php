<?php

namespace Walmart;

/**
 * Partial Walmart API client implemented with Guzzle.
 *
 * @method array list(array $config = [])
 * @method array get(array $config = [])
 * @method array getFeedItem(array $config = [])
 */
use Walmart\Auth;

class Report extends BaseClient
{

    /**
     * @param array $config
     * @param string $env
     */
    private $consumerId = '';
    private $privateKey = '';

    public function __construct(array $config = [], $env = self::ENV_PROD)
    {
        $this->wmConsumerChannelType = $config['wmConsumerChannelType'];
        $this->privateKey = $config['privateKey'];
        $this->consumerId = $config['consumerId'];

        $config = array_merge_recursive($config, [
            'description_path' => __DIR__ . '/descriptions/report.php',
            'http_client_options' => [
                'defaults' => [
                    'headers' => [
                        'WM_CONSUMER.CHANNEL.TYPE' => $this->wmConsumerChannelType,
                    ],
                ],
            ],
        ]);

        // Create the client.
        parent::__construct(
                $config, $env
        );
    }

    /**
     * @param array $items
     * @return array
     * @throws \Exception
     */
    public function getReport($type)
    {
        $requestUrl = 'https://marketplace.walmartapis.com/v2/getReport?type=' . $type;
        $walmartSignature = new \Walmart\Auth\Signature($this->consumerId, $this->privateKey, $requestUrl, 'GET');
        $time = $walmartSignature->getMilliseconds();
        $signature = $walmartSignature->calculateSignature($this->consumerId, $this->privateKey, $requestUrl, 'GET', $time);

        $headerArray = [
            'WM_SVC.NAME:Walmart Marketplace',
            'WM_SEC.TIMESTAMP:' . $time,
            'WM_SEC.AUTH_SIGNATURE:' . $signature,
            'WM_CONSUMER.ID:' . $this->consumerId,
            'WM_CONSUMER.CHANNEL.TYPE:' . $this->wmConsumerChannelType,
            'Content-Type:multipart/form-data',
            'WM_QOS.CORRELATION_ID:' . $time,
            'Accept:application/xml',
            'Host:marketplace.walmartapis.com',
        ];
        $url = $requestUrl;
        try {

            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headerArray);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
            $response = curl_exec($curl);
            $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            if($http_code == 200) {
                return $response;
            } else {
                return false;
            }
        } catch (InvalidArgumentException $e) {
            return false;
        } catch (Exception $e) {
            return false;
        }
    }

}
