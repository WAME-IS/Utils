<?php

namespace Wame\Utils;


class Object
{
    /**
     * Get class namespace
     *
     * @param Object $object
     *
     * @return string
     */
    public static function getNamespace($object)
    {
        return get_class($object);
    }


    /**
     * Get class name
     *
     * @param string|Object $object namespace or class
     * @param boolean $capitalizeFirstCharacter
     *
     * @return string
     */
    public static function getName($object, $capitalizeFirstCharacter = true)
    {
        $className = (new \Nette\Reflection\ClassType($object))->getShortName();

        return $capitalizeFirstCharacter === true ? ucfirst($className) : lcfirst($className);
    }


    /**
     * Get class path
     *
     * @param string|Object $object namespace or class
     *
     * @return string
     */
    public static function getPath($object)
    {
        return dirname((new \ReflectionClass($object))->getFileName());
    }

}
