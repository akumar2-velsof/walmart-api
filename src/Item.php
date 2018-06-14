<?php
namespace Walmart;

use knowband\A2X;
use GuzzleHttp\Post\PostFile;

/**
 * Partial Walmart API client implemented with Guzzle.
 *
 * @method array list(array $config = [])
 * @method array get(array $config = [])
 * @method array retire(array $config = [])
 */
class Item extends BaseClient
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
            'description_path' => __DIR__ . '/descriptions/item.php',
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
    public function bulk($items)
    {
        if ( ! is_array($items)) {
            throw new \Exception('Items is not an array', 1466349189);
        }

        $schema = [
            '/MPItemFeed/MPItem' => [
                'sendItemsAs' => 'MPItem',
                'includeWrappingTag' => false,
            ],
            '/variantAttributeNames' => [
                'sendItemsAs' => 'variantAttributeName'
            ],
            '/MPItemFeed/MPItem/MPItem/MPOffer/ShippingOverrides/shippingOverride' => [
                'sendItemsAs' => 'shippingOverride',
                'includeWrappingTag' => false,
            ],
            '/MPItemFeed/MPItem/MPItem/MPProduct/category/Animal/AnimalEverythingElse/productSecondaryImageURL/productSecondaryImageURLValue' => [
                'sendItemsAs' => 'productSecondaryImageURLValue',
                'includeWrappingTag' => false,

            ],
            '/MPItemFeed/MPItem/MPItem/MPProduct/category/Animal/AnimalAccessories/productSecondaryImageURL/productSecondaryImageURLValue' => [
                'sendItemsAs' => 'productSecondaryImageURLValue',
                'includeWrappingTag' => false,

            ],
            '/MPItemFeed/MPItem/MPItem/MPProduct/category/Animal/AnimalFood/productSecondaryImageURL/productSecondaryImageURLValue' => [
                'sendItemsAs' => 'productSecondaryImageURLValue',
                'includeWrappingTag' => false,

            ],
            '/MPItemFeed/MPItem/MPItem/MPProduct/category/Animal/AnimalHealthAndGrooming/productSecondaryImageURL/productSecondaryImageURLValue' => [
                'sendItemsAs' => 'productSecondaryImageURLValue',
                'includeWrappingTag' => false,

            ],
            '/MPItemFeed/MPItem/MPItem/MPProduct/category/ArtAndCraftCategory/ArtAndCraft/productSecondaryImageURL/productSecondaryImageURLValue' => [
                'sendItemsAs' => 'productSecondaryImageURLValue',
                'includeWrappingTag' => false,

            ],
            '/MPItemFeed/MPItem/MPItem/MPProduct/category/Baby/BabyOther/productSecondaryImageURL/productSecondaryImageURLValue' => [
                'sendItemsAs' => 'productSecondaryImageURLValue',
                'includeWrappingTag' => false,

            ],
            '/MPItemFeed/MPItem/MPItem/MPProduct/category/Baby/BabyClothing/productSecondaryImageURL/productSecondaryImageURLValue' => [
                'sendItemsAs' => 'productSecondaryImageURLValue',
                'includeWrappingTag' => false,

            ],
            '/MPItemFeed/MPItem/MPItem/MPProduct/category/Baby/BabyFood/productSecondaryImageURL/productSecondaryImageURLValue' => [
                'sendItemsAs' => 'productSecondaryImageURLValue',
                'includeWrappingTag' => false,

            ],
            '/MPItemFeed/MPItem/MPItem/MPProduct/category/Baby/BabyFurniture/productSecondaryImageURL/productSecondaryImageURLValue' => [
                'sendItemsAs' => 'productSecondaryImageURLValue',
                'includeWrappingTag' => false,

            ],
            '/MPItemFeed/MPItem/MPItem/MPProduct/category/Baby/BabyToys/productSecondaryImageURL/productSecondaryImageURLValue' => [
                'sendItemsAs' => 'productSecondaryImageURLValue',
                'includeWrappingTag' => false,

            ],
            '/MPItemFeed/MPItem/MPItem/MPProduct/category/Baby/ChildCarSeats/productSecondaryImageURL/productSecondaryImageURLValue' => [
                'sendItemsAs' => 'productSecondaryImageURLValue',
                'includeWrappingTag' => false,

            ],
            '/MPItemFeed/MPItem/MPItem/MPProduct/category/CarriersAndAccessoriesCategory/CarriersAndAccessories/productSecondaryImageURL/productSecondaryImageURLValue' => [
                'sendItemsAs' => 'productSecondaryImageURLValue',
                'includeWrappingTag' => false,

            ],
            '/MPItemFeed/MPItem/MPItem/MPProduct/category/CarriersAndAccessoriesCategory/CasesAndBags/productSecondaryImageURL/productSecondaryImageURLValue' => [
                'sendItemsAs' => 'productSecondaryImageURLValue',
                'includeWrappingTag' => false,

            ],
            '/MPItemFeed/MPItem/MPItem/MPProduct/category/ClothingCategory/Clothing/productSecondaryImageURL/productSecondaryImageURLValue' => [
                'sendItemsAs' => 'productSecondaryImageURLValue',
                'includeWrappingTag' => false,

            ],
            '/MPItemFeed/MPItem/MPItem/MPProduct/category/Electronics/ElectronicsOther/productSecondaryImageURL/productSecondaryImageURLValue' => [
                'sendItemsAs' => 'productSecondaryImageURLValue',
                'includeWrappingTag' => false,

            ],
            '/MPItemFeed/MPItem/MPItem/MPProduct/category/Electronics/CellPhones/productSecondaryImageURL/productSecondaryImageURLValue' => [
                'sendItemsAs' => 'productSecondaryImageURLValue',
                'includeWrappingTag' => false,

            ],
            '/MPItemFeed/MPItem/MPItem/MPProduct/category/Electronics/ComputerComponents/productSecondaryImageURL/productSecondaryImageURLValue' => [
                'sendItemsAs' => 'productSecondaryImageURLValue',
                'includeWrappingTag' => false,

            ],
            '/MPItemFeed/MPItem/MPItem/MPProduct/category/Electronics/Computers/productSecondaryImageURL/productSecondaryImageURLValue' => [
                'sendItemsAs' => 'productSecondaryImageURLValue',
                'includeWrappingTag' => false,

            ],
            '/MPItemFeed/MPItem/MPItem/MPProduct/category/Electronics/ElectronicsAccessories/productSecondaryImageURL/productSecondaryImageURLValue' => [
                'sendItemsAs' => 'productSecondaryImageURLValue',
                'includeWrappingTag' => false,

            ],
            '/MPItemFeed/MPItem/MPItem/MPProduct/category/Electronics/ElectronicsCables/productSecondaryImageURL/productSecondaryImageURLValue' => [
                'sendItemsAs' => 'productSecondaryImageURLValue',
                'includeWrappingTag' => false,

            ],
            '/MPItemFeed/MPItem/MPItem/MPProduct/category/Electronics/PrintersScannersAndImaging/productSecondaryImageURL/productSecondaryImageURLValue' => [
                'sendItemsAs' => 'productSecondaryImageURLValue',
                'includeWrappingTag' => false,

            ],
            '/MPItemFeed/MPItem/MPItem/MPProduct/category/Electronics/Software/productSecondaryImageURL/productSecondaryImageURLValue' => [
                'sendItemsAs' => 'productSecondaryImageURLValue',
                'includeWrappingTag' => false,

            ],
            '/MPItemFeed/MPItem/MPItem/MPProduct/category/Electronics/TVsAndVideoDisplays/productSecondaryImageURL/productSecondaryImageURLValue' => [
                'sendItemsAs' => 'productSecondaryImageURLValue',
                'includeWrappingTag' => false,

            ],
            '/MPItemFeed/MPItem/MPItem/MPProduct/category/Electronics/VideoGames/productSecondaryImageURL/productSecondaryImageURLValue' => [
                'sendItemsAs' => 'productSecondaryImageURLValue',
                'includeWrappingTag' => false,

            ],
            '/MPItemFeed/MPItem/MPItem/MPProduct/category/Electronics/VideoProjectors/productSecondaryImageURL/productSecondaryImageURLValue' => [
                'sendItemsAs' => 'productSecondaryImageURLValue',
                'includeWrappingTag' => false,

            ],
            '/MPItemFeed/MPItem/MPItem/MPProduct/category/FoodAndBeverageCategory/FoodAndBeverage/productSecondaryImageURL/productSecondaryImageURLValue' => [
                'sendItemsAs' => 'productSecondaryImageURLValue',
                'includeWrappingTag' => false,

            ],
            '/MPItemFeed/MPItem/MPItem/MPProduct/category/FoodAndBeverageCategory/AlcoholicBeverages/productSecondaryImageURL/productSecondaryImageURLValue' => [
                'sendItemsAs' => 'productSecondaryImageURLValue',
                'includeWrappingTag' => false,

            ],
            '/MPItemFeed/MPItem/MPItem/MPProduct/category/FootwearCategory/Footwear/productSecondaryImageURL/productSecondaryImageURLValue' => [
                'sendItemsAs' => 'productSecondaryImageURLValue',
                'includeWrappingTag' => false,

            ],
            '/MPItemFeed/MPItem/MPItem/MPProduct/category/FurnitureCategory/Furniture/productSecondaryImageURL/productSecondaryImageURLValue' => [
                'sendItemsAs' => 'productSecondaryImageURLValue',
                'includeWrappingTag' => false,

            ],
            '/MPItemFeed/MPItem/MPItem/MPProduct/category/GardenAndPatioCategory/GardenAndPatio/productSecondaryImageURL/productSecondaryImageURLValue' => [
                'sendItemsAs' => 'productSecondaryImageURLValue',
                'includeWrappingTag' => false,

            ],
            '/MPItemFeed/MPItem/MPItem/MPProduct/category/GardenAndPatioCategory/GrillsAndOutdoorCooking/productSecondaryImageURL/productSecondaryImageURLValue' => [
                'sendItemsAs' => 'productSecondaryImageURLValue',
                'includeWrappingTag' => false,

            ],
            '/MPItemFeed/MPItem/MPItem/MPProduct/category/HealthAndBeauty/HealthAndBeautyElectronics/productSecondaryImageURL/productSecondaryImageURLValue' => [
                'sendItemsAs' => 'productSecondaryImageURLValue',
                'includeWrappingTag' => false,

            ],
            '/MPItemFeed/MPItem/MPItem/MPProduct/category/HealthAndBeauty/MedicalAids/productSecondaryImageURL/productSecondaryImageURLValue' => [
                'sendItemsAs' => 'productSecondaryImageURLValue',
                'includeWrappingTag' => false,

            ],
            '/MPItemFeed/MPItem/MPItem/MPProduct/category/HealthAndBeauty/MedicineAndSupplements/productSecondaryImageURL/productSecondaryImageURLValue' => [
                'sendItemsAs' => 'productSecondaryImageURLValue',
                'includeWrappingTag' => false,

            ],
            '/MPItemFeed/MPItem/MPItem/MPProduct/category/HealthAndBeauty/Optical/productSecondaryImageURL/productSecondaryImageURLValue' => [
                'sendItemsAs' => 'productSecondaryImageURLValue',
                'includeWrappingTag' => false,

            ],
            '/MPItemFeed/MPItem/MPItem/MPProduct/category/HealthAndBeauty/PersonalCare/productSecondaryImageURL/productSecondaryImageURLValue' => [
                'sendItemsAs' => 'productSecondaryImageURLValue',
                'includeWrappingTag' => false,

            ],
            '/MPItemFeed/MPItem/MPItem/MPProduct/category/Home/HomeOther/productSecondaryImageURL/productSecondaryImageURLValue' => [
                'sendItemsAs' => 'productSecondaryImageURLValue',
                'includeWrappingTag' => false,

            ],
            '/MPItemFeed/MPItem/MPItem/MPProduct/category/Home/Bedding/productSecondaryImageURL/productSecondaryImageURLValue' => [
                'sendItemsAs' => 'productSecondaryImageURLValue',
                'includeWrappingTag' => false,

            ],
            '/MPItemFeed/MPItem/MPItem/MPProduct/category/Home/LargeAppliances/productSecondaryImageURL/productSecondaryImageURLValue' => [
                'sendItemsAs' => 'productSecondaryImageURLValue',
                'includeWrappingTag' => false,

            ],
            '/MPItemFeed/MPItem/MPItem/MPProduct/category/JewelryCategory/Jewelry/productSecondaryImageURL/productSecondaryImageURLValue' => [
                'sendItemsAs' => 'productSecondaryImageURLValue',
                'includeWrappingTag' => false,

            ],
            '/MPItemFeed/MPItem/MPItem/MPProduct/category/Media/BooksAndMagazines/productSecondaryImageURL/productSecondaryImageURLValue' => [
                'sendItemsAs' => 'productSecondaryImageURLValue',
                'includeWrappingTag' => false,

            ],
            '/MPItemFeed/MPItem/MPItem/MPProduct/category/Media/Movies/productSecondaryImageURL/productSecondaryImageURLValue' => [
                'sendItemsAs' => 'productSecondaryImageURLValue',
                'includeWrappingTag' => false,

            ],
            '/MPItemFeed/MPItem/MPItem/MPProduct/category/Media/Music/productSecondaryImageURL/productSecondaryImageURLValue' => [
                'sendItemsAs' => 'productSecondaryImageURLValue',
                'includeWrappingTag' => false,

            ],
            '/MPItemFeed/MPItem/MPItem/MPProduct/category/Media/TVShows/productSecondaryImageURL/productSecondaryImageURLValue' => [
                'sendItemsAs' => 'productSecondaryImageURLValue',
                'includeWrappingTag' => false,

            ],
            '/MPItemFeed/MPItem/MPItem/MPProduct/category/MusicalInstrument/InstrumentAccessories/productSecondaryImageURL/productSecondaryImageURLValue' => [
                'sendItemsAs' => 'productSecondaryImageURLValue',
                'includeWrappingTag' => false,

            ],
            '/MPItemFeed/MPItem/MPItem/MPProduct/category/MusicalInstrument/MusicCasesAndBags/productSecondaryImageURL/productSecondaryImageURLValue' => [
                'sendItemsAs' => 'productSecondaryImageURLValue',
                'includeWrappingTag' => false,

            ],
            '/MPItemFeed/MPItem/MPItem/MPProduct/category/MusicalInstrument/MusicalInstruments/productSecondaryImageURL/productSecondaryImageURLValue' => [
                'sendItemsAs' => 'productSecondaryImageURLValue',
                'includeWrappingTag' => false,

            ],
            '/MPItemFeed/MPItem/MPItem/MPProduct/category/MusicalInstrument/SoundAndRecording/productSecondaryImageURL/productSecondaryImageURLValue' => [
                'sendItemsAs' => 'productSecondaryImageURLValue',
                'includeWrappingTag' => false,

            ],
            '/MPItemFeed/MPItem/MPItem/MPProduct/category/OccasionAndSeasonal/CeremonialClothingAndAccessories/productSecondaryImageURL/productSecondaryImageURLValue' => [
                'sendItemsAs' => 'productSecondaryImageURLValue',
                'includeWrappingTag' => false,

            ],
            '/MPItemFeed/MPItem/MPItem/MPProduct/category/OccasionAndSeasonal/Costumes/productSecondaryImageURL/productSecondaryImageURLValue' => [
                'sendItemsAs' => 'productSecondaryImageURLValue',
                'includeWrappingTag' => false,

            ],
            '/MPItemFeed/MPItem/MPItem/MPProduct/category/OccasionAndSeasonal/DecorationsAndFavors/productSecondaryImageURL/productSecondaryImageURLValue' => [
                'sendItemsAs' => 'productSecondaryImageURLValue',
                'includeWrappingTag' => false,

            ],
            '/MPItemFeed/MPItem/MPItem/MPProduct/category/OccasionAndSeasonal/Funeral/productSecondaryImageURL/productSecondaryImageURLValue' => [
                'sendItemsAs' => 'productSecondaryImageURLValue',
                'includeWrappingTag' => false,

            ],
            '/MPItemFeed/MPItem/MPItem/MPProduct/category/OccasionAndSeasonal/GiftSupplyAndAwards/productSecondaryImageURL/productSecondaryImageURLValue' => [
                'sendItemsAs' => 'productSecondaryImageURLValue',
                'includeWrappingTag' => false,

            ],
            '/MPItemFeed/MPItem/MPItem/MPProduct/category/OfficeCategory/Office/productSecondaryImageURL/productSecondaryImageURLValue' => [
                'sendItemsAs' => 'productSecondaryImageURLValue',
                'includeWrappingTag' => false,

            ],
            '/MPItemFeed/MPItem/MPItem/MPProduct/category/OtherCategory/Other/productSecondaryImageURL/productSecondaryImageURLValue' => [
                'sendItemsAs' => 'productSecondaryImageURLValue',
                'includeWrappingTag' => false,

            ],
            '/MPItemFeed/MPItem/MPItem/MPProduct/category/OtherCategory/CleaningAndChemical/productSecondaryImageURL/productSecondaryImageURLValue' => [
                'sendItemsAs' => 'productSecondaryImageURLValue',
                'includeWrappingTag' => false,

            ],
            '/MPItemFeed/MPItem/MPItem/MPProduct/category/OtherCategory/Storage/productSecondaryImageURL/productSecondaryImageURLValue' => [
                'sendItemsAs' => 'productSecondaryImageURLValue',
                'includeWrappingTag' => false,

            ],
            '/MPItemFeed/MPItem/MPItem/MPProduct/category/OtherCategory/fuelsAndLubricants/productSecondaryImageURL/productSecondaryImageURLValue' => [
                'sendItemsAs' => 'productSecondaryImageURLValue',
                'includeWrappingTag' => false,

            ],
            '/MPItemFeed/MPItem/MPItem/MPProduct/category/OtherCategory/giftCards/productSecondaryImageURL/productSecondaryImageURLValue' => [
                'sendItemsAs' => 'productSecondaryImageURLValue',
                'includeWrappingTag' => false,

            ],
            '/MPItemFeed/MPItem/MPItem/MPProduct/category/OtherCategory/safetyAndEmergency/productSecondaryImageURL/productSecondaryImageURLValue' => [
                'sendItemsAs' => 'productSecondaryImageURLValue',
                'includeWrappingTag' => false,

            ],
            '/MPItemFeed/MPItem/MPItem/MPProduct/category/Photography/CamerasAndLenses/productSecondaryImageURL/productSecondaryImageURLValue' => [
                'sendItemsAs' => 'productSecondaryImageURLValue',
                'includeWrappingTag' => false,

            ],
            '/MPItemFeed/MPItem/MPItem/MPProduct/category/Photography/PhotoAccessories/productSecondaryImageURL/productSecondaryImageURLValue' => [
                'sendItemsAs' => 'productSecondaryImageURLValue',
                'includeWrappingTag' => false,

            ],
            '/MPItemFeed/MPItem/MPItem/MPProduct/category/SportAndRecreation/SportAndRecreationOther/productSecondaryImageURL/productSecondaryImageURLValue' => [
                'sendItemsAs' => 'productSecondaryImageURLValue',
                'includeWrappingTag' => false,

            ],
            '/MPItemFeed/MPItem/MPItem/MPProduct/category/SportAndRecreation/Cycling/productSecondaryImageURL/productSecondaryImageURLValue' => [
                'sendItemsAs' => 'productSecondaryImageURLValue',
                'includeWrappingTag' => false,

            ],
            '/MPItemFeed/MPItem/MPItem/MPProduct/category/SportAndRecreation/Optics/productSecondaryImageURL/productSecondaryImageURLValue' => [
                'sendItemsAs' => 'productSecondaryImageURLValue',
                'includeWrappingTag' => false,

            ],
            '/MPItemFeed/MPItem/MPItem/MPProduct/category/SportAndRecreation/Weapons/productSecondaryImageURL/productSecondaryImageURLValue' => [
                'sendItemsAs' => 'productSecondaryImageURLValue',
                'includeWrappingTag' => false,

            ],
            '/MPItemFeed/MPItem/MPItem/MPProduct/category/ToolsAndHardware/ToolsAndHardwareOther/productSecondaryImageURL/productSecondaryImageURLValue' => [
                'sendItemsAs' => 'productSecondaryImageURLValue',
                'includeWrappingTag' => false,

            ],
            '/MPItemFeed/MPItem/MPItem/MPProduct/category/ToolsAndHardware/BuildingSupply/productSecondaryImageURL/productSecondaryImageURLValue' => [
                'sendItemsAs' => 'productSecondaryImageURLValue',
                'includeWrappingTag' => false,

            ],
            '/MPItemFeed/MPItem/MPItem/MPProduct/category/ToolsAndHardware/Electrical/productSecondaryImageURL/productSecondaryImageURLValue' => [
                'sendItemsAs' => 'productSecondaryImageURLValue',
                'includeWrappingTag' => false,

            ],
            '/MPItemFeed/MPItem/MPItem/MPProduct/category/ToolsAndHardware/Hardware/productSecondaryImageURL/productSecondaryImageURLValue' => [
                'sendItemsAs' => 'productSecondaryImageURLValue',
                'includeWrappingTag' => false,

            ],
            '/MPItemFeed/MPItem/MPItem/MPProduct/category/ToolsAndHardware/PlumbingAndHVAC/productSecondaryImageURL/productSecondaryImageURLValue' => [
                'sendItemsAs' => 'productSecondaryImageURLValue',
                'includeWrappingTag' => false,

            ],
            '/MPItemFeed/MPItem/MPItem/MPProduct/category/ToolsAndHardware/Tools/productSecondaryImageURL/productSecondaryImageURLValue' => [
                'sendItemsAs' => 'productSecondaryImageURLValue',
                'includeWrappingTag' => false,

            ],
            '/MPItemFeed/MPItem/MPItem/MPProduct/category/ToysCategory/Toys/productSecondaryImageURL/productSecondaryImageURLValue' => [
                'sendItemsAs' => 'productSecondaryImageURLValue',
                'includeWrappingTag' => false,

            ],
            '/MPItemFeed/MPItem/MPItem/MPProduct/category/Vehicle/VehicleOther/productSecondaryImageURL/productSecondaryImageURLValue' => [
                'sendItemsAs' => 'productSecondaryImageURLValue',
                'includeWrappingTag' => false,

            ],
            '/MPItemFeed/MPItem/MPItem/MPProduct/category/Vehicle/LandVehicles/productSecondaryImageURL/productSecondaryImageURLValue' => [
                'sendItemsAs' => 'productSecondaryImageURLValue',
                'includeWrappingTag' => false,

            ],
            '/MPItemFeed/MPItem/MPItem/MPProduct/category/Vehicle/Tires/productSecondaryImageURL/productSecondaryImageURLValue' => [
                'sendItemsAs' => 'productSecondaryImageURLValue',
                'includeWrappingTag' => false,

            ],
            '/MPItemFeed/MPItem/MPItem/MPProduct/category/Vehicle/VehiclePartsAndAccessories/productSecondaryImageURL/productSecondaryImageURLValue' => [
                'sendItemsAs' => 'productSecondaryImageURLValue',
                'includeWrappingTag' => false,

            ],
            '/MPItemFeed/MPItem/MPItem/MPProduct/category/Vehicle/Watercraft/productSecondaryImageURL/productSecondaryImageURLValue' => [
                'sendItemsAs' => 'productSecondaryImageURLValue',
                'includeWrappingTag' => false,

            ],
            '/MPItemFeed/MPItem/MPItem/MPProduct/category/Vehicle/WheelsAndWheelComponents/productSecondaryImageURL/productSecondaryImageURLValue' => [
                'sendItemsAs' => 'productSecondaryImageURLValue',
                'includeWrappingTag' => false,

            ],
            '/MPItemFeed/MPItem/MPItem/MPProduct/category/WatchesCategory/Watches/productSecondaryImageURL/productSecondaryImageURLValue' => [
                'sendItemsAs' => 'productSecondaryImageURLValue',
                'includeWrappingTag' => false,

            ],
            '@namespaces' => [
                'wal' => 'http://walmart.com/',
            ],
        ];

        $a2x = new A2X($items, $schema);
        $xml = $a2x->asXml();
        
//        echo $xml;
//        die();
        $file = new PostFile('file', $xml, 'file.xml', ['Content-Type' => 'text/xml']);

        return $this->bulkUpdate([
            'file' => $file,
        ]);
    }
}