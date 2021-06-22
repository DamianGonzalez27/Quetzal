<?php namespace App\Core\Bridges;

class FiltersBridge
{
    private $filters;

    public function __construct($filters)
    {
        $this->filters = $filters;
    }

    public function getFilters()
    {
        return $this->filters;
    }

    public function getFilter($filterName)
    {
        return $this->filters[$filterName];
    }
}