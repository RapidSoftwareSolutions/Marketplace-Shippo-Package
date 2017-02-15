<?php
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
    'createAddress',
    'metadata'
];
foreach ($routes as $file) {
    require __DIR__ . '/../src/routes/' . $file . '.php';
}

