<?php

namespace Wame\Utils;

use Doctrine\ORM\Query\Expr\Comparison;

class Doctrine
{
    /**
     * Remove where part
     * 
     * @param QueryBuilder $qb  query builder
     * @param string $part      where part
     * @param string $para      parameter
     * @return QueryBuilder
     */
    public static function removeWherePart($qb, $part, $para = null)
    {
        $qbWherePart = $qb->getDqlPart('where')->getParts();
        $qb->resetDQLPart('where');
        
        foreach ($qbWherePart as $whereClause) {
            if ($whereClause === $part || ($whereClause instanceof Comparison && $whereClause->getLeftExpr() === $part)) {
                continue;
            }
            $qb->andWhere($whereClause);
        }
        
        $params = $qb->getParameters();
        
        foreach ($params as $key => $param) {
            if ($param->getName() === $para) {
                $params->remove($key);
            }
        }
        
        $qb->setParameters($params);
        
        return $qb;
    }
    
}
