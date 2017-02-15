<?php
$app->post('/api/Shippo/createCustomsItem', function ($request, $response, $args) {
    $settings = $this->settings;

    //checking properly formed json
    $checkRequest = $this->validation;
    $validateRes = $checkRequest->validate($request, ['apiKey', 'itemDescription', 'itemQuantity', 'itemNetWeight', 'itemWeightMeasurementUnit', 'itemValue', 'itemValueCurrency', 'itemOriginCountry']);
    if (!empty($validateRes) && isset($validateRes['callback']) && $validateRes['callback'] == 'error') {
        return $response->withHeader('Content-type', 'application/json')->withStatus(200)->withJson($validateRes);
    } else {
        $post_data = $validateRes;
    }
    //forming request to vendor API


    $query_str = $settings['api_url'] . "customs/items";

    //requesting remote API
    $client = new GuzzleHttp\Client();

    $body['description'] = $post_data['args']['itemDescription'];
    $body['quantity'] = $post_data['args']['itemQuantity'];
    $body['net_weight'] = $post_data['args']['itemNetWeight'];
    $body['mass_unit'] = $post_data['args']['itemWeightMeasurementUnit'];
    $body['value_amount'] = $post_data['args']['itemValue'];
    $body['value_currency'] = $post_data['args']['itemValueCurrency'];
    $body['origin_country'] = $post_data['args']['itemOriginCountry'];

    if (isset($post_data['args']['itemTariffNumber']) && strlen($post_data['args']['itemTariffNumber']) > 0) {
        $body['tariff_number'] = $post_data['args']['itemTariffNumber'];
    };
    if (isset($post_data['args']['metadata']) && strlen($post_data['args']['metadata']) > 0) {
        $body['metadata'] = $post_data['args']['metadata'];
    };

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