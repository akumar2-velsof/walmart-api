<?php
namespace Walmart;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use Walmart\Item;
use Walmart\Feed;
use Walmart\Order;
use Walmart\Inventory;
use Walmart\Price;
use Walmart\Promo;
use Walmart\Report;

/**
 * Description of WalmartComponent
 *
 * @author Ashish
 */
class Walmart
{

    //private $appKey = '';
    //private $appSecret = '';

    public function __construct()
    {
        //$this->appKey = $appkey;
        //$this->appSecret = $appsecret;
    }

    function verifyDetails($appkey, $appsecret, $appchannel)
    {
        try {
            $client = new Feed([
                'consumerId' => $appkey,
                'privateKey' => $appsecret,
                'wmConsumerChannelType' => $appchannel,
            ]);

            $client->list([
                'limit' => 1, // optional, default 50
                'offset' => 0, // optional, default 0
            ]);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
    
    function submitPromo($appkey, $appsecret, $consumer_channel, $feedData) {
        try {
            $client = new Promo([
                'consumerId' => $appkey,
                'privateKey' => $appsecret,
                'wmConsumerChannelType' => $consumer_channel,
                    ]
            );
            
            $feed = $client->updatePromoPrice([
                'PriceFeed' => [
                    'PriceHeader' => [
                        'version' => '1.5.1',
                        'feedDate' => date('Y-m-d\TH:i:s.000\Z')
                    ],
                    'Price' => $feedData
                ]
            ]);
//            d($feed);die;
            return $feed;
        } catch (\Exception $e) {
             return $e->getMessage();
            return false;
        }
    }
    
    function getBuyBox($appkey, $appsecret, $consumer_channel)
    {
        try {
            $client = new Report([
                'consumerId' => $appkey,
                'privateKey' => $appsecret,
                'wmConsumerChannelType' => $consumer_channel,
                    ]
            );
            
            $feed = $client->getReport('buybox');
            return $feed;
        } catch (\Exception $e) {
            echo $e->getMessage();
            return false;
        }
    }

    function getFeedStatus($appkey, $appsecret, $consumer_channel, $feedId)
    {
        try {
            $client = new Feed([
                'consumerId' => $appkey,
                'privateKey' => $appsecret,
                'wmConsumerChannelType' => $consumer_channel,
//                'wmConsumerChannelType' => $appChannelType
            ]);

            $feed = $client->get([
                'feedId' => $feedId,
                'includeDetails' => 'false',
            ]);
            return $feed;
        } catch (\Exception $e) {
            echo $e->getMessage();
            return false;
        }
    }

    function getFeedDetails($appkey, $appsecret, $consumer_channel, $feedId)
    {
        try {
            $client = new Feed([
                'consumerId' => $appkey,
                'privateKey' => $appsecret,
                'wmConsumerChannelType' => $consumer_channel,
            ]);

            $feed = $client->get([
                'feedId' => $feedId,
                'includeDetails' => 'true',
            ]);
            return $feed;
        } catch (\Exception $e) {
            echo $e->getMessage();
            return false;
        }
    }
    
    function getItems($appkey, $appsecret, $consumer_channel)
    {
        try {
            $client = new Report([
                'consumerId' => $appkey,
                'privateKey' => $appsecret,
                'wmConsumerChannelType' => $consumer_channel,
                    ]
            );
            
            $feed = $client->getReport('item');
            return $feed;
        } catch (\Exception $e) {
            echo $e->getMessage();
            return false;
        }
    }

    function getOrders($appkey, $appsecret, $consumer_channel, $start_date, $limit = 1, $nextCursor = '')
    {
        try {
            $client = new Order([
                'consumerId' => $appkey,
                'privateKey' => $appsecret,
                'wmConsumerChannelType' => $consumer_channel,
                    ]
            );
            if($nextCursor != "") {
                $orders = $client->listAll([
                    'nextCursor' => $nextCursor
                ]);
            } else {
                $orders = $client->listAll([
                    'createdStartDate' => $start_date,
                    'limit' => $limit
                ]);
            }
            return $orders;
        } catch (\Exception $e) {
            echo $e->getMessage();
            return false;
        }
    }
    
    function deleteItem($appkey, $appsecret, $consumer_channel, $sku)
    {
        try {
            $client = new Item([
                'consumerId' => $appkey,
                'privateKey' => $appsecret,
                'wmConsumerChannelType' => $consumer_channel,
                    ]
            );
            $feed = $client->retire([
                'sku' => $sku
            ]);
            return $feed;
        } catch (\Exception $e) {
//            echo $e->getMessage();
            return false;
        }
    }
    
    function createItem($appkey, $appsecret, $consumer_channel, $feedData)
    {
        try {
            $client = new Item([
                'consumerId' => $appkey,
                'privateKey' => $appsecret,
                'wmConsumerChannelType' => $consumer_channel,
                    ]
            );
            $feed = $client->bulk($feedData);
            return $feed;
        } catch (\Exception $e) {
            echo $e->getMessage();
            return false;
        }
    }

    function acknowledgeOrder($appkey, $appsecret, $consumer_channel, $orderId)
    {
        try {
            $client = new Order([
                'consumerId' => $appkey,
                'privateKey' => $appsecret,
                'wmConsumerChannelType' => $consumer_channel,
                    ]
            );
            $order = $client->acknowledge([
                'purchaseOrderId' => $orderId
            ]);
            return $order;
        } catch (\Exception $e) {
            echo $e->getMessage();
            return false;
        }
    }

    function cancelOrderLineItem($appkey, $appsecret, $consumer_channel, $lineItemId, $orderCancel = array())
    {
        try {
            $client = new Order([
                'consumerId' => $appkey,
                'privateKey' => $appsecret,
                'wmConsumerChannelType' => $consumer_channel,
                    ]
            );
            $order = $client->cancel(
                $lineItemId,
                $orderCancel
            );
            return $order;
        } catch (\Exception $e) {
//            echo $e;
            return false;
        }
    }

    function refundOrder($appkey, $appsecret, $consumer_channel, $orderId, $lineItemId, $refundReason = 'CANCEL_BY_SELLER')
    {
        $order = $client->refund(
                $lineItemId, [
            'orderRefund' => [
                'purchaseOrderId' => $orderId,
                'orderLines' => [
                    [
                        'lineNumber' => 1,
                        'refunds' => [
                            [
                                'refundComments' => 'test test',
                                'refundCharges' => [
                                    [
                                        'refundReason' => 'DamagedItem',
                                        'charge' => [
                                            'chargeType' => 'SHIPPING',
                                            'chargeName' => 'Shipping Price',
                                            'chargeAmount' => [
                                                'currency' => 'USD',
                                                'amount' => -0.1,
                                            ],
                                            'tax' => [
                                                'taxName' => 'Shipping Tax',
                                                'taxAmount' => [
                                                    'currency' => 'USD',
                                                    'amount' => -0.04,
                                                ]
                                            ]
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ],
                    [
                        'lineNumber' => 2,
                        'refunds' => [
                            [
                                'refundComments' => 'test test',
                                'refundCharges' => [
                                    [
                                        'refundReason' => 'DamagedItem',
                                        'charge' => [
                                            'chargeType' => 'PRODUCT',
                                            'chargeName' => 'Item Price',
                                            'chargeAmount' => [
                                                'currency' => 'USD',
                                                'amount' => -0.1,
                                            ],
                                            'tax' => [
                                                'taxName' => 'Shipping Tax',
                                                'taxAmount' => [
                                                    'currency' => 'USD',
                                                    'amount' => -0.04,
                                                ]
                                            ]
                                        ]
                                    ],
                                    [
                                        'refundReason' => 'DamagedItem',
                                        'charge' => [
                                            'chargeType' => 'SHIPPING',
                                            'chargeName' => 'Shipping Price',
                                            'chargeAmount' => [
                                                'currency' => 'USD',
                                                'amount' => -0.1,
                                            ],
                                            'tax' => [
                                                'taxName' => 'Shipping Tax',
                                                'taxAmount' => [
                                                    'currency' => 'USD',
                                                    'amount' => -0.04,
                                                ]
                                            ]
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ],
                ]
            ]
                ]
        );
    }

    function shipOrderId($appkey, $appsecret, $consumer_channel, $lineItemId, $orderShipment)
    {
        try {
            $client = new Order([
                'consumerId' => $appkey,
                'privateKey' => $appsecret,
                'wmConsumerChannelType' => $consumer_channel,
                    ]
            );
            $order = $client->ship(
                $lineItemId,
                $orderShipment
            );
            return $order;
        } catch (\Exception $e) {
//            echo $e;
            return false;
        }
    }
    
    function priceUpdate($appkey, $appsecret, $consumer_channel, $feedData)
    {
        try {
            $client = new Price([
                'consumerId' => $appkey,
                'privateKey' => $appsecret,
                'wmConsumerChannelType' => $consumer_channel,
                    ]
            );
            $feed = $client->bulk([
                'PriceFeed' => [
                    'PriceHeader' => [
                        'version' => '1.5',
                    ],
                    'Price' => $feedData
                ]
            ]);
            return $feed;
        } catch (\Exception $e) {
            echo $e->getMessage();
            return false;
        }
    }
    
    function inventoryUpdate($appkey, $appsecret, $consumer_channel, $inventroyArray)
    {
        try {
            $client = new Inventory([
                'consumerId' => $appkey,
                'privateKey' => $appsecret,
                'wmConsumerChannelType' => $consumer_channel,
                    ]
            );
            $feed = $client->bulk([
                'InventoryFeed' => [
                    'InventoryHeader' => [
                        'version' => '1.4',
                    ],
                    'inventory' => $inventroyArray
                ]
            ]);
            return $feed;
        } catch (\Exception $e) {
            echo $e->getMessage();
            return false;
        }
    }
    
    function updateLagTime($appkey, $appsecret, $consumer_channel, $feedData) {
        try {
            $client = new Feed([
                'consumerId' => $appkey,
                'privateKey' => $appsecret,
                'wmConsumerChannelType' => $consumer_channel,
                    ]
            );
            $feed = $client->lagtimeUpdate([
                'LagTimeFeed' => [
                    'LagTimeHeader' => [
                        'version' => '1.0',
                    ],
                    'lagTime' => $feedData
                ]
            ]);
            return $feed;
        } catch (\Exception $e) {
            return false;
        }
    }
    
    
    public function processOrderData($data)
    {
        $orderDetails = array();
        $orderData = array();
        if(isset($data["elements"]["order"])) {
            $orderData  = $data["elements"]["order"];
        }
        if(isset($data["purchaseOrderId"])) {
            $orderData  = $data;
        }
        $checkAssocArray = $this->isAssoc($orderData);
        if ($checkAssocArray) {
            $total = 0;
            $total_shipping = 0;
            $total_tax = 0;
            $orderStatus = 'Open';
            $orderDetails[0]["purchaseOrderId"] = $orderData["purchaseOrderId"];
//            $orderDetails[0]["customerEmailId"] = 'demoemail0007@gmail.com';//$orderData["customerEmailId"];
            $orderDetails[0]["customerEmailId"] = $orderData["customerEmailId"];
            $dateObject = new \DateTime($orderData["orderDate"]);
            $orderDate = $dateObject->format('Y-m-d H:i:s');
            $orderDetails[0]["orderDate"] = $orderDate;
            $orderDetails[0]["shippingInfo"]["phone"] = $orderData["shippingInfo"]["phone"];
            $orderDetails[0]["shippingInfo"]["name"] = $orderData["shippingInfo"]["postalAddress"]["name"];
            $orderDetails[0]["shippingInfo"]["address1"] = $orderData["shippingInfo"]["postalAddress"]["address1"];
            $orderDetails[0]["shippingInfo"]["city"] = $orderData["shippingInfo"]["postalAddress"]["city"];
            $orderDetails[0]["shippingInfo"]["state"] = $orderData["shippingInfo"]["postalAddress"]["state"];
            $orderDetails[0]["shippingInfo"]["postalCode"] = $orderData["shippingInfo"]["postalAddress"]["postalCode"];
            $orderDetails[0]["shippingInfo"]["country"] = $orderData["shippingInfo"]["postalAddress"]["country"];

            $checkAssocArray = $this->isAssoc($orderData["orderLines"]["orderLine"]);
            if ($checkAssocArray) {
                $orderDetails[0]["lineItems"][0]["sku"] = $orderData["orderLines"]["orderLine"]["item"]["sku"];
                $orderDetails[0]["lineItems"][0]["lineNumber"] = $orderData["orderLines"]["orderLine"]["lineNumber"];
                $orderDetails[0]["lineItems"][0]["productName"] = $orderData["orderLines"]["orderLine"]["item"]["productName"];
                $orderDetails[0]["lineItems"][0]["quantity"] = $orderData["orderLines"]["orderLine"]["orderLineQuantity"]["amount"];
                $orderDetails[0]["lineItems"][0]["status"] = $orderData["orderLines"]["orderLine"]["orderLineStatuses"]["orderLineStatus"]['status'];
                
                $total = 0;
                $total_shipping = 0;
                $total_tax = 0;
                $itemPrice = 0;

                $checkAssocArray = $this->isAssoc($orderData["orderLines"]["orderLine"]["charges"]["charge"]);
                if ($checkAssocArray) {
                    foreach ($orderData["orderLines"]["orderLine"]["charges"] as $price) {
                        if ($price["chargeType"] == 'SHIPPING') {
                            if (isset($price["chargeAmount"]["amount"])) {
                                $total_shipping += $price['chargeAmount']['amount'];
                            }
                            if (isset($price["tax"]["taxAmount"])) {
                                $total_tax += $price['tax']['taxAmount']['amount'];
                            }
                        }
                        if ($price["chargeType"] == 'PRODUCT') {
                            if (isset($price["chargeAmount"]["amount"])) {
                                $total += $price['chargeAmount']['amount'];
                                $itemPrice = $price['chargeAmount']['amount'];
                            }
                            if (isset($price["tax"]["taxAmount"])) {
                                $total_tax += $price['tax']['taxAmount']['amount'];
                            }
                        }
                    }
                } else {
                    foreach ($orderData["orderLines"]["orderLine"]["charges"]["charge"] as $price) {
                        if ($price["chargeType"] == 'SHIPPING') {
                            if (isset($price["chargeAmount"]["amount"])) {
                                $total_shipping += $price['chargeAmount']['amount'];
                            }
                            if (isset($price["tax"]["taxAmount"])) {
                                $total_tax += $price['tax']['taxAmount']['amount'];
                            }
                        }
                        if ($price["chargeType"] == 'PRODUCT') {
                            if (isset($price["chargeAmount"]["amount"])) {
                                $total += $price['chargeAmount']['amount'];
                                $itemPrice = $price['chargeAmount']['amount'];
                            }
                            if (isset($price["tax"]["taxAmount"])) {
                                $total_tax += $price['tax']['taxAmount']['amount'];
                            }
                        }
                    }
                }
                $orderDetails[0]["lineItems"][0]["itemprice"] = $itemPrice;
            } else {
                $itemNumber = 0;
                foreach ($orderData["orderLines"]["orderLine"] as $lineItem) {
                    $orderDetails[0]["lineItems"][$itemNumber]["sku"] = $lineItem["item"]["sku"];
                    $orderDetails[0]["lineItems"][$itemNumber]["lineNumber"] = $lineItem["lineNumber"];
                    $orderDetails[0]["lineItems"][$itemNumber]["productName"] = $lineItem["item"]["productName"];
                    $orderDetails[0]["lineItems"][$itemNumber]["quantity"] = $lineItem["orderLineQuantity"]["amount"];
                    $orderDetails[0]["lineItems"][$itemNumber]["status"] = $lineItem["orderLineStatuses"]["orderLineStatus"]['status'];
                    $itemPrice = 0;

                    $checkAssocArray = $this->isAssoc($lineItem["charges"]["charge"]);
                    if ($checkAssocArray) {
                        foreach ($lineItem["charges"] as $price) {
                            if ($price["chargeType"] == 'SHIPPING') {
                                if (isset($price["chargeAmount"]["amount"])) {
                                    $total_shipping += $price['chargeAmount']['amount'];
                                }
                                if (isset($price["tax"]["taxAmount"])) {
                                    $total_tax += $price['tax']['taxAmount']['amount'];
                                }
                            }
                            if ($price["chargeType"] == 'PRODUCT') {
                                if (isset($price["chargeAmount"]["amount"])) {
                                    $total += $price['chargeAmount']['amount'];
                                    $itemPrice = $price['chargeAmount']['amount'];
                                }
                                if (isset($price["tax"]["taxAmount"])) {
                                    $total_tax += $price['tax']['taxAmount']['amount'];
                                }
                            }
                        }
                    } else {

                        foreach ($lineItem["charges"]["charge"] as $price) {
                            if ($price["chargeType"] == 'SHIPPING') {
                                if (isset($price["chargeAmount"]["amount"])) {
                                    $total_shipping += $price['chargeAmount']['amount'];
                                }
                                if (isset($price["tax"]["taxAmount"])) {
                                    $total_tax += $price['tax']['taxAmount']['amount'];
                                }
                            }
                            if ($price["chargeType"] == 'PRODUCT') {
                                if (isset($price["chargeAmount"]["amount"])) {
                                    $total += $price['chargeAmount']['amount'];
                                    $itemPrice = $price['chargeAmount']['amount'];
                                }
                                if (isset($price["tax"]["taxAmount"])) {
                                    $total_tax += $price['tax']['taxAmount']['amount'];
                                }
                            }
                        }
                    }
                    $orderDetails[0]["lineItems"][$itemNumber]["itemprice"] = $itemPrice;
                    $itemNumber++;
                }
            }
            $orderDetails[0]["tax"] = $total_tax;
            $orderDetails[0]["shipping"] = $total_shipping;
            $orderDetails[0]["shippingMethod"] = $orderData["shippingInfo"]["methodCode"];
            $orderDetails[0]["orderAmount"] = $total;
        } else {
            $i = 0;
            foreach ($orderData as $order) {
                $total = 0;
                $total_shipping = 0;
                $total_tax = 0;
                $orderDetails[$i]["purchaseOrderId"] = $order["purchaseOrderId"];
//                $orderDetails[$i]["customerEmailId"] = 'demoemail0007@gmail.com';
                $orderDetails[$i]["customerEmailId"] = $order["customerEmailId"];
                $dateObject = new \DateTime($order["orderDate"]);
                $orderDate = $dateObject->format('Y-m-d H:i:s');
                $orderDetails[$i]["orderDate"] = $orderDate;
                $orderDetails[$i]["shippingInfo"]["phone"] = $order["shippingInfo"]["phone"];
                $orderDetails[$i]["shippingInfo"]["name"] = $order["shippingInfo"]["postalAddress"]["name"];
                $orderDetails[$i]["shippingInfo"]["address1"] = $order["shippingInfo"]["postalAddress"]["address1"];
                $orderDetails[$i]["shippingInfo"]["city"] = $order["shippingInfo"]["postalAddress"]["city"];
                $orderDetails[$i]["shippingInfo"]["state"] = $order["shippingInfo"]["postalAddress"]["state"];
                $orderDetails[$i]["shippingInfo"]["postalCode"] = $order["shippingInfo"]["postalAddress"]["postalCode"];
                $orderDetails[$i]["shippingInfo"]["country"] = $order["shippingInfo"]["postalAddress"]["country"];

                $checkAssocArray = $this->isAssoc($order["orderLines"]["orderLine"]);
                if ($checkAssocArray) {
                    $orderDetails[$i]["lineItems"][0]["sku"] = $order["orderLines"]["orderLine"]["item"]["sku"];
                    $orderDetails[$i]["lineItems"][0]["lineNumber"] = $order["orderLines"]["orderLine"]["lineNumber"];
                    $orderDetails[$i]["lineItems"][0]["productName"] = $order["orderLines"]["orderLine"]["item"]["productName"];
                    $orderDetails[$i]["lineItems"][0]["quantity"] = $order["orderLines"]["orderLine"]["orderLineQuantity"]["amount"];
                    $orderDetails[$i]["lineItems"][0]["status"] = $order["orderLines"]["orderLine"]["orderLineStatuses"]["orderLineStatus"]['status'];

                    $itemPrice = 0;

                    $checkAssocArray = $this->isAssoc($order["orderLines"]["orderLine"]["charges"]["charge"]);
                    if ($checkAssocArray) {
                        foreach ($order["orderLines"]["orderLine"]["charges"] as $price) {
                            if ($price["chargeType"] == 'SHIPPING') {
                                if (isset($price["chargeAmount"]["amount"])) {
                                    $total_shipping += $price['chargeAmount']['amount'];
                                }
                                if (isset($price["tax"]["taxAmount"])) {
                                    $total_tax += $price['tax']['taxAmount']['amount'];
                                }
                            }
                            if ($price["chargeType"] == 'PRODUCT') {
                                if (isset($price["chargeAmount"]["amount"])) {
                                    $total += $price['chargeAmount']['amount'];
                                    $itemPrice = $price['chargeAmount']['amount'];
                                }
                                if (isset($price["tax"]["taxAmount"])) {
                                    $total_tax += $price['tax']['taxAmount']['amount'];
                                }
                            }
                        }
                    } else {
                        foreach ($order["orderLines"]["orderLine"]["charges"]["charge"] as $price) {
                            if ($price["chargeType"] == 'SHIPPING') {
                                if (isset($price["chargeAmount"]["amount"])) {
                                    $total_shipping += $price['chargeAmount']['amount'];
                                }
                                if (isset($price["tax"]["taxAmount"])) {
                                    $total_tax += $price['tax']['taxAmount']['amount'];
                                }
                            }
                            if ($price["chargeType"] == 'PRODUCT') {
                                if (isset($price["chargeAmount"]["amount"])) {
                                    $total += $price['chargeAmount']['amount'];
                                    $itemPrice = $price['chargeAmount']['amount'];
                                }
                                if (isset($price["tax"]["taxAmount"])) {
                                    $total_tax += $price['tax']['taxAmount']['amount'];
                                }
                            }
                        }
                    }
                    $orderDetails[$i]["lineItems"][0]["itemprice"] = $itemPrice;
                } else {

                    $itemNumber = 0;
                    foreach ($order["orderLines"]["orderLine"] as $lineItem) {
                        $orderDetails[$i]["lineItems"][$itemNumber]["sku"] = $lineItem["item"]["sku"];
                        $orderDetails[$i]["lineItems"][$itemNumber]["lineNumber"] = $lineItem["lineNumber"];
                        $orderDetails[$i]["lineItems"][$itemNumber]["productName"] = $lineItem["item"]["productName"];
                        $orderDetails[$i]["lineItems"][$itemNumber]["quantity"] = $lineItem["orderLineQuantity"]["amount"];
                        $orderDetails[$i]["lineItems"][$itemNumber]["status"] = $lineItem["orderLineStatuses"]["orderLineStatus"]['status'];
                        $itemPrice = 0;

                        $checkAssocArray = $this->isAssoc($lineItem["charges"]["charge"]);
                        if ($checkAssocArray) {

                            foreach ($lineItem["charges"] as $price) {
                                if ($price["chargeType"] == 'SHIPPING') {
                                    if (isset($price["chargeAmount"]["amount"])) {
                                        $total_shipping += $price['chargeAmount']['amount'];
                                    }
                                    if (isset($price["tax"]["taxAmount"])) {
                                        $total_tax += $price['tax']['taxAmount']['amount'];
                                    }
                                }
                                if ($price["chargeType"] == 'PRODUCT') {
                                    if (isset($price["chargeAmount"]["amount"])) {
                                        $total += $price['chargeAmount']['amount'];
                                        $itemPrice = $price['chargeAmount']['amount'];
                                    }
                                    if (isset($price["tax"]["taxAmount"])) {
                                        $total_tax += $price['tax']['taxAmount']['amount'];
                                    }
                                }
                            }
                        } else {
                            foreach ($lineItem["charges"]["charge"] as $price) {
                                if ($price["chargeType"] == 'SHIPPING') {
                                    if (isset($price["chargeAmount"]["amount"])) {
                                        $total_shipping += $price['chargeAmount']['amount'];
                                    }
                                    if (isset($price["tax"]["taxAmount"])) {
                                        $total_tax += $price['tax']['taxAmount']['amount'];
                                    }
                                }
                                if ($price["chargeType"] == 'PRODUCT') {
                                    if (isset($price["chargeAmount"]["amount"])) {
                                        $total += $price['chargeAmount']['amount'];
                                        $itemPrice = $price['chargeAmount']['amount'];
                                    }
                                    if (isset($price["tax"]["taxAmount"])) {
                                        $total_tax += $price['tax']['taxAmount']['amount'];
                                    }
                                }
                            }
                        }
                        $orderDetails[$i]["lineItems"][$itemNumber]["itemprice"] = $itemPrice;
                        $itemNumber++;
                    }
                }
                $orderDetails[$i]["tax"] = $total_tax;
                $orderDetails[$i]["shipping"] = $total_shipping;
                $orderDetails[$i]["shippingMethod"] = $order["shippingInfo"]["methodCode"];
                $orderDetails[$i]["orderAmount"] = $total;
                $i++;
            }
        }
        return $orderDetails;
    }
    
    private function isAssoc($array)
    {
        return array_keys($array) !== range(0, count($array) - 1);
    }
}
