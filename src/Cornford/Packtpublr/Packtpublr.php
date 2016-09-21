<?php namespace Cornford\Packtpublr;

use Cornford\Packtpublr\Contracts\RedeemableInterface;
use Cornford\Packtpublr\Exceptions\PacktpublrRedeemException;
use Cornford\Packtpublr\Exceptions\PacktpublrRequestException;
use Symfony\Component\Console\Logger\ConsoleLogger;

class Packtpublr extends PacktpublrBase implements RedeemableInterface
{

    /**
     * The base URL.
     *
     * @var string
     */
    protected $baseUrl = 'https://www.packtpub.com';

    /**
     * The login URL.
     *
     * @var string
     */
    protected $loginUrl = '/';

    /**
     * The redeem URL.
     *
     * @var string
     */
    protected $redeemUrl = '/packt/offers/free-learning';

    /**
     * The logout URL.
     *
     * @var string
     */
    protected $logoutUrl = '/logout';

    /**
     * The login form fields.
     *
     * @var array
     */
    protected $loginFormFields = [
        'op' => 'Login',
        'form_build_id' => 'form-80807b1adfed1b70ff728d255a89cc65',
        'form_id' => 'packt_user_login_form',
    ];
    
    /**
     * The login email address.
     *
     * @var string
     */
    protected $email;

    /**
     * The login password.
     *
     * @var string
     */
    protected $password;

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
    public function login($email = null, $password = null)
    {
        $authenticationCredentials = [
            'email' => ($email ?: $this->email),
            'password' => ($password ?: $this->password)
        ];
        
        return $this->createRequest(
            $this->loginUrl,
            array_merge($authenticationCredentials, $this->loginFormFields),
            self::REQUEST_METHOD_POST
        );
    }

    /**
     * Redeem.
     *
     * @throws PacktpublrRequestException
     * @throws PacktpublrRedeemException
     *
     * @return boolean
     */
    public function redeem()
    {
        $this->createRequest(
            '/packt/offers/free-learning'
        );

        preg_match('/<a href="(\/freelearning-claim\/[0-9]+\/[0-9]+)" class="twelve-days-claim">/', $this->getResponseBody(), $matches);

        if (empty($matches)) {
            throw new PacktpublrRedeemException('An error locating an item to redeem.');
        }

        return $this->createRequest(
            $matches[1],
            [],
            self::REQUEST_METHOD_POST
        );
    }

    /**
     * Logout.
     *
     * @throws PacktpublrRequestException
     *
     * @return boolean
     */
    public function logout()
    {
        $result = $this->createRequest(
            '/logout'
        );

        $this->cookieSubscriber->getCookieJar()->clearSessionCookies();

        return $result;
    }

    /**
     * Run.
     *
     * @param string  $email
     * @param string  $password
     *
     * @return boolean
     */
    public function run($email = null, $password = null)
    {
        $result = false;

        $this->line('Attempting to redeem current free-learning item from PactPub');

        $this->line('Logging in using URL "<fg=cyan>' . $this->baseUrl . $this->loginUrl . '</>"...');

        if ($response = $this->login($email, $password)) {
            $this->success('  Success');
        } else {
            $this->error('  Error');
        }

        $result |= $response;

        $this->line('Redeeming current free-learning item using URL "<fg=cyan>' . $this->baseUrl . $this->redeemUrl . '</>"...');

        if ($response = $this->redeem()) {
            $this->success('  Success');
        } else {
            $this->error('  Error');
        }

        $result |= $response;

        $this->line('Logging out of using using URL "<fg=cyan>' . $this->baseUrl . $this->logoutUrl . '</>"...');

        if ($response = $this->logout()) {
            $this->success('  Success');
        } else {
            $this->error('  Error');
        }

        $result |= $response;

        return (boolean) $result;
    }

}