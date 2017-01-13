<?php

namespace Wame\Utils;

use Doctrine\ORM\Query\Expr\Comparison;
use Kdyby\Doctrine\QueryBuilder;

class Doctrine
{
    /**
     * Remove where part from QueryBuilder
     * 
     * @param QueryBuilder $qb query builder
     * @param string $part where part
     * @param array $para parameters
     * @return QueryBuilder
     */
    public static function removeWherePart($qb, $part, $para = [])
    {
        $qbWherePart = $qb->getDqlPart('where')->getParts();
        $qb->resetDQLPart('where');
        
        foreach ($qbWherePart as $whereClause) {
            if (strpos($whereClause, $part) !== false || ($whereClause instanceof Comparison && strpos($whereClause->getLeftExpr(), $part) !== false)) {
                continue;
            }
            $qb->andWhere($whereClause);
        }
        
        if(!empty($para)) {
            $params = $qb->getParameters();

            foreach ($params as $key => $param) {
                if (in_array($param->getName(), $para)) {
                    $params->remove($key);
                }
            }

            $qb->setParameters($params);
        }
        
        return $qb;
    }
    
}
