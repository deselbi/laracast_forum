<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 29.5.17.
 * Time: 13.14
 */

namespace app\Filters;


use Illuminate\Http\Request;

abstract class Filters
{
    protected $request;
    protected $builder;

    /**
     * ThreadsFilters constructor.
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function apply($builder)
    {

        $this->builder = $builder;

        foreach ($this->getFilters() as $filter => $value) {
            $this->$filter($value);
        }

        return $this->builder;
    }

    /**
     * @return array
     */
    public function getFilters(): array
    {
        return $this->request->intersect($this->filters);
    }
}