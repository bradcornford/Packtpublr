# An easy way to redeem free learning e-books from Packtpublr

[![Latest Stable Version](https://poser.pugx.org/cornford/Packtpublr/version.png)](https://packagist.org/packages/cornford/packtpublr)
[![Total Downloads](https://poser.pugx.org/cornford/packtpublr/d/total.png)](https://packagist.org/packages/cornford/packtpublr)
[![Build Status](https://travis-ci.org/bradcornford/Packtpublr.svg?branch=master)](https://travis-ci.org/bradcornford/Packtpublr)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/bradcornford/Packtpublr/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/bradcornford/Packtpublr/?branch=master)

Think of packtpublr as an easy way to redeem free learning e-books from Packtpublr, providing a variety of helpers to speed up the utilisation. These include:

- `$instance->login`
- `$instance->redeem`
- `$instance->logout`
- `$instance->run`
- `$instance->getHttpClient`
- `$instance->setHttpClient`
- `$instance->getCookieSubscriber`
- `$instance->setCookieSubscriber`
- `$instance->getResponseBody`
- `$instance->getResponseCode`
- `$instance->getResponseHeaders`

## Installation

Begin by installing this package through Composer. Edit your project's `composer.json` file to require `cornford/packtpublr`.

	"require": {
		"cornford/packtpublr": "2.*"
	}

Finally, update Composer from the Terminal:

	composer update

That's it! You're all set to go.

## Configuration

You can now configure Packtpublr in a few simple steps. Open `src/config/config.example.php` and save it as `src/config/config.php` and update the options as needed.

- `email` - Packtpub email address.
- `password` - Packtpub password.

## Usage

It's really as simple as using the Packtpublr class in any Controller / Model / File you see fit with:

`$instance = new Packtpublr(['email' => 'email@address.com', 'password' => 'Password'])`

This will give you access to

- [Login](#login)
- [Redeem](#redeem)
- [Logout](#logout)
- [Run](#run)

### Login

The `login` method will login to Packtpublr, with optional parameters for email address and password.

	$instance->login();
	$instance->login('email@address.com', 'Password');

### Redeem

The `redeem` method will redeem the current free learning item on Packtpublr.

	$instance->redeem();

### Logout

The `logout` method will logout of Packtpublr.

	$instance->logout();

### Run

The `run` method will run a request cycle of login, reddem and logout, with optional parameters for running in console, email address and password.

	$instance->logout();
	$instance->logout(false, 'email@address.com', 'Password');

### License

Packtpublr is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)