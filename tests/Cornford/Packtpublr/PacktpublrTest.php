<?php namespace tests\Cornford\Packtpublr;

use Cornford\Packtpublr\Packtpublr;
use Mockery;
use PHPUnit_Framework_TestCase as TestCase;

class PacktpublrTest extends TestCase
{

    const EMAIL = 'email@address.com';
    const PASSWORD = 'Password123';

    const HTTP_RESPONSE_SUCCESS = 200;
    const HTTP_RESPONSE_ERROR = 500;

    const BODY_STRING = '<a href="/freelearning-claim/123/456" class="twelve-days-claim">';

    public function testConstruct()
    {
        $instance = new Packtpublr(['email' => self::EMAIL, 'password' => self::PASSWORD]);

        $this->assertEquals($instance, new Packtpublr(['email' => 'email@address.com', 'password' => 'Password123']));
    }

    /**
     * @expectedException Cornford\Packtpublr\Exceptions\PacktpublrArgumentException
     */
    public function testConstructWithNoArguments()
    {
        $instance = new Packtpublr([]);
    }

    /**
     * @expectedException Cornford\Packtpublr\Exceptions\PacktpublrArgumentException
     */
    public function testConstructWithNoEmailArgument()
    {
        $instance = new Packtpublr([]);
    }

    /**
     * @expectedException Cornford\Packtpublr\Exceptions\PacktpublrArgumentException
     */
    public function testConstructWithInvalidEmailArgument()
    {
        $instance = new Packtpublr(['email' => false, 'password' => self::PASSWORD]);
    }

    /**
     * @expectedException Cornford\Packtpublr\Exceptions\PacktpublrArgumentException
     */
    public function testConstructWithNoPasswordArgument()
    {
        $instance = new Packtpublr(['email' => self::EMAIL, 'password' => false]);
    }

    /**
     * @expectedException Cornford\Packtpublr\Exceptions\PacktpublrArgumentException
     */
    public function testConstructWithInvalidPasswordArgument()
    {
        $instance = new Packtpublr(['email' => self::EMAIL]);
    }

    public function testLogin()
    {
        $instance = new Packtpublr(['email' => 'email@address.com', 'password' => 'Password123']);

        $client = Mockery::mock('GuzzleHttp\Client');

        $body = Mockery::mock('stdClass');
        $body->shouldReceive('__toString')->andReturn('');

        $response = Mockery::mock('GuzzleHttp\Message\Response');
        $response->shouldReceive('getStatusCode')->andReturn(self::HTTP_RESPONSE_SUCCESS);
        $response->shouldReceive('getHeaders')->andReturn($body);
        $response->shouldReceive('getBody')->andReturnSelf();

        $client->shouldReceive('post')->andReturn($response);

        $instance->setHttpClient($client);

        $this->assertTrue($instance->login());
    }

    public function testLoginWithOptionalArguments()
    {
        $instance = new Packtpublr(['email' => 'email@address.com', 'password' => 'Password123']);

        $client = Mockery::mock('GuzzleHttp\Client');

        $body = Mockery::mock('stdClass');
        $body->shouldReceive('__toString')->andReturn('');

        $response = Mockery::mock('GuzzleHttp\Message\Response');
        $response->shouldReceive('getStatusCode')->andReturn(self::HTTP_RESPONSE_SUCCESS);
        $response->shouldReceive('getHeaders')->andReturn($body);
        $response->shouldReceive('getBody')->andReturnSelf();

        $client->shouldReceive('post')->andReturn($response);

        $instance->setHttpClient($client);

        $this->assertTrue($instance->login('email@address.com', 'Password123'));
    }

    public function testRedeem()
    {
        $instance = new Packtpublr(['email' => 'email@address.com', 'password' => 'Password123']);

        $client = Mockery::mock('GuzzleHttp\Client');

        $body = Mockery::mock('stdClass');
        $body->shouldReceive('__toString')->andReturn(self::BODY_STRING);

        $response = Mockery::mock('GuzzleHttp\Message\Response');
        $response->shouldReceive('getStatusCode')->andReturn(self::HTTP_RESPONSE_SUCCESS);
        $response->shouldReceive('getHeaders')->andReturn([]);
        $response->shouldReceive('getBody')->andReturn($body);

        $client->shouldReceive('post')->andReturn($response);
        $client->shouldReceive('get')->andReturn($response);

        $instance->setHttpClient($client);

        $this->assertTrue($instance->redeem());
    }

    /**
     * @expectedException Cornford\Packtpublr\Exceptions\PacktpublrRedeemException
     */
    public function testRedeemError()
    {
        $instance = new Packtpublr(['email' => 'email@address.com', 'password' => 'Password123']);

        $client = Mockery::mock('GuzzleHttp\Client');

        $body = Mockery::mock('stdClass');
        $body->shouldReceive('__toString')->andReturn('');

        $response = Mockery::mock('GuzzleHttp\Message\Response');
        $response->shouldReceive('getStatusCode')->andReturn(self::HTTP_RESPONSE_SUCCESS);
        $response->shouldReceive('getHeaders')->andReturn([]);
        $response->shouldReceive('getBody')->andReturn($body);

        $client->shouldReceive('post')->andReturn($response);
        $client->shouldReceive('get')->andReturn($response);

        $instance->setHttpClient($client);

        $this->assertTrue($instance->redeem());
    }

    public function testLogout()
    {
        $instance = new Packtpublr(['email' => 'email@address.com', 'password' => 'Password123']);

        $client = Mockery::mock('GuzzleHttp\Client');

        $body = Mockery::mock('stdClass');
        $body->shouldReceive('__toString')->andReturn('');

        $response = Mockery::mock('GuzzleHttp\Message\Response');
        $response->shouldReceive('getStatusCode')->andReturn(self::HTTP_RESPONSE_SUCCESS);
        $response->shouldReceive('getHeaders')->andReturn([]);
        $response->shouldReceive('getBody')->andReturn($body);

        $client->shouldReceive('get')->andReturn($response);

        $instance->setHttpClient($client);

        $this->assertTrue($instance->logout());
    }

    public function testRun()
    {
        $instance = new Packtpublr(['email' => 'email@address.com', 'password' => 'Password123']);

        $client = Mockery::mock('GuzzleHttp\Client');

        $body = Mockery::mock('stdClass');
        $body->shouldReceive('__toString')->andReturn(self::BODY_STRING);

        $response = Mockery::mock('GuzzleHttp\Message\Response');
        $response->shouldReceive('getStatusCode')->andReturn(self::HTTP_RESPONSE_SUCCESS);
        $response->shouldReceive('getHeaders')->andReturn([]);
        $response->shouldReceive('getBody')->andReturn($body);

        $client->shouldReceive('get')->andReturn($response);

        $client->shouldReceive('post')->andReturn($response);

        $instance->setHttpClient($client);

        $this->assertTrue($instance->run(false));
    }

    /**
     * @outputBuffering enabled
     */
    public function testRunWithConsoleArgument()
    {
        $instance = new Packtpublr(['email' => 'email@address.com', 'password' => 'Password123']);

        $client = Mockery::mock('GuzzleHttp\Client');

        $body = Mockery::mock('stdClass');
        $body->shouldReceive('__toString')->andReturn(self::BODY_STRING);

        $response = Mockery::mock('GuzzleHttp\Message\Response');
        $response->shouldReceive('getStatusCode')->andReturn(self::HTTP_RESPONSE_SUCCESS);
        $response->shouldReceive('getHeaders')->andReturn([]);
        $response->shouldReceive('getBody')->andReturn($body);

        $client->shouldReceive('get')->andReturn($response);

        $client->shouldReceive('post')->andReturn($response);

        $instance->setHttpClient($client);

        $this->assertTrue($instance->run(true));
    }

    public function testRunWithOptionalArguments()
    {
        $instance = new Packtpublr(['email' => 'email@address.com', 'password' => 'Password123']);

        $client = Mockery::mock('GuzzleHttp\Client');

        $body = Mockery::mock('stdClass');
        $body->shouldReceive('__toString')->andReturn(self::BODY_STRING);

        $response = Mockery::mock('GuzzleHttp\Message\Response');
        $response->shouldReceive('getStatusCode')->andReturn(self::HTTP_RESPONSE_SUCCESS);
        $response->shouldReceive('getHeaders')->andReturn([]);
        $response->shouldReceive('getBody')->andReturn($body);

        $client->shouldReceive('get')->andReturn($response);

        $client->shouldReceive('post')->andReturn($response);

        $instance->setHttpClient($client);

        $this->assertTrue($instance->run(false, 'email@address.com', 'Password123'));
    }

    public function testSetAndGetHttpClient()
    {
        $instance = new Packtpublr(['email' => 'email@address.com', 'password' => 'Password123']);

        $client = Mockery::mock('GuzzleHttp\Client');

        $instance->setHttpClient($client);

        $this->assertEquals($instance->getHttpClient(), $client);
    }

    public function testSetAndGetCookieSubscriber()
    {
        $instance = new Packtpublr(['email' => 'email@address.com', 'password' => 'Password123']);

        $cookie = Mockery::mock('GuzzleHttp\Subscriber\Cookie');

        $cookie->shouldReceive('getEvents')->andReturnSelf();

        $instance->setCookieSubscriber($cookie);

        $this->assertEquals($instance->getCookieSubscriber(), $cookie);
    }

    public function testGetResponseBody()
    {
        $instance = new Packtpublr(['email' => 'email@address.com', 'password' => 'Password123']);

        $client = Mockery::mock('GuzzleHttp\Client');

        $body = Mockery::mock('stdClass');
        $body->shouldReceive('__toString')->andReturn(self::BODY_STRING);

        $response = Mockery::mock('GuzzleHttp\Message\Response');
        $response->shouldReceive('getStatusCode')->andReturn(self::HTTP_RESPONSE_SUCCESS);
        $response->shouldReceive('getHeaders')->andReturn([]);
        $response->shouldReceive('getBody')->andReturn($body);

        $client->shouldReceive('post')->andReturn($response);
        $client->shouldReceive('get')->andReturn($response);

        $instance->setHttpClient($client);

        $instance->redeem();

        $this->assertEquals($instance->getResponseBody(), self::BODY_STRING);
    }

    public function testGetResponseCode()
    {
        $instance = new Packtpublr(['email' => 'email@address.com', 'password' => 'Password123']);

        $client = Mockery::mock('GuzzleHttp\Client');

        $body = Mockery::mock('stdClass');
        $body->shouldReceive('__toString')->andReturn(self::BODY_STRING);

        $response = Mockery::mock('GuzzleHttp\Message\Response');
        $response->shouldReceive('getStatusCode')->andReturn(self::HTTP_RESPONSE_SUCCESS);
        $response->shouldReceive('getHeaders')->andReturn([]);
        $response->shouldReceive('getBody')->andReturn($body);

        $client->shouldReceive('post')->andReturn($response);
        $client->shouldReceive('get')->andReturn($response);

        $instance->setHttpClient($client);

        $instance->redeem();

        $this->assertEquals($instance->getResponseCode(), self::HTTP_RESPONSE_SUCCESS);
    }

    public function testGetResponseHeaders()
    {
        $instance = new Packtpublr(['email' => 'email@address.com', 'password' => 'Password123']);

        $client = Mockery::mock('GuzzleHttp\Client');

        $body = Mockery::mock('stdClass');
        $body->shouldReceive('__toString')->andReturn(self::BODY_STRING);

        $response = Mockery::mock('GuzzleHttp\Message\Response');
        $response->shouldReceive('getStatusCode')->andReturn(self::HTTP_RESPONSE_SUCCESS);
        $response->shouldReceive('getHeaders')->andReturn(['Content-Type: text/html']);
        $response->shouldReceive('getBody')->andReturn($body);

        $client->shouldReceive('post')->andReturn($response);
        $client->shouldReceive('get')->andReturn($response);

        $instance->setHttpClient($client);

        $instance->redeem();

        $this->assertEquals($instance->getResponseHeaders(), ['Content-Type: text/html']);
    }
    
}