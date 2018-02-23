<?php

namespace App\Traits;

trait ApiORMHelpers
{
    public function sortData(\Illuminate\Http\Request $request)
    {
        if ($request->has('sort')) {
            $sorts = explode(',', $request->get('sort', ''));

            foreach ($sorts as $sortCol) {
                $sortDir = starts_with($sortCol, '-') ? 'desc' : 'asc';
                $sortCol = ltrim($sortCol, '-');

                $this->query->orderBy($sortCol, $sortDir);
            }
        }
    }

    public function filterData(\Illuminate\Http\Request $request)
    {
        if ($request->has('filter')) {
            $filters = explode(',', $request->get('filter'));

            foreach ($filters as $filter) {
                list($criteria, $value) = explode(':', $filter);
                $this->query->where($criteria, $value);
            }
        }
    }
}
