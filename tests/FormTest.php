<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class FormTest extends WebTestCase
{
    public function testSomething(): void
    {
        $client = static::createClient();
        $client->request('GET', '/inscription');

        $client->submitForm('Enregistrer', [
            'register_user[lastName]' => "rakoto",
            'register_user[firstName]' => "njaka",
            'register_user[email]' => 'njaka@gmail.com',
            'register_user[plainPassword][first]' => '123456',
            'register_user[plainPassword][second]' => '123456',
        ]);

        $this->assertResponseRedirects('/');
        $client->followRedirect();
        
    }
}
