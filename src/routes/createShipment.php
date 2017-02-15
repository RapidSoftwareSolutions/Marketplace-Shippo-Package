<?php
$app->post('/api/Shippo/createShipment', function ($request, $response, $args) {
    $settings = $this->settings;

    //checking properly formed json
    $checkRequest = $this->validation;
    $validateRes = $checkRequest->validate($request, ['apiKey', 'objectPurpose', 'addressToId', 'addressFromId', 'parcelId' ]);

    if (!empty($validateRes) && isset($validateRes['callback']) && $validateRes['callback'] == 'error') {
        return $response->withHeader('Content-type', 'application/json')->withStatus(200)->withJson($validateRes);
    } else {
        $post_data = $validateRes;
    };

    //forming request to vendor API
    $query_str = $settings['api_url'] . "shipments";

    //creating destination address object
    $body['object_purpose'] = $post_data['args']['objectPurpose'];
    $body['address_to'] = $post_data['args']['addressToId'];


    //creating source address object

    $body['address_from'] = $post_data['args']['addressFromId'];


    //creating parcel object
    $body['parcel'] = $post_data['args']['parcelId'];


    if (isset($post_data['args']['submissionDate']) && ($post_data['args']['submissionDate'] > 0)) {
        $body['submission_date'] = $post_data['args']['submissionDate'];
    };

    if (isset($post_data['args']['addressReturnId']) && ($post_data['args']['addressReturnId'] > 0)) {
        $body['address_return'] = $post_data['args']['addressReturnId'];
    };


    if (isset($post_data['args']['customsDeclarationId']) && ($post_data['args']['customsDeclarationId'] > 0)) {
        $body['customs_declaration'] = $post_data['args']['customsDeclarationId'];
    };

    if (isset($post_data['args']['insuranceAmount']) && ($post_data['args']['insuranceAmount'] > 0)) {
        $body['insurance_amount'] = $post_data['args']['insuranceAmount'];
    };

    if (isset($post_data['args']['insuranceCurrency']) && ($post_data['args']['insuranceCurrency'] > 0)) {
        $body['insurance_currency'] = $post_data['args']['insuranceCurrency'];
    };

    if (isset($post_data['args']['extra']) && ($post_data['args']['extra'] > 0)) {
        $body['extra'] = $post_data['args']['extra'];
    };

    if (isset($post_data['args']['reference1']) && ($post_data['args']['reference1'] > 0)) {
        $body['reference_1'] = $post_data['args']['reference1'];
    };

    if (isset($post_data['args']['reference2']) && ($post_data['args']['reference2'] > 0)) {
        $body['reference_2'] = $post_data['args']['reference2'];
    };

    if (isset($post_data['args']['metadata']) && ($post_data['args']['metadata'] > 0)) {
        $body['metadata'] = $post_data['args']['metadata'];
    };

    if (isset($post_data['args']['async']) && ($post_data['args']['async'] > 0)) {
        $body['async'] = $post_data['args']['async'];
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
        if ($response->getStatusCode() == '200') {
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