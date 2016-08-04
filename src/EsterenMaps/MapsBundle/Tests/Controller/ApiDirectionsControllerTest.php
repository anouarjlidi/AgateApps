<?php

namespace Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Tests\WebTestCase;

class ApiDirectionsControllerTest extends WebTestCase
{
    /**
     * @dataProvider provideWorkingDirections
     *
     * @param array   $expectedData
     * @param integer $map
     * @param integer $from
     * @param integer $to
     * @param null    $transport
     */
    public function testWorkingDirections(array $expectedData, $map, $from, $to, $transport = null)
    {
        $client = $this->getClient('api.esteren.dev', [], 'ROLE_MAPS_VIEW');
        $client->setServerParameter('HTTP_ORIGIN', 'http://maps.esteren.dev/');

        $client->request('GET', sprintf(
            '/fr/maps/directions/%s/%s/%s?transport=%s',
            $map, $from, $to, $transport
        ));

        $response = $client->getResponse();

        static::assertInstanceOf(JsonResponse::class, $response);

        if ($response instanceof JsonResponse) {
            $json = json_decode($response->getContent(), true);

            foreach ($expectedData as $key => $expectedValue) {
                static::assertArrayHasKey($key, $json);
                if (array_key_exists($key, $json)) {
                    static::assertEquals($expectedValue, $json[$key], 'Json response key "'.$key.'" has invalid value.');
                }
            }
        }
    }

    public function provideWorkingDirections()
    {
        return [
            [
                [
                    'found' => true,
                    'from_cache' => false,
                    'number_of_steps' => 16,
                ],
                1, 76, 40, 1 // From "Pointe de Hòb" to "Col de Gaos-Bodhar" with default transport
            ],
            [
                [
                    'found' => true,
                    'from_cache' => false,
                    'number_of_steps' => 16,
                ],
                1, 76, 40, 2 // From "Pointe de Hòb" to "Col de Gaos-Bodhar" with "Chariot" transport
            ],
        ];
    }
}
