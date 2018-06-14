<?php
namespace Walmart;

use knowband\A2X;
use GuzzleHttp\Post\PostFile;

/**
 * Partial Walmart API client implemented with Guzzle.
 *
 * @method array update(array $config = [])
 */
class Promo extends BaseClient
{
    /**
     * @param array $config
     * @param string $env
     */
    public function __construct(array $config = [], $env = self::ENV_PROD)
    {
        // Apply some defaults.

        $this->wmConsumerChannelType = $config['wmConsumerChannelType'];
        
        $config = array_merge_recursive($config, [
            'description_path' => __DIR__ . '/descriptions/promo.php',
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
            $config,
            $env
        );

    }

    /**
     * @param array $items
     * @return array
     * @throws \Exception
     */
    public function updatePromoPrice($items)
    {
        if ( ! is_array($items)) {
            throw new \Exception('Items is not an array', 1466349195);
        }

        $schema = [
            '/PriceFeed/Price' => [
                'sendItemsAs' => 'Price',
                'includeWrappingTag' => false,
            ],
            '/PriceFeed/Price/Price/pricingList' => [
                'attributes' => [
                    'replaceAll'
                ],
            ],
            '/PriceFeed/Price/Price/pricingList/pricing' => [
                'attributes' => [
                    'effectiveDate', 'expirationDate', 'processMode', 'promoId'
                ],
            ],
            '/PriceFeed/Price/Price/pricingList/pricing/currentPrice/value' => [
                'attributes' => [
                    'currency', 'amount',
                ],
            ],
            '/PriceFeed/Price/Price/pricingList/pricing/comparisonPrice/value' => [
                'attributes' => [
                    'currency', 'amount',
                ],
            ],
            '/PriceFeed/Price/Price/pricingList/pricing/priceDisplayCode' => [
                'attributes' => [
                    'submapType',
                ],
            ],
        ];

        $a2x = new A2X($items, $schema);
        $xml = $a2x->asXml();
//        echo $xml;die;
        $file = new PostFile('file', $xml, 'file.xml', ['Content-Type' => 'text/xml']);

        return $this->bulkPromoPrice([
            'file' => $file
        ]);
    }
}