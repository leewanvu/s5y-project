<?php

namespace App\Services;

abstract class BaseService
{
    /**
     * @var array
     */
    protected $data;

    /**
     * Set request data
     *
     * @param mixed $data
     * @return self
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    public abstract function handle();
}
