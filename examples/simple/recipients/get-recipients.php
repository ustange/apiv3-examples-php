<?php

use Camspiers\JsonPretty\JsonPretty;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

require_once __DIR__ . '/../../../vendor/autoload.php';

// Recipientlist ID to get recipients for
$recipientlistId = null; // TODO specify

// Specify api credentials
$username = ''; // TODO specify
$password = ''; // TODO specify

$client = new Client([
    // Base URI for all guzzle requests, remember that the emailsys API only supports HTTPS
    'base_uri' => 'https://apiv3.emailsys.net'
]);

// A simple utility to prettify json data
$pretty = new JsonPretty();

try {

    $response = $client->get('/recipients', [
        // Guzzle request headers API is documented here: http://guzzle.readthedocs.io/en/stable/request-options.html#headers
        'headers' => [
            // The accept header tells the API that you expect JSON to be returned
            'Accept' => 'application/json'
        ],
        // Guzzle request authentication is documented here: http://guzzle.readthedocs.io/en/stable/request-options.html#auth
        'auth' => [
            $username,
            $password
        ],
        'query' => [
            // Guzzle query string param API is documented here http://guzzle.readthedocs.io/en/stable/quickstart.html#query-string-parameters
            'recipientlist_id' => $recipientlistId // recipientlist_id filter is required
        ]
    ]);

    echo $pretty->prettify((string)$response->getBody()) . PHP_EOL;

} catch (ClientException $e) {

    // Guzzle exception handling is documented here: http://guzzle.readthedocs.io/en/stable/quickstart.html#exceptions
    // ClientException is thrown for any 4XX HTTP statuscode (client errors)

    if ($e->hasResponse()) {
        echo $pretty->prettify((string)$e->getResponse()->getBody()) . PHP_EOL;
    }

}
