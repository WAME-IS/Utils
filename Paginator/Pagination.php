<?php

namespace Wame\Utils;

use Nette\Application\UI\Control;
use Nette\Utils\Paginator;

/**
 * Class Pagination
 * @package Wame\Utils
 * @deprecated
 */
class Pagination extends Control
{

    /** @var Paginator */
    private $paginator;

    /** @persistent */
    public $page = 1;

    private $count = 10;

    public function getPaginator()
    {
        if ( !$this->paginator )
        {
            $this->paginator = new Paginator;
        }
		
		$parameters = $this->presenter->getParameters();
		if(array_key_exists('page', $parameters)) $this->paginator->page = $parameters['page'];
		
        return $this->paginator;
    }

    /**
     * Set count
     * @param $count
     */
    public function setCount( $count )
    {
        $this->count = $count;
    }

    public function render()
    {
        $paginator = $this->getPaginator();
        $page = $paginator->page;
        if ( $paginator->pageCount < 2 )
        {
            $steps = array( $page );
        }
        else
        {
            $arr = range( max( $paginator->firstPage, $page - 3 ), min( $paginator->lastPage, $page + 3 ) );
            $quotient = ($paginator->pageCount - 1) / $this->count;
            for ( $i = 0; $i <= $this->count; $i++ )
            {
                $arr[] = round( $quotient * $i ) + $paginator->firstPage;
            }
            sort( $arr );
            $steps = array_values( array_unique( $arr ) );
        }

		$this->template->link = $this->presenter->link('this', ['page' => '3']);
		
        $this->template->steps = $steps;
        $this->template->paginator = $paginator;
        $this->template->setFile( __DIR__ . '/pagination.latte' );
    }

    public function loadState( array $params )
    {
        parent::loadState( $params );
        $this->getPaginator()->page = $this->page;
    }

}
