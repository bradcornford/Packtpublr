<?php namespace Cornford\Packtpublr\Contracts;

use Cornford\Packtpublr\Exceptions\PacktpublrRedeemException;
use Cornford\Packtpublr\Exceptions\PacktpublrRequestException;

interface RedeemableInterface
{

    /**
     * Login.
     *
     * @param string $email
     * @param string $password
     *
     * @throws PacktpublrRequestException
     *
     * @return boolean
     */
    public function login($email = null, $password = null);

    /**
     * Redeem.
     *
     * @throws PacktpublrRequestException
     * @throws PacktpublrRedeemException
     *
     * @return boolean
     */
    public function redeem();

    /**
     * Logout.
     *
     * @throws PacktpublrRequestException
     *
     * @return boolean
     */
    public function logout();

    /**
     * Run.
     *
     * @param string  $email
     * @param string  $password
     *
     * @return boolean
     */
    public function run($email = null, $password = null);

}