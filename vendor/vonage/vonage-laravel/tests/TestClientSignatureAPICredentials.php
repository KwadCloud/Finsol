<?php

namespace Vonage\Laravel\Tests;

use Vonage\Client;

class TestClientSignatureAPICredentials extends AbstractTestCase
{
    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application $app
     *
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('vonage.api_key', 'my_api_key');
        $app['config']->set('vonage.signature_secret', 'my_signature');
    }

    /**
     * Test that our Nexmo client is created with
     * the signature credentials
     *
     * @dataProvider classNameProvider
     * @return void
     */
    public function testClientCreatedWithSignatureAPICredentials($className): void
    {
        $client = app($className);

        $credentialsObject = $this->getClassProperty(Client::class, 'credentials', $client);
        $credentialsArray = $this->getClassProperty(Client\Credentials\SignatureSecret::class, 'credentials', $credentialsObject);

        $this->assertInstanceOf(Client\Credentials\SignatureSecret::class, $credentialsObject);
        $this->assertEquals(['api_key' => 'my_api_key', 'signature_secret' => 'my_signature', 'signature_method' => 'md5hash'], $credentialsArray);
    }
}
