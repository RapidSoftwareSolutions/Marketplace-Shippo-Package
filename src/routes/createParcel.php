<?php
$app->post('/api/Shippo/createParcel', function ($request, $response, $args) {
    $settings = $this->settings;

    //checking properly formed json
    $checkRequest = $this->validation;
    $validateRes = $checkRequest->validate($request, ['apiKey', 'parcelLength', 'parcelWidth', 'parcelHeight', 'measurementUnit', 'parcelWeight', 'weightUnit']);
    if (!empty($validateRes) && isset($validateRes['callback']) && $validateRes['callback'] == 'error') {
        return $response->withHeader('Content-type', 'application/json')->withStatus(200)->withJson($validateRes);
    } else {
        $post_data = $validateRes;
    }
    //forming request to vendor API
    $query_str = $settings['api_url'] . "parcels";

    $body['length'] = $post_data['args']['parcelLength'];
    $body['width'] = $post_data['args']['parcelWidth'];
    $body['height'] = $post_data['args']['parcelHeight'];
    $body['distance_unit'] = $post_data['args']['measurementUnit'];
    $body['weight'] = $post_data['args']['parcelWeight'];
    $body['mass_unit'] = $post_data['args']['weightUnit'];

    if (isset($post_data['args']['template']) && ($post_data['args']['template'] > 0)) {
        $body['template'] = $post_data['args']['template'];
    };
    if (isset($post_data['args']['extra']) && strlen($post_data['args']['extra'] > 0)) {
        $body['extra'] = $post_data['args']['extra'];
    };
    if (isset($post_data['args']['metadata']) && (strlen($post_data['args']['metadata'] > 0))) {
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