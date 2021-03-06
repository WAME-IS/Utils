<?php

namespace Wame\Utils;

use Nette\Application\AbortException;
use Nette\Application\UI\Form;
use Nette\Application\UI\Presenter;
use Tracy\Debugger;

class Exception
{
    /**
     * Method used to handle Exceptions. Parameter $showIn can be used to display
     * message in given object. Supported "show in" types are:
     * - \Nette\Application\UI\Form
     * - \Nette\Application\UI\Presenter
     *
     * @param \Exception|Exception $e
     * @param mixed $showIn
     * @throws AbortException
     */
    public static function handleException(\Exception $e, $showIn = null)
    {
        if ($e instanceof AbortException) {
            throw $e;
        }

        Debugger::log($e);

        if ($showIn instanceof Form) {
            $showIn->addError($e->getMessage());
            if (Debugger::isEnabled()) {
                $showIn->addError($e->getFile() . " at line " . $e->getLine());
            }
        }
        if ($showIn instanceof Presenter) {
            $showIn->flashMessage($e->getMessage(), "warning");
            if (Debugger::isEnabled()) {
                $showIn->flashMessage($e->getFile() . " at line " . $e->getLine(), "warning");
            }
        }
    }

}
