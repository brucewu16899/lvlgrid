<?php

namespace Mrjj\LvlGrid;

use Request;

trait LvlGrid
{
    /**
     * Required infos
     */
    // protected $gridModel = '';
    // protected $threshold = 2;

    /**
     * Cached number of results per page.
     *
     * @var int|null
     */
    protected $perPage = null;

    /**
     * Cached number of pages.
     *
     * @var int
     */
    protected $pagesCount = 1;

    /**
     * Cached results.
     *
     * @var array
     */
    protected $results = [];

    public function grid(Request $request)
    {
        $data = $request::all();

        $data = $this->gridProcess($data);

        $this->gridTransformer($data);

        return $data;
    }

    /**
     * Transform your data
     */
    public function gridTransformer($data)
    {
        // do something
    }

    /**
     *
     * @return \Illuminate\Database\Query\Builder
     */
    public function gridData()
    {
        return \DB::table(with(new $this->gridModel)->getTable());
    }

    public function gridProcess($data)
    {
        $query = $this->gridData();

        if (! empty($data['sort']) && ! empty($data['direction'])) {
            $query->orderBy($data['sort'], $data['direction']);
        }

        if (! empty($data['search']) && ! empty($data['columnSearch'])) {
            $query->where($data['columnSearch'], 'like', '%'.$data['search'].'%' );
        }

        $resultsCount = $query->count();

        if ($resultsCount < $this->threshold) {
            return $this->gridParameters($query);
        }

        $this->gridCalculatePages();

        $query = $query
            ->take($this->threshold)
            ->skip($data['page'] * $this->threshold);

        return $this->gridParameters($query);
    }

    public function gridCalculatePages()
    {
        $this->pagesCount = (int) ceil($resultsCount / $this->threshold);
        $this->perPage = (int) ceil($resultsCount / $this->pagesCount);
    }

    public function gridParameters($query)
    {
        return [
            'items'      => $query->get(),
            'perPage'    => $this->perPage,
            'pagesCount' => $this->pagesCount,
        ];
    }

}