<?php
namespace Walmart;

use knowband\A2X;
use GuzzleHttp1\Post\PostFile;
/**
 * Partial Walmart API client implemented with Guzzle.
 *
 * @method array list(array $config = [])
 * @method array get(array $config = [])
 * @method array getFeedItem(array $config = [])
 */
class Feed extends BaseClient
{
    /**
     * @param array $config
     * @param string $env
     */
    public function __construct(array $config = [], $env = self::ENV_PROD)
    {
        $this->wmConsumerChannelType = $config['wmConsumerChannelType'];
        
        $config = array_merge_recursive($config, [
            'description_path' => __DIR__ . '/descriptions/feed.php',
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
    public function lagtimeUpdate($items)
    {
        if ( ! is_array($items)) {
            throw new \Exception('Items is not an array', 1466349195);
        }

        $schema = [
            '/LagTimeFeed/lagTime' => [
                'sendItemsAs' => 'lagTime',
                'includeWrappingTag' => false,
            ]
        ];

        $a2x = new A2X($items, $schema);
        $xml = $a2x->asXml();
        $file = new PostFile('file', $xml, 'file.xml', ['Content-Type' => 'text/xml']);

        return $this->updateLagtime([
            'file' => $file,
        ]);
    }
}