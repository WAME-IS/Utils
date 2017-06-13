<?php

namespace Wame\Utils;

use Nette\Application\UI\Control;

/**
 * Assertion utilities
 *
 * @package Wame\Utils
 */
class Assert
{
    /** @var bool */
    private static $valid;

    /** @var Control */
    private $object;


    /** asserts ***************************************************************/

    /**
     * Equal
     *
     * @param $value
     * @param $expected
     * @return Assert
     */
    public static function eq($value, $expected)
    {
        self::$valid = $value === $expected;

        return new self;
    }

    /**
     * Not
     *
     * @param $value
     * @param $expected
     * @return Assert
     */
    public static function not($value, $expected)
    {
        self::$valid = $value !== $expected;

        return new self;
    }

    /**
     * True
     *
     * @param $value
     * @return Assert
     */
    public static function true($value)
    {
        self::$valid = $value === true;

        return new self;
    }


    /** actions ***************************************************************/

    /**
     * On
     *
     * @param Control $object
     * @return $this
     */
    public function on(Control $object)
    {
        $this->object = $object;

        return $this;
    }

    /**
     * Message
     *
     * @param string $message
     * @param string $type
     * @return $this
     */
    public function message(string $message, string $type = 'info')
    {
        $this->object->flashMessage($message, $type);

        return $this;
    }

    public function successMessage(string $message, string $type = 'success')
    {
        if(self::$valid) {
            $this->message($message, $type);
        }

        return $this;
    }

    public function failMessage(string $message, string $type = 'danger')
    {
        if(!self::$valid) {
            $this->message($message, $type);
        }

        return $this;
    }

    public function redirect(/*$code, $destination = null, $args = []*/)
    {
        $this->object->redirect(':Homepage:Homepage:', ['id' => null]); // TODO: redirect to parent route instead

        return $this;
    }

    public function successRedirect(/*$code, $destination = null, $args = []*/)
    {
        if(self::$valid) {
            $this->redirect();
        }

        return $this;
    }

    public function failRedirect(/*$code, $destination = null, $args = []*/)
    {
        if(!self::$valid) {
            $this->redirect();
        }

        return $this;
    }

}