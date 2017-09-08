<?php

namespace App\Entity;

use Zend\Hydrator\ObjectProperty as Hydrator;
use Zend\Hydrator\NamingStrategy\UnderscoreNamingStrategy;

/**
 * Class BaseEntity
 */
class BaseEntity
{
    /**
     * BaseEntity constructor.
     *
     * @param array $row .
     */
    public function __construct(array $row = null)
    {
        if ($row) {
            $this->getHydrator()->hydrate((array)$row, $this);
        }
    }

    /**
     * Get Hydrator.
     *
     * @return Hydrator Hydrator
     */
    protected function getHydrator()
    {
        $container = container();
        $hydrator = $container->get('hydrator');
        if (!$hydrator) {
            $hydrator = new Hydrator();
            $hydrator->setNamingStrategy(new UnderscoreNamingStrategy());
            $container->set('hydrator', $hydrator);
        }

        return $hydrator;
    }

    /**
     * Extract objects to arrays.
     *
     * @return array
     */
    public function toArray()
    {
        return $this->getHydrator()->extract($this);
    }

    /**
     * To json
     *
     * @return string Json
     */
    public function toJson()
    {
        return json_encode($this->toArray());
    }
}
