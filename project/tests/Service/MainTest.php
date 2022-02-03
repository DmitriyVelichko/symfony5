<?php

namespace App\Tests\Service;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MainTest extends WebTestCase
{
    public function testMyTest(): void
    {
        $client = self::createClient();

        $client->request('GET', '/author/create', ['name' => 'Автор123456']);
        self::assertResponseIsSuccessful();
        $response = $client->getResponse();
        $this->assertSame(200, $response->getStatusCode());
        $responseData = json_decode($response->getContent(), true);
        var_dump($responseData);

        $client->request('GET', '/author/search', ['name' => 'Автор123456']);
        self::assertResponseIsSuccessful();
        $response = $client->getResponse();
        $this->assertSame(200, $response->getStatusCode());
        $responseData = json_decode($response->getContent(), true);
        var_dump($responseData);

        $client->request('GET', '/ru/book/create', ['name' => 'Книга123456', 'author' => 'Автор123456']);
        self::assertResponseIsSuccessful();
        $response = $client->getResponse();
        $this->assertSame(200, $response->getStatusCode());
        $responseData = json_decode($response->getContent(), true);
        var_dump($responseData);

        $client->request('GET', '/ru/book/search', ['name' => 'Книга123456']);
        self::assertResponseIsSuccessful();
        $response = $client->getResponse();
        $this->assertSame(200, $response->getStatusCode());
        $responseData = json_decode($response->getContent(), true);
        var_dump($responseData);
    }
}
