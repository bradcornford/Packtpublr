<?php namespace Cornford\Packtpublr\Contracts;

use GuzzleHttp\Client;
use GuzzleHttp\Subscriber\Cookie;

interface RequestableInterface
{

    /**
     * Get Http client.
     *
     * @return Client
     */
    public function getHttpClient();

    /**
     * Set Http client.
     *
     * @param Client $client
     *
     * @return void
     */
    public function setHttpClient(Client $client);
    /**
     * Get cookie subscriber
     *
     * @return Cookie
     */
    public function getCookieSubscriber();

    /**
     * Set cookie subscriber.
     *
     * @param Cookie $cookieSubscriber
     *
     * @return void
     */
    public function setCookieSubscriber(Cookie $cookieSubscriber);

    /**
     * Get response body.
     *
     * @return string|object
     */
    public function getResponseBody();

    /**
     * Get response code.
     *
     * @return integer
     */
    public function getResponseCode();

    /**
     * Get response headers.
     *
     * @return array
     */
    public function getResponseHeaders();

}