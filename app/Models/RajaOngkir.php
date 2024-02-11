<?php


namespace App\Models;


use GuzzleHttp\Client;

class RajaOngkir
{
    /**
     * @var Client
     */
    private $client;

    /**
     * Status code of the last request.
     * @var int
     */
    private $statusCode;

    public function __construct() {
        $this->client = new Client([
            'base_uri' => config('rajaongkir.endpoint'),
            'headers' => [
                'key' => config('rajaongkir.key')
            ]
        ]);
    }

    /**
     * @param string $origin
     * @param string $destination
     * @param int|double $weight
     * @param string $courier
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function costs($origin, $destination, $weight, $courier)
    {
        $ongkir = $this->client->post('/starter/cost', ['form_params' => compact('origin', 'destination', 'weight', 'courier')]);
        $this->statusCode = $ongkir->getStatusCode();
        $results = [];

        if ($ongkir->getStatusCode() === 200) {
            $response = json_decode($ongkir->getBody()->getContents());
            if (isset($response->rajaongkir->status->code) && $response->rajaongkir->status->code === 200) {
                $results = $response->rajaongkir->results[0] ?: [];
            }
        }

        return $results;
    }

    /**
     * @param $origin
     * @param $destination
     * @param $weight
     * @param $courier
     * @param $service
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getService($origin, $destination, $weight, $courier, $service)
    {
        $costs = collect($this->costs($origin, $destination, $weight, $courier)->costs);

        if ($selectedService = $costs->firstWhere('service', $service)) {
            return $selectedService;
        }

        throw new \RuntimeException('The selected service is not found!');
    }

    public function getStatusCode()
    {
        return $this->statusCode;
    }
}
