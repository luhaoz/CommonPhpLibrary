<?php
/**
 * Created by PhpStorm.
 * User: luhaoz
 * Date: 2017/8/23
 * Time: 15:25
 */

namespace luhaoz\cpl\error;

use luhaoz\cpl\pool\HashPool;
use Ramsey\Uuid\Uuid;

class ErrorManager implements \IteratorAggregate
{
    protected $_errorPool = null;

    public function errorPool()
    {
        if ($this->_errorPool === null) {
            $this->_errorPool = new HashPool();
        }
        return $this->_errorPool;
    }

    public function add($error)
    {
        if ($error instanceof static) {
            foreach ($error->errrosIterator() as $item) {
                $this->errorPool()->set(Uuid::uuid4()->toString(), $item);
            }
            return $this;
        }
        $this->errorPool()->set(Uuid::uuid4()->toString(), $error);

        return $this;
    }

    /**
     * @return Error[]
     */
    public function errrosIterator()
    {
        foreach ($this->errorPool()->all() as $item) {
            yield $item;
        }
    }

    public function getIterator()
    {
        return $this->errrosIterator();
    }
}