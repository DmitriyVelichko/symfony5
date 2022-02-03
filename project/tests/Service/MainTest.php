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
        $this->assertArrayHasKey('id', $responseData);

        $client->request('GET', '/author/search', ['name' => 'Автор123456']);
        self::assertResponseIsSuccessful();
        $response = $client->getResponse();
        $this->assertSame(200, $response->getStatusCode());
        $responseData = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('author', $responseData);
        $this->assertArrayHasKey('id', $responseData);
        $this->assertArrayHasKey('name', $responseData);

        $client->request('GET', '/ru/book/create', ['name' => 'Книга123456', 'author' => 'Автор123456']);
        self::assertResponseIsSuccessful();
        $response = $client->getResponse();
        $this->assertSame(200, $response->getStatusCode());
        $responseData = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('id', $responseData);

        $client->request('GET', '/ru/book/search', ['name' => 'Книга123456']);
        self::assertResponseIsSuccessful();
        $response = $client->getResponse();
        $this->assertSame(200, $response->getStatusCode());
        $responseData = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('book', $responseData);
        $this->assertArrayHasKey('id', $responseData);
        $this->assertArrayHasKey('author', $responseData);
        $this->assertArrayHasKey('name', $responseData);
    }
}
