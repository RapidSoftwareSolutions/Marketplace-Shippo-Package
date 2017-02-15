[![](https://scdn.rapidapi.com/RapidAPI_banner.png)](https://rapidapi.com/package/Shippo/functions?utm_source=RapidAPIGitHub_ShippoFunctions&utm_medium=button&utm_content=RapidAPI_GitHub) 

# Shippo Package
Shipping
* Domain: shippo.com
* Credentials: apiKey

## How to get credentials: 
0. Go to [Shippo website](http://shippo.com) 
1. Log in or create a new account
2. Go to [API page](https://app.goshippo.com/api/) to get your API key

## Shippo.createAddress
Creates a new address object

| Field        | Type       | Description
|--------------|------------|----------
| apiKey       | credentials| The api key obtained from Shippo.
| name         | String     | Name for the address.
| objectPurpose| String     | Purpose of the new address. Possible valuse: QUOTE or PURCHASE.
| company      | String     | Company at the provided address.
| street1      | String     | Street of the address.
| streetNo     | String     | Optional additional info about the address.
| street2      | String     | Optional additional info about the address.
| street3      | String     | Optional additional info about the address.
| city         | String     | City of the address.
| zip          | String     | Zip code of the address.
| state        | String     | State of the address, if applied (otherwise leave empty).
| country      | String     | ISO 3166-1-alpha-2 code (ISO 2 country code).
| phone        | String     | Phone of the address.
| email        | String     | Email of the address.
| isResidential| Boolean    | Describes if a person is residential.
| validate     | Boolean    | Describes if address requires validation.
| metadata     | String     | Metadata for the address.

## Shippo.getAddresses
Retrieves list of addresses

| Field | Type       | Description
|-------|------------|----------
| apiKey| credentials| The api key obtained from Shippo.

## Shippo.getSingleAddress
Retrieves single address.

| Field    | Type       | Description
|----------|------------|----------
| apiKey   | credentials| The api key obtained from Shippo.
| addressId| credentials| Id of the address.

## Shippo.validateSingleAddress
Validates single address.

| Field    | Type       | Description
|----------|------------|----------
| apiKey   | credentials| The api key obtained from Shippo.
| addressId| String     | Id of the address.

## Shippo.createParcel
Creates a new parcel object.

| Field          | Type       | Description
|----------------|------------|----------
| apiKey         | credentials| The api key obtained from Shippo.
| parcelLength   | String     | Length of the parcel.
| parcelWidth    | String     | Width of the parcel.
| parcelHeight   | String     | Height of the parcel.
| measurementUnit| String     | Measurement units. Possible values: cm, in, ft, mm, m, yd
| parcelWeight   | String     | Weight of the parcel.
| weightUnit     | String     | Measurement units. Possible values: g, oz, lb, kg
| template       | String     | Template of the parcel.
| metadata       | String     | EMtadata of the parcel.
| extra          | JSON       | Extra data of the parcel.

## Shippo.getParcels
Retrieves list of parcels.

| Field | Type       | Description
|-------|------------|----------
| apiKey| credentials| The api key obtained from Shippo.

## Shippo.getSingleParcel
Retrieves one parcel information.

| Field   | Type       | Description
|---------|------------|----------
| apiKey  | credentials| The api key obtained from Shippo.
| parcelId| String     | Id of the parcels.

## Shippo.createShipment
Creates a new shipment object.

| Field               | Type       | Description
|---------------------|------------|----------
| apiKey              | credentials| The api key obtained from Shippo.
| objectPurpose       | String     | Purpose of the new shipment. Possible valuse: QUOTE or PURCHASE.
| addressToId         | String     | Address of the receiver
| addressToId         | String     | Address of the sender
| parcelId            | String     | parcel Id
| addressReturnId     | String     | Address of the return
| submissionDate      | String     | Datetime of the submission
| customsDeclarationId| String     | Customs declaration Id
| insuranceAmount     | String     | Insurance amount
| insuranceCurrency   | String     | Currency of insurance amount. ISO 4217 Currency Code
| extra               | JSON       | Extra information about the shipment
| reference1          | String     | Reference information
| reference2          | String     | Additional reference information
| metadata            | String     | Metadata of the shipment
| async               | Boolean    | Shipment async of not

## Shippo.getShipments
Retrieves list of shipments.

| Field | Type       | Description
|-------|------------|----------
| apiKey| credentials| The api key obtained from Shippo.

## Shippo.getSingleShipment
Retrieves one shipment from the list.

| Field     | Type       | Description
|-----------|------------|----------
| apiKey    | credentials| The api key obtained from Shippo.
| shipmentId| String     | Id of the shipment

## Shippo.getShipmentRates
Retrieves list of rates for single shipment.

| Field       | Type       | Description
|-------------|------------|----------
| apiKey      | credentials| The api key obtained from Shippo.
| shipmentId  | String     | Id of the shipment
| currencyCode| String     | Code of the currency

## Shippo.getShipmentSingleRate
Retrieves list of rates for single shipment.

| Field | Type       | Description
|-------|------------|----------
| apiKey| credentials| The api key obtained from Shippo.
| rateId| String     | Id of the rate

## Shippo.createTransactionBasedOnRate
Creates a new transaction object and purchases the shipping label for the provided rate.

| Field        | Type       | Description
|--------------|------------|----------
| apiKey       | credentials| The api key obtained from Shippo.
| rateId       | String     | Id of the rate
| labelFileType| String     | Filetypes of the label. Possible values: PNG, PDF, PDF_4X6,ZPLII
| metadata     | String     | Metadata for the transaction
| async        | Boolean    | Sets if transaction is async

## Shippo.createTransaction
Creates a new transaction object and purchases the shipping label for the provided rate.

| Field                | Type       | Description
|----------------------|------------|----------
| apiKey               | credentials| The api key obtained from Shippo.
| shipmentObjectPurpose| String     | Purpose of the new shipment. Possible valuse: QUOTE or PURCHASE.
| shipmentAddressToId  | String     | Address of the receiver
| shipmentAddressFromId| String     | Address of the sender
| parcelId             | String     | Id of the parcel
| serviceLevelToken    | String     | Specific rates when purchasing shipping label. Possible values are described at this page: https://goshippo.com/docs/reference#servicelevels
| carrierAccount       | String     | Carrier accounts are used as credentials to retrieve shipping rates and purchase labels from a shipping provider.
| labelFileType        | String     | Filetypes of the label. Possible values: PNG, PDF, PDF_4X6,ZPLII
| metadata             | String     | Metadata for the transaction

## Shippo.getTransactions
Retrieves list of transactions.

| Field | Type       | Description
|-------|------------|----------
| apiKey| credentials| The api key obtained from Shippo.

## Shippo.getSingleTransaction
Retrieves single transaction from the list of transactions.

| Field        | Type       | Description
|--------------|------------|----------
| apiKey       | credentials| The api key obtained from Shippo.
| transactionId| String     | Id of the transaction

## Shippo.createCustomsItem
Creates a new Customs Item object.

| Field                    | Type       | Description
|--------------------------|------------|----------
| apiKey                   | credentials| The api key obtained from Shippo.
| itemDescription          | String     | Description of the item
| itemQuantity             | Number     | Quantity of the item
| itemNetWeight            | String     | Net weight of the item
| itemWeightMeasurementUnit| String     | Measurement units. Possible values: g, oz, lb, kg
| itemValue                | String     | Value of the item
| itemValueCurrency        | String     | ISO 4217 Currency Code
| itemOriginCountry        | String     | ISO 3166-1-alpha-2 code (ISO 2 country code)
| itemTariffNumber         | String     | Number of item tariff
| metadata                 | String     | Item metadata

## Shippo.getCustomsItems
Retrieves list of customs items.

| Field | Type       | Description
|-------|------------|----------
| apiKey| credentials| The api key obtained from Shippo.

## Shippo.getSingleCustomsItem
Retrieves single customs item from the list of customs items.

| Field        | Type       | Description
|--------------|------------|----------
| apiKey       | credentials| The api key obtained from Shippo.
| customsItemId| String     | Id of the customs item

## Shippo.createCustomsDeclaration
Createsnew customs declaration

| Field                         | Type       | Description
|-------------------------------|------------|----------
| apiKey                        | credentials| The api key obtained from Shippo.
| declarationCertifySigner      | String     | Certify signer
| certify                       | Boolean    | Sets certify
| declarationItems              | Array      | Ids of items icluded in declaration
| declarationNonDeliveryOption  | String     | Options is case of non delivery. Possible values: ABANDON OR RETURN
| declarationContentsType       | String     | Type of items. Possible values: DOCUMENTS, GIFT, SAMPLE, MERCHANDISE, HUMANITARIAN, DONATION, RETURN, OTHER
| declarationContentsExplanation| String     | Explanatin of items content. Required only if declarationContentsType is OTHER
| declarationExporterReference  | String     | Reference of the exporter.
| declarationImporterReference  | String     | Reference of the importer.
| declarationInvoice            | String     | Invoice for the declaration.
| declarationLicense            | String     | License for the declaration.
| declarationCertificate        | String     | Certificate for the declaration.
| declarationNotes              | String     | Notes for the declaration.
| declarationEelPfc             | String     | Possible values: 'NOEEI_30_37_a', 'NOEEI_30_37_h', 'NOEEI_30_36', 'AES_ITN'
| declarationAesItn             | String     | required if declarationEelPfc is 'AES_ITN'
| declarationIncoterm           | String     | Possible values: 'DDP', 'DDU', 'CPT', 'CIP'
| declarationMetadata           | String     | Metadata of the declaration

## Shippo.getCustomsDeclarations
Retrieves list of customs declarations.

| Field | Type       | Description
|-------|------------|----------
| apiKey| credentials| The api key obtained from Shippo.

## Shippo.getSingleCustomsDeclaration
Retrieves single declaration from the list of customs declarations.

| Field        | Type       | Description
|--------------|------------|----------
| apiKey       | credentials| The api key obtained from Shippo.
| declarationId| String     | Id of the customs declaration.

## Shippo.createRefund
Creates new refund object.

| Field        | Type       | Description
|--------------|------------|----------
| apiKey       | credentials| The api key obtained from Shippo.
| transactionId| String     | Id of the transaction for refund.

## Shippo.getRefunds
Retrieves list of refunds.

| Field | Type       | Description
|-------|------------|----------
| apiKey| credentials| The api key obtained from Shippo.

## Shippo.getSingleRefund
Retrieves single refund from the list of refunds.

| Field   | Type       | Description
|---------|------------|----------
| apiKey  | credentials| The api key obtained from Shippo.
| refundId| String     | Id of the refund.

## Shippo.createCarrierAccount
Creates new carrier account object.

| Field               | Type       | Description
|---------------------|------------|----------
| apiKey              | credentials| The api key obtained from Shippo.
| carrierName         | String     | Name of the carrier. You can find list of carriers at this page - https://goshippo.com/docs/carriers.
| carrierAccountId    | String     | Unique identifier of the account. You can find list of carriers at this page - https://goshippo.com/docs/carriers.
| carrierParameters   | JSON       | Additional parameters for the account, such as e.g. password or token. You can find list of carriers at this page - https://goshippo.com/docs/carriers.
| carrierAccountActive| Boolean    | Determines whether the account is enabled. Default is enabled.

## Shippo.updateCarrierAccount
Updates existing carrier account object. carrierName and carrierAccountId can't be updated, because they form the unique identifier together.

| Field                 | Type       | Description
|-----------------------|------------|----------
| apiKey                | credentials| The api key obtained from Shippo.
| carrierAccountObjectId| String     | Object account id to update.
| carrierParameters     | JSON       | Additional parameters for the account, such as e.g. password or token. You can find list of carriers at this page - https://goshippo.com/docs/carriers.
| carrierAccountActive  | Boolean    | Determines whether the account is enabled. Default is enabled.

## Shippo.getCarrierAccounts
Retrieves list of carrier accounts.

| Field | Type       | Description
|-------|------------|----------
| apiKey| credentials| The api key obtained from Shippo.

## Shippo.getSingleCarrierAccount
Retrieves single accout object from the list of carrier accounts.

| Field                 | Type       | Description
|-----------------------|------------|----------
| apiKey                | credentials| The api key obtained from Shippo.
| carrierAccountObjectId| String     | Object account id to get.

## Shippo.getManifests
Retrieves list of manifests.

| Field | Type       | Description
|-------|------------|----------
| apiKey| credentials| The api key obtained from Shippo.

## Shippo.getSingleManifest
Retrieves single manifest from the list of manifests.

| Field     | Type       | Description
|-----------|------------|----------
| apiKey    | credentials| The api key obtained from Shippo.
| manifestId| String     | Id of the manifest.

## Shippo.getTrackingStatus
Retrieves status for the tracking number.

| Field      | Type       | Description
|------------|------------|----------
| apiKey     | credentials| The api key obtained from Shippo.
| carrierName| String     | Name of the carrier for the current tracking
| trackingId | String     | Id of the tracking

## Shippo.registerTrackingWebhook
Registers your webhook for a shipment

| Field      | Type       | Description
|------------|------------|----------
| apiKey     | credentials| The api key obtained from Shippo.
| carrierName| String     | Name of the carrier for the current tracking
| trackingId | String     | Id of the tracking

