<?php

namespace Test\Functional;

require_once(__DIR__ . '/../../src/Models/checkRequest.php');
class ShippoTest extends BaseTestCase {

    public function testListMetrics() {

        $routes = [
            'registerTrackingWebhook',
            'getTrackingStatus',
            'getSingleManifest',
            'getManifests',
            'createManifest',
            'getSingleCarrierAccount',
            'getCarrierAccounts',
            'updateCarrierAccount',
            'createCarrierAccount',
            'getSingleRefund',
            'getRefunds',
            'createRefund',
            'getSingleCustomsDeclaration',
            'getCustomsDeclarations',
            'createCustomsDeclaration',
            'getSingleCustomsItem',
            'getCustomsItems',
            'createCustomsItem',
            'getSingleTransaction',
            'getTransactions',
            'createTransaction',
            'createTransactionBasedOnRate',
            'getShipmentSingleRate',
            'getShipmentRates',
            'getSingleShipment',
            'getShipments',
            'createShipment',
            'getSingleParcel',
            'getParcels',
            'createParcel',
            'validateSingleAddress',
            'getSingleAddress',
            'getAddresses',
            'createAddress'
        ];

        foreach($routes as $file) {
            $var = '{  
                    }';
            $post_data = json_decode($var, true);

            $response = $this->runApp('POST', '/api/Shippo/'.$file, $post_data);

            $this->assertEquals(200, $response->getStatusCode(), 'Error in '.$file.' method');
        }
    }

}
