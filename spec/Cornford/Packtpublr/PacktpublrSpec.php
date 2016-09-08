<?php namespace spec\Cornford\Packtpublr;

use PhpSpec\ObjectBehavior;
use Mockery;

class PacktpublrSpec extends ObjectBehavior
{

    const EMAIL = 'email@address.com';
    const PASSWORD = 'Password123';
    
    const HTTP_RESPONSE_SUCCESS = 200;
    const HTTP_RESPONSE_ERROR = 500;

    const BODY_STRING = '<a href="/freelearning-claim/123/456" class="twelve-days-claim">';

    public function let()
    {
        $this->beConstructedWith(['email' => self::EMAIL, 'password' => self::PASSWORD]);
    }

    function it_is_initializable()
    {
        $this->beConstructedWith(['email' => self::EMAIL, 'password' => self::PASSWORD]);

        $this->shouldHaveType('Cornford\Packtpublr\Packtpublr');
    }

    function it_throws_an_exception_when_constructed_with_no_arguments()
    {
        $this->shouldThrow('Cornford\Packtpublr\Exceptions\PacktpublrArgumentException')
            ->during('__construct', [[]]);
    }

    function it_throws_an_exception_when_constructed_with_no_email_argument()
    {
        $this->shouldThrow('Cornford\Packtpublr\Exceptions\PacktpublrArgumentException')
            ->during('__construct', [[]]);
    }

    function it_throws_an_exception_when_constructed_with_an_invalid_email_argument()
    {
        $this->shouldThrow('Cornford\Packtpublr\Exceptions\PacktpublrArgumentException')
            ->during('__construct', [['email' => false]]);
    }

    function it_throws_an_exception_when_constructed_with_no_password_argument()
    {
        $this->shouldThrow('Cornford\Packtpublr\Exceptions\PacktpublrArgumentException')
            ->during('__construct', [['email' => self::EMAIL]]);
    }

    function it_throws_an_exception_when_constructed_with_an_invalid_password_argument()
    {
        $this->shouldThrow('Cornford\Packtpublr\Exceptions\PacktpublrArgumentException')
            ->during('__construct', [['email' => self::EMAIL, 'password' => false]]);
    }

    function it_returns_true_when_a_successful_login_request_is_made()
    {
        $client = Mockery::mock('GuzzleHttp\Client');

        $body = Mockery::mock('stdClass');
        $body->shouldReceive('__toString')->andReturn('');

        $response = Mockery::mock('GuzzleHttp\Message\Response');
        $response->shouldReceive('getStatusCode')->andReturn(self::HTTP_RESPONSE_SUCCESS);
        $response->shouldReceive('getHeaders')->andReturn([]);
        $response->shouldReceive('getBody')->andReturn($body);

        $client->shouldReceive('post')->andReturn($response);

        $this->setHttpClient($client);

        $this->login()->shouldReturn(true);
    }

    function it_returns_false_when_a_successful_login_request_is_made_with_optional_arguments()
    {
        $client = Mockery::mock('GuzzleHttp\Client');

        $body = Mockery::mock('stdClass');
        $body->shouldReceive('__toString')->andReturn('');

        $response = Mockery::mock('GuzzleHttp\Message\Response');
        $response->shouldReceive('getStatusCode')->andReturn(self::HTTP_RESPONSE_SUCCESS);
        $response->shouldReceive('getHeaders')->andReturn([]);
        $response->shouldReceive('getBody')->andReturn($body);

        $client->shouldReceive('post')->andReturn($response);

        $this->setHttpClient($client);

        $this->login('email@address.com', 'Password123')->shouldReturn(true);
    }

    function it_returns_false_when_a_unsuccessful_login_request_is_made()
    {
        $client = Mockery::mock('GuzzleHttp\Client');

        $body = Mockery::mock('stdClass');
        $body->shouldReceive('__toString')->andReturn('');

        $response = Mockery::mock('GuzzleHttp\Message\Response');
        $response->shouldReceive('getStatusCode')->andReturn(self::HTTP_RESPONSE_ERROR);
        $response->shouldReceive('getHeaders')->andReturn([]);
        $response->shouldReceive('getBody')->andReturn($body);

        $client->shouldReceive('post')->andReturn($response);

        $this->setHttpClient($client);

        $this->login()->shouldReturn(false);
    }

    function it_returns_false_when_a_unsuccessful_login_request_is_made_with_optional_arguments()
    {
        $client = Mockery::mock('GuzzleHttp\Client');

        $body = Mockery::mock('stdClass');
        $body->shouldReceive('__toString')->andReturn('');

        $response = Mockery::mock('GuzzleHttp\Message\Response');
        $response->shouldReceive('getStatusCode')->andReturn(self::HTTP_RESPONSE_ERROR);
        $response->shouldReceive('getHeaders')->andReturn([]);
        $response->shouldReceive('getBody')->andReturn($body);

        $client->shouldReceive('post')->andReturn($response);

        $this->setHttpClient($client);

        $this->login('email@address.com', 'Password123')->shouldReturn(false);
    }

    function it_returns_true_when_a_successful_redeem_request_is_made()
    {
        $client = Mockery::mock('GuzzleHttp\Client');

        $body = Mockery::mock('stdClass');
        $body->shouldReceive('__toString')->andReturn(self::BODY_STRING);

        $response = Mockery::mock('GuzzleHttp\Message\Response');
        $response->shouldReceive('getStatusCode')->andReturn(self::HTTP_RESPONSE_SUCCESS);
        $response->shouldReceive('getHeaders')->andReturn([]);
        $response->shouldReceive('getBody')->andReturn($body);

        $client->shouldReceive('post')->andReturn($response);
        $client->shouldReceive('get')->andReturn($response);

        $this->setHttpClient($client);

        $this->redeem()->shouldReturn(true);
    }

    function it_returns_false_when_a_unsuccessful_redeem_request_is_made()
    {
        $client = Mockery::mock('GuzzleHttp\Client');

        $body = Mockery::mock('stdClass');
        $body->shouldReceive('__toString')->andReturn(self::BODY_STRING);

        $response = Mockery::mock('GuzzleHttp\Message\Response');
        $response->shouldReceive('getStatusCode')->andReturn(self::HTTP_RESPONSE_SUCCESS);
        $response->shouldReceive('getHeaders')->andReturn([]);
        $response->shouldReceive('getBody')->andReturn($body);

        $client->shouldReceive('get')->andReturn($response);

        $body = Mockery::mock('stdClass');
        $body->shouldReceive('__toString')->andReturn('');

        $response = Mockery::mock('GuzzleHttp\Message\Response');
        $response->shouldReceive('getStatusCode')->andReturn(self::HTTP_RESPONSE_ERROR);
        $response->shouldReceive('getHeaders')->andReturn([]);
        $response->shouldReceive('getBody')->andReturn($body);

        $client->shouldReceive('post')->andReturn($response);

        $this->setHttpClient($client);

        $this->redeem()->shouldReturn(false);
    }

    function it_returns_true_when_a_successful_logout_request_is_made()
    {
        $client = Mockery::mock('GuzzleHttp\Client');

        $body = Mockery::mock('stdClass');
        $body->shouldReceive('__toString')->andReturn('');

        $response = Mockery::mock('GuzzleHttp\Message\Response');
        $response->shouldReceive('getStatusCode')->andReturn(self::HTTP_RESPONSE_SUCCESS);
        $response->shouldReceive('getHeaders')->andReturn([]);
        $response->shouldReceive('getBody')->andReturn($body);

        $client->shouldReceive('get')->andReturn($response);

        $this->setHttpClient($client);

        $this->logout()->shouldReturn(true);
    }

    function it_returns_false_when_a_unsuccessful_logout_request_is_made()
    {
        $client = Mockery::mock('GuzzleHttp\Client');

        $body = Mockery::mock('stdClass');
        $body->shouldReceive('__toString')->andReturn('');

        $response = Mockery::mock('GuzzleHttp\Message\Response');
        $response->shouldReceive('getStatusCode')->andReturn(self::HTTP_RESPONSE_ERROR);
        $response->shouldReceive('getHeaders')->andReturn([]);
        $response->shouldReceive('getBody')->andReturn($body);

        $client->shouldReceive('get')->andReturn($response);
        $client->shouldReceive('post')->andReturn($response);

        $this->setHttpClient($client);

        $this->logout()->shouldReturn(false);
    }

    function it_returns_true_when_a_successful_when_a_run_request_is_made()
    {
        $client = Mockery::mock('GuzzleHttp\Client');

        $body = Mockery::mock('stdClass');
        $body->shouldReceive('__toString')->andReturn(self::BODY_STRING);

        $response = Mockery::mock('GuzzleHttp\Message\Response');
        $response->shouldReceive('getStatusCode')->andReturn(self::HTTP_RESPONSE_SUCCESS);
        $response->shouldReceive('getHeaders')->andReturn([]);
        $response->shouldReceive('getBody')->andReturn($body);

        $client->shouldReceive('get')->andReturn($response);

        $client->shouldReceive('post')->andReturn($response);

        $this->setHttpClient($client);

        $this->run(false)->shouldReturn(true);
    }

    function it_returns_true_when_a_successful_when_a_run_request_is_made_with_optional_arguments()
    {
        $client = Mockery::mock('GuzzleHttp\Client');

        $body = Mockery::mock('stdClass');
        $body->shouldReceive('__toString')->andReturn(self::BODY_STRING);

        $response = Mockery::mock('GuzzleHttp\Message\Response');
        $response->shouldReceive('getStatusCode')->andReturn(self::HTTP_RESPONSE_SUCCESS);
        $response->shouldReceive('getHeaders')->andReturn([]);
        $response->shouldReceive('getBody')->andReturn($body);

        $client->shouldReceive('get')->andReturn($response);

        $client->shouldReceive('post')->andReturn($response);

        $this->setHttpClient($client);

        $this->run(false, 'email@address.com', 'Password123')->shouldReturn(true);
    }

    function it_returns_false_when_a_unsuccessful_when_a_run_request_is_made()
    {
        $client = Mockery::mock('GuzzleHttp\Client');

        $body = Mockery::mock('stdClass');
        $body->shouldReceive('__toString')->andReturn(self::BODY_STRING);

        $response = Mockery::mock('GuzzleHttp\Message\Response');
        $response->shouldReceive('getStatusCode')->andReturn(self::HTTP_RESPONSE_ERROR);
        $response->shouldReceive('getHeaders')->andReturn([]);
        $response->shouldReceive('getBody')->andReturn($body);

        $client->shouldReceive('get')->andReturn($response);

        $client->shouldReceive('post')->andReturn($response);

        $this->setHttpClient($client);

        $this->run(false)->shouldReturn(false);
    }

    function it_returns_false_when_a_unsuccessful_when_a_run_request_is_made_with_optional_arguments()
    {
        $client = Mockery::mock('GuzzleHttp\Client');

        $body = Mockery::mock('stdClass');
        $body->shouldReceive('__toString')->andReturn(self::BODY_STRING);

        $response = Mockery::mock('GuzzleHttp\Message\Response');
        $response->shouldReceive('getStatusCode')->andReturn(self::HTTP_RESPONSE_ERROR);
        $response->shouldReceive('getHeaders')->andReturn([]);
        $response->shouldReceive('getBody')->andReturn($body);

        $client->shouldReceive('get')->andReturn($response);

        $client->shouldReceive('post')->andReturn($response);

        $this->setHttpClient($client);

        $this->run(false, 'email@address.com', 'Password123')->shouldReturn(false);
    }

    function it_should_set_and_get_a_http_client()
    {
        $client = Mockery::mock('GuzzleHttp\Client');

        $this->setHttpClient($client)->shouldReturn(null);
        $this->getHttpClient()->shouldReturn($client);
    }

    function it_should_set_and_get_a_cookie_subscriber()
    {
        $cookie = Mockery::mock('GuzzleHttp\Subscriber\Cookie');

        $cookie->shouldReceive('getEvents')->andReturnSelf();

        $this->setCookieSubscriber($cookie)->shouldReturn(null);
        $this->getCookieSubscriber()->shouldReturn($cookie);
    }

    function it_should_be_able_to_get_a_http_response_body_after_a_request()
    {
        $client = Mockery::mock('GuzzleHttp\Client');

        $body = Mockery::mock('stdClass');
        $body->shouldReceive('__toString')->andReturn(self::BODY_STRING);

        $response = Mockery::mock('GuzzleHttp\Message\Response');
        $response->shouldReceive('getStatusCode')->andReturn(self::HTTP_RESPONSE_SUCCESS);
        $response->shouldReceive('getHeaders')->andReturn([]);
        $response->shouldReceive('getBody')->andReturn($body);

        $client->shouldReceive('post')->andReturn($response);
        $client->shouldReceive('get')->andReturn($response);

        $this->setHttpClient($client);

        $this->redeem()->shouldReturn(true);
        $this->getResponseBody()->shouldReturn(self::BODY_STRING);
    }

    function it_should_be_able_to_get_a_http_response_code_after_a_request()
    {
        $client = Mockery::mock('GuzzleHttp\Client');

        $body = Mockery::mock('stdClass');
        $body->shouldReceive('__toString')->andReturn(self::BODY_STRING);

        $response = Mockery::mock('GuzzleHttp\Message\Response');
        $response->shouldReceive('getStatusCode')->andReturn(self::HTTP_RESPONSE_SUCCESS);
        $response->shouldReceive('getHeaders')->andReturn([]);
        $response->shouldReceive('getBody')->andReturn($body);

        $client->shouldReceive('post')->andReturn($response);
        $client->shouldReceive('get')->andReturn($response);

        $this->setHttpClient($client);

        $this->redeem()->shouldReturn(true);
        $this->getResponseCode()->shouldReturn(self::HTTP_RESPONSE_SUCCESS);
    }

    function it_should_be_able_to_get_a_http_response_headers_after_a_request()
    {
        $client = Mockery::mock('GuzzleHttp\Client');

        $body = Mockery::mock('stdClass');
        $body->shouldReceive('__toString')->andReturn(self::BODY_STRING);

        $response = Mockery::mock('GuzzleHttp\Message\Response');
        $response->shouldReceive('getStatusCode')->andReturn(self::HTTP_RESPONSE_SUCCESS);
        $response->shouldReceive('getHeaders')->andReturn(['Content-Type: text/html']);
        $response->shouldReceive('getBody')->andReturn($body);

        $client->shouldReceive('post')->andReturn($response);
        $client->shouldReceive('get')->andReturn($response);

        $this->setHttpClient($client);

        $this->redeem()->shouldReturn(true);
        $this->getResponseHeaders()->shouldReturn(['Content-Type: text/html']);
    }

}