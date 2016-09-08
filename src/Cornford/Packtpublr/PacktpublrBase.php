<?php namespace Cornford\Packtpublr;

use Cornford\Packtpublr\Contracts\RequestableInterface;
use Cornford\Packtpublr\Exceptions\PacktpublrArgumentException;
use Cornford\Packtpublr\Exceptions\PacktpublrRequestException;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use GuzzleHttp\Message\ResponseInterface;
use GuzzleHttp\Subscriber\Cookie;

abstract class PacktpublrBase implements RequestableInterface
{

    const REQUEST_TIMEOUT = 5;

    const REQUEST_METHOD_GET = 0;
    const REQUEST_METHOD_POST = 1;

    const REQUEST_CONTENT_PLAIN = 0;
    const REQUEST_CONTENT_XML = 1;
    const REQUEST_CONTENT_JSON = 2;

    const RESPONSE_CODE_OK = 200;

    /**
     * Guzzle Http client.
     *
     * @var Client
     */
    protected $httpClient;

    /**
     * Guzzle cookie subscriber.
     *
     * @var Cookie
     */
    protected $cookieSubscriber;

    /**
     * The request type.
     *
     * @var integer
     */
    protected $requestType = self::REQUEST_CONTENT_PLAIN;

    /**
     * The base URL.
     *
     * @var string
     */
    protected $baseUrl;

    /**
     * Response body.
     *
     * @var string|object
     */
    protected $responseBody;

    /**
     * Response code.
     *
     * @var integer
     */
    protected $responseCode;

    /**
     * Response headers.
     *
     * @var array
     */
    protected $responseHeaders;

    /**
     * Construct Packtpublr
     *
     * @param array $options
     *
     * @throws PacktpublrArgumentException
     */
    public function __construct(array $options = [])
    {
        if (empty($options)) {
            throw new PacktpublrArgumentException('Packtpublr requires both email and password as arguments.');
        }

        if (!isset($options['email']) || isset($options['email']) && !is_string($options['email'])) {
            throw new PacktpublrArgumentException('Packtpublr email address is required.');
        }

        if (!isset($options['password']) || isset($options['password']) && !is_string($options['password'])) {
            throw new PacktpublrArgumentException('Packtpublr password is required.');
        }

        $this->email = $options['email'];
        $this->password = $options['password'];

        $this->httpClient = new Client([
            'base_url' => $this->baseUrl,
            'defaults' => [
                'connect_timeout' => self::REQUEST_TIMEOUT,
                'timeout' => self::REQUEST_TIMEOUT
            ]
        ]);

        $this->cookieSubscriber = new Cookie(new CookieJar());
        $this->httpClient->getEmitter()->attach($this->cookieSubscriber);
    }

    /**
     * Create request.
     *
     * @param string  $url
     * @param array   $parameters
     * @param integer $requestMethod
     * @param integer $requestContent
     *
     * @throws PacktpublrRequestException
     *
     * @return boolean
     */
    protected function createRequest(
        $url,
        array $parameters = [],
        $requestMethod = self::REQUEST_METHOD_GET,
        $requestContent = self::REQUEST_CONTENT_PLAIN
    ) {
        try {
            if ($requestMethod === self::REQUEST_METHOD_GET) {
                $url = isset($parameters['url']) ? str_replace(array_keys($parameters['url']), $parameters['url'], $url) : $url;
                unset($parameters['url']);
            }

            return $this->sendRequest($url, $parameters, $requestMethod, $requestContent);
        } catch (Exception $exception) {
            throw new PacktpublrRequestException('An error occurred during the request.');
        }
    }

    /**
     * Send request.
     *
     * @param string  $url
     * @param array   $parameters
     * @param integer $requestMethod
     * @param integer $requestContent
     *
     * @return boolean
     */
    protected function sendRequest(
        $url,
        array $parameters = [],
        $requestMethod = self::REQUEST_METHOD_GET,
        $requestContent = self::REQUEST_CONTENT_PLAIN
    ) {
        $request = null;

        switch ($requestMethod) {
            case self::REQUEST_METHOD_POST:
                switch ($requestContent) {
                    case self::REQUEST_CONTENT_XML:
                        $request = $this->getHttpClient()
                            ->post($url, ['headers' => ['content-type' => 'application/xml'], 'body' => $parameters]);
                        break;
                    case self::REQUEST_CONTENT_JSON:
                        $request = $this->getHttpClient()
                            ->post($url, ['headers' => ['content-type' => 'application/json'], 'body' => $parameters]);
                        break;
                    case self::REQUEST_CONTENT_PLAIN:
                    default:
                    $request = $this->getHttpClient()
                        ->post($url, ['body' => $parameters]);
                }
                break;
            case self::REQUEST_METHOD_GET:
            default:
                $request = $this->getHttpClient()
                    ->get($url);
        }

        if ($request === null) {
            return false;
        }

        return $this->parseResponse($request, $requestContent);
    }

    /**
     * Parse response.
     *
     * @param ResponseInterface $response
     * @param integer           $requestContent
     *
     * @return boolean
     */
    protected function parseResponse(ResponseInterface $response, $requestContent = self::REQUEST_CONTENT_PLAIN)
    {
        $this->setResponseCode((integer) $response->getStatusCode());
        $this->setResponseHeaders((array) $response->getHeaders());

        switch ($requestContent) {
            case self::REQUEST_CONTENT_XML:
                $this->setResponseBody($response->xml());
                break;
            case self::REQUEST_CONTENT_JSON:
                $this->setResponseBody($response->json());
                break;
            case self::REQUEST_CONTENT_PLAIN:
            default:
                $this->setResponseBody($response->getBody()->__toString());
        }

        if ($this->getResponseCode() !== self::RESPONSE_CODE_OK) {
            return false;
        }

        return true;
    }

    /**
     * Get Http client.
     *
     * @return Client
     */
    public function getHttpClient()
    {
        return $this->httpClient;
    }

    /**
     * Set Http client.
     *
     * @param Client $client
     *
     * @return void
     */
    public function setHttpClient(Client $client)
    {
        $this->httpClient = $client;
    }

    /**
     * Get cookie subscriber
     *
     * @return Cookie
     */
    public function getCookieSubscriber()
    {
        return $this->cookieSubscriber;
    }

    /**
     * Set cookie subscriber.
     *
     * @param Cookie $cookieSubscriber
     *
     * @return void
     */
    public function setCookieSubscriber(Cookie $cookieSubscriber)
    {
        $this->getHttpClient()->getEmitter()->detach($this->cookieSubscriber);
        $this->cookieSubscriber = $cookieSubscriber;
        $this->getHttpClient()->getEmitter()->attach($this->cookieSubscriber);
    }

    /**
     * Get response body.
     *
     * @return string|object
     */
    public function getResponseBody()
    {
        return $this->responseBody;
    }

    /**
     * Set response code.
     *
     * @param string|object $body
     *
     * @return void
     */
    protected function setResponseBody($body)
    {
        $this->responseBody = $body;
    }

    /**
     * Get response code.
     *
     * @return integer
     */
    public function getResponseCode()
    {
        return $this->responseCode;
    }

    /**
     * Set response code.
     *
     * @param integer $code
     *
     * @return void
     */
    protected function setResponseCode($code)
    {
        $this->responseCode = $code;
    }

    /**
     * Get response headers.
     *
     * @return array
     */
    public function getResponseHeaders()
    {
        return $this->responseHeaders;
    }

    /**
     * Set response headers.
     *
     * @param array $headers
     *
     * @return void
     */
    protected function setResponseHeaders($headers)
    {
        $this->responseHeaders = $headers;
    }

}