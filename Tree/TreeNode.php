<?php

namespace Wame\Utils\Tree;

use Nette\MemberAccessException,
    Nette\Utils\ObjectMixin;

/**
 * Class representing one node of tree, property "childNodes" is mapped to array of child nodes. All other properties are mapped to current item properties.
 * 
 * @author Dominik Gmiterko <ienze@ienze.me>
 */
class TreeNode
{

    const CHILDS_NAME = 'childNodes';

    private $item;
    private $childs;

    public function __construct($item, $childs = null)
    {
        $this->item = $item;
        $this->childs = $childs ? $childs : [];
    }

    public function __call($name, $args)
    {
        if ($name == 'get' . ucfirst(self::CHILDS_NAME)) {
            return $this->childs;
        }
        return call_user_func([$this->item, $name], $args);
    }

    public function __get($name)
    {
        if ($name == self::CHILDS_NAME) {
            return $this->childs;
        }
        return $this->item->$name;
    }

    public function __set($name, $value)
    {
        $this->item->$name = $value;
    }

    /**
     * Is property defined?
     * @param  string  property name
     * @return bool
     */
    public function __isset($name)
    {
        return ObjectMixin::has($this->item, $name);
    }

    /**
     * Access to undeclared property.
     * @param  string  property name
     * @return void
     * @throws MemberAccessException
     */
    public function __unset($name)
    {
        ObjectMixin::remove($this->item, $name);
    }

    public function __toString()
    {
        if (is_scalar($this->item)) {
            return $this->item;
        } else {
            return (string) $this->item;
        }
    }
}
