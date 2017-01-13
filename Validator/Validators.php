<?php

namespace Wame\Utils;

/**
 * Validation utilities
 *
 * @package Wame\Generator
 */
class Validators
{
    public static function validateModuleNamespace($namespace, $requireVendorNamespace = true)
    {

    }

    /**
     * Validate module name
     *
     * @param string $module    module
     * @return mixed
     */
    public static function validateModuleName($module)
    {
        if (!preg_match('/^[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*$/', $module)) {
            throw new \InvalidArgumentException(sprintf('The module name %s contains invalid characters.', $module));
        }
        if (!preg_match('/Module$/', $module)) {
            throw new \InvalidArgumentException('The module name must end with Module.');
        }
        return $module;
    }

    /**
     * Validate presenter name
     *
     * @param string $presenter     presenter
     * @return mixed
     */
    public static function validatePresenterName($presenter)
    {
        try {
            self::validateEntityName($presenter);
        } catch (\InvalidArgumentException $e) {
            throw new \InvalidArgumentException(
                sprintf(
                    'The presenter name must contain a : ("%s" given, expecting something like ArticleModule:Article)',
                    $presenter
                )
            );
        }
        return $presenter;
    }

    public static function validateFormat($format)
    {

    }

    /**
     * Validate entity name
     *
     * @param string $entity    entity
     * @return mixed
     */
    public static function validateEntityName($entity)
    {
        if (!preg_match('{^[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*:[a-zA-Z0-9_\x7f-\xff\\\/]+$}', $entity)) {
            throw new \InvalidArgumentException(sprintf('The entity name isn\'t valid ("%s" given, expecting something like AcmeBlogBundle:Blog/Post)', $entity));
        }
        return $entity;
    }

    /**
     * Get reserved words
     *
     * @return array
     */
    public static function getReservedWords()
    {
        return [
            'abstract',
            'and',
            'array',
            'as',
            'break',
            'callable',
            'case',
            'catch',
            'class',
            'clone',
            'const',
            'continue',
            'declare',
            'default',
            'do',
            'else',
            'elseif',
            'enddeclare',
            'endfor',
            'endforeach',
            'endif',
            'endswitch',
            'endwhile',
            'extends',
            'final',
            'finally',
            'for',
            'foreach',
            'function',
            'global',
            'goto',
            'if',
            'implements',
            'interface',
            'instanceof',
            'insteadof',
            'namespace',
            'new',
            'or',
            'private',
            'protected',
            'public',
            'static',
            'switch',
            'throw',
            'trait',
            'try',
            'use',
            'var',
            'while',
            'xor',
            'yield',
            '__CLASS__',
            '__DIR__',
            '__FILE__',
            '__LINE__',
            '__FUNCTION__',
            '__METHOD__',
            '__NAMESPACE__',
            '__TRAIT__',
            '__halt_compiler',
            'die',
            'echo',
            'empty',
            'exit',
            'eval',
            'include',
            'include_once',
            'isset',
            'list',
            'require',
            'require_once',
            'return',
            'print',
            'unset',
        ];
    }

}