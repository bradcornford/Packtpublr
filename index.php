<?php

require_once __DIR__ . '/vendor/autoload.php';

use Cornford\Packtpublr\Packtpublr;

$config = include_once __DIR__ . '/src/config/config.php';

$packtpublr = new Packtpublr($config);

$packtpublr->run();