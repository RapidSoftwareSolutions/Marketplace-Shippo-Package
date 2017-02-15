<?php
$app->post('/api/Shippo/createAddress', function ($request, $response, $args) {
    $settings = $this->settings;

    //checking properly formed json
    $checkRequest = $this->validation;
    $validateRes = $checkRequest->validate($request, ['apiKey', 'name', 'objectPurpose', 'street1', 'zip', 'state', 'country', 'email', 'city']);
    if (!empty($validateRes) && isset($validateRes['callback']) && $validateRes['callback'] == 'error') {
        return $response->withHeader('Content-type', 'application/json')->withStatus(200)->withJson($validateRes);
    } else {
        $post_data = $validateRes;
    }
    //forming request to vendor API
    $query_str = $settings['api_url'] . "addresses";


    $body['name'] = $post_data['args']['name'];
    $body['object_purpose'] = $post_data['args']['objectPurpose'];
    if (isset($post_data['args']['company']) and (strlen($post_data['args']['company']) > 0)) {
        $body['company'] = $post_data['args']['company'];
    }
    $body['street1'] = $post_data['args']['street1'];

    if (isset($post_data['args']['streetNo']) and (strlen($post_data['args']['streetNo']) > 0)) {
        $body['street_no'] = $post_data['args']['streetNo'];
    };

    if (isset($post_data['args']['street2']) and (strlen($post_data['args']['street2']) > 0)) {
        $body['street2'] = $post_data['args']['street2'];
    };

    if (isset($post_data['args']['street3']) and (strlen($post_data['args']['street3']) > 0)) {
        $body['street3'] = $post_data['args']['street3'];
    };

    $body['city'] = $post_data['args']['city'];

    $body['zip'] = $post_data['args']['zip'];

    $body['state'] = $post_data['args']['state'];

    $body['country'] = $post_data['args']['country'];

    if (isset($post_data['args']['phone']) and (strlen($post_data['args']['phone']) > 0)) {
        $body['phone'] = $post_data['args']['phone'];
    };

    $body['email'] = $post_data['args']['email'];

    if (isset($post_data['args']['isResidential']) and (strlen($post_data['args']['isResidential']) > 0)) {
        $body['is_residential'] = $post_data['args']['isResidential'];
    };

    if (isset($post_data['args']['validate']) and (strlen($post_data['args']['validate']) > 0)) {
        $body['validate'] = $post_data['args']['validate'];
    };

    if (isset($post_data['args']['metadata']) and (strlen($post_data['args']['metadata']) > 0)) {
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