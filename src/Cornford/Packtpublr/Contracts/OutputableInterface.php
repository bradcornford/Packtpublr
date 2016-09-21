<?php namespace Cornford\Packtpublr\Contracts;

use Symfony\Component\Console\Output\ConsoleOutput;

interface OutputableInterface
{

    /**
     * Get console output.
     *
     * @return ConsoleOutput
     */
    public function getConsoleOutput();

    /**
     * Set console output.
     *
     * @param ConsoleOutput $consoleOutput
     *
     * @return void
     */
    public function setConsoleOutput(ConsoleOutput $consoleOutput);

    /**
     * Write a string as standard output.
     *
     * @param string $string
     *
     * @return void
     */
    public function line($string);

    /**
     * Write a string as information output.
     *
     * @param string $string
     *
     * @return void
     */
    public function info($string);

    /**
     * Write a string as success output.
     *
     * @param string $string
     *
     * @return void
     */
    public function success($string);

    /**
     * Write a string as warning output.
     *
     * @param string $string
     *
     * @return void
     */
    public function warning($string);

    /**
     * Write a string as error output.
     *
     * @param string $string
     *
     * @return void
     */
    public function error($string);

}