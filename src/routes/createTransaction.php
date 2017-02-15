<?php
$app->post('/api/Shippo/createTransaction', function ($request, $response, $args) {
    $settings = $this->settings;

    //checking properly formed json
    $checkRequest = $this->validation;
    $validateRes = $checkRequest->validate($request, ['apiKey', 'shipmentObjectPurpose', 'shipmentAddressToId', 'shipmentAddressFromId', 'shipmentParcelId', 'serviceLevelToken', 'carrierAccount']);
    if (!empty($validateRes) && isset($validateRes['callback']) && $validateRes['callback'] == 'error') {
        return $response->withHeader('Content-type', 'application/json')->withStatus(200)->withJson($validateRes);
    } else {
        $post_data = $validateRes;
    }
    //forming request to vendor API


    $query_str = $settings['api_url'] . "transactions";

    $body['shipment']['object_purpose'] = $post_data['args']['shipmentObjectPurpose'];
    $body['shipment']['address_to'] = $post_data['args']['shipmentAddressToId'];
    $body['shipment']['address_from'] = $post_data['args']['shipmentAddressFromId'];
    $body['shipment']['parcel'] = $post_data['args']['shipmentParcelId'];
    $body['servicelevel_token'] = $post_data['args']['serviceLevelToken'];
    $body['carrier_account'] = $post_data['args']['carrierAccount'];

    if ($post_data['args']['labelFileType']) {
        $body['label_file_type'] = $post_data['args']['labelFileType'];
    };
    if ($post_data['args']['metadata']) {
        $body['metadata'] = $post_data['args']['metadata'];
    };

    //requesting remote API
    $client = new GuzzleHttp\Client();

    try {

        $resp = $client->request('POST', $query_str, [
            'headers' => ['Authorization' => 'ShippoToken ' . $post_data['args']['apiKey']],
            'json' => $body
        ]);

        $responseBody = $resp->getBody()->getContents();
        $rawBody = json_decode($resp->getBody());

        $all_data[] = $rawBody;
        if ($response->getStatusCode() == '200' && $rawBody->object_state == 'VALID') {
            $result['callback'] = 'success';
            $result['contextWrites']['to'] = is_array($all_data) ? $all_data : json_decode($all_data);
        } else {
            $result['callback'] = 'error';
            $result['contextWrites']['to']['status_code'] = 'API_ERROR';
            $result['contextWrites']['to']['status_msg'] = is_array($responseBody) ? $responseBody : json_decode($responseBody);
        }

    } catch (\GuzzleHttp\Exception\ClientException $exception) {

        $responseBody = $exception->getResponse()->getBody();
        $result['callback'] = 'error';
        $result['contextWrites']['to'] = json_decode($responseBody);

    } catch (GuzzleHttp\Exception\ServerException $exception) {

        $responseBody = $exception->getResponse()->getBody(true);
        $result['callback'] = 'error';
        $result['contextWrites']['to'] = json_decode($responseBody);

    } catch (GuzzleHttp\Exception\BadResponseException $exception) {

        $responseBody = $exception->getResponse()->getBody(true);
        $result['callback'] = 'error';
        $result['contextWrites']['to'] = json_decode($responseBody);

    }


    return $response->withHeader('Content-type', 'application/json')->withStatus(200)->withJson($result);

});