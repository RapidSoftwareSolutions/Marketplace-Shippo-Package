<?php
$app->post('/api/Shippo/createCustomsDeclaration', function ($request, $response, $args) {
    $settings = $this->settings;

    //checking properly formed json
    $checkRequest = $this->validation;
    $validateRes = $checkRequest->validate($request, ['apiKey', 'declarationCertifySigner', 'certify', 'declarationItems', 'declarationNonDeliveryOption', 'declarationContentsType']);
    if (!empty($validateRes) && isset($validateRes['callback']) && $validateRes['callback'] == 'error') {
        return $response->withHeader('Content-type', 'application/json')->withStatus(200)->withJson($validateRes);
    } else {
        $post_data = $validateRes;
    }
    //forming request to vendor API
    $query_str = $settings['api_url'] . "customs/declarations";

    $body['certify_signer'] = $post_data['args']['declarationCertifySigner'];
    $body['certify'] = $post_data['args']['certify'];
    $body['items'] = $post_data['args']['declarationItems'];
    $body['non_delivery_option'] = $post_data['args']['declarationNonDeliveryOption'];
    $body['contents_type'] = $post_data['args']['declarationContentsType'];

    if (isset($post_data['args']['declarationContentsExplanation']) && strlen($post_data['args']['declarationContentsExplanation'])) {
        $body['contents_explanation'] = $post_data['args']['declarationContentsExplanation'];
    };
    if (isset($post_data['args']['declarationExporterReference']) && strlen($post_data['args']['declarationExporterReference'])) {
        $body['exporter_reference'] = $post_data['args']['declarationExporterReference'];
    };
    if (isset($post_data['args']['declarationImporterReference']) && strlen($post_data['args']['declarationImporterReference'])) {
        $body['importer_reference'] = $post_data['args']['declarationImporterReference'];
    };
    if (isset($post_data['args']['declarationInvoice']) && strlen($post_data['args']['declarationInvoice'])) {
        $body['invoice'] = $post_data['args']['declarationInvoice'];
    };
    if (isset($post_data['args']['declarationLicense']) && strlen($post_data['args']['declarationLicense'])) {
        $body['license'] = $post_data['args']['declarationLicense'];
    };
    if (isset($post_data['args']['declarationCertificate']) && strlen($post_data['args']['declarationCertificate'])) {
        $body['certificate'] = $post_data['args']['declarationCertificate'];
    };
    if (isset($post_data['args']['declarationNotes']) && strlen($post_data['args']['declarationNotes'])) {
        $body['notes'] = $post_data['args']['declarationNotes'];
    };
    if (isset($post_data['args']['declarationEelPfc']) && strlen($post_data['args']['declarationEelPfc'])) {
        $body['eel_pfc'] = $post_data['args']['declarationEelPfc'];
    };
    if (isset($post_data['args']['declarationAesItn']) && strlen($post_data['args']['declarationAesItn'])) {
        $body['aes_itn'] = $post_data['args']['declarationAesItn'];
    };
    if (isset($post_data['args']['declarationIncoterm']) && strlen($post_data['args']['declarationIncoterm'])) {
        $body['incoterm'] = $post_data['args']['declarationIncoterm'];
    };
    if (isset($post_data['args']['declarationMetadata']) && strlen($post_data['args']['declarationMetadata'])) {
        $body['metadata'] = $post_data['args']['declarationMetadata'];
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