<?php

use Procountor\Procountor\Client;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Log\LoggerInterface;

it('calls logger on request', function () {
    $logMessage = null;
    $logContext = null;
    $logger = mock(LoggerInterface::class)
        ->shouldReceive('info')
        ->with(Mockery::capture($logMessage), Mockery::capture($logContext))
        ->once()
        ->mock();
    $httpClient = mock(ClientInterface::class)
        ->shouldReceive('sendRequest')
        ->with(Mockery::type(RequestInterface::class))
        ->andReturn(
            // first request creates access token
            $this->createResponse(200, json_encode(['access_token' => 'qwertyuiop'])),
            // second request fetches resource
            $this->createResponse(200)
        )
        ->mock();
    /** @var Client $client */
    $client = $this->createClient(
        logger: $logger,
        httpClient: $httpClient,
    );
    $request = $client->createRequest(Client::HTTP_GET, Client::RESOURCE_INVOICE);
    $client->request($request);
    // $this->assertEquals('nginx', $responseHeaders['Server'][0]);
});
