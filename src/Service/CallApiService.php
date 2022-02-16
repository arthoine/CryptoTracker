<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ContainerInterface;

class CallApiService extends AbstractController
{
    private $client;


    public function __construct(HttpClientInterface  $client)
    {
        $this->client = $client->withOptions([
            'base_uri' => 'https://pro-api.coinmarketcap.com/v1/cryptocurrency/listings/latest',
            'headers' => ['X-CMC_PRO_API_KEY' => 'ab069ae6-1c42-47d8-8498-1ea2e555333e']
        ]);
    }


    public function getCrypto(): array
    {
        $response = $this->client->request('GET', 'https://pro-api.coinmarketcap.com/v1/cryptocurrency/listings/latest', [
            /*'headers' => [
                'X-CMC_PRO_API_KEY' => 'ab069ae6-1c42-47d8-8498-1ea2e555333e',
            ],*/
            'query' => [
                'start' => '1',
                'limit' => '500',
                'convert' => 'EUR'
            ],
        ]);

        return $response->toarray();
    }
}



