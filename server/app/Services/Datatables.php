<?php

namespace App\Services;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\FromQuery;

/**
 * Class Datatables.
 */
class Datatables
{
    /**
     * @var Request
     */
    private $request;

    /**
     * @var Builder
     */
    private $query;

    /**
     * @var array
     */
    private $columns = [];

    /**
     * @var array
     */
    private $headings = [];

    /**
     * @var string
     */
    private $name = 'data';

    /**
     * @var FromQuery
     */
    private $export;

    public function __construct()
    {
        $this->request = app('request');
    }

    /**
     * @param $column
     *
     * @return string
     */
    private function getLocalizedColumn($column)
    {
        /** @var \Illuminate\Database\Eloquent\Model|\Spatie\Translatable\HasTranslations $model */
        $model = $this->query->getModel();

        if (property_exists($model, 'translatable') && $model->isTranslatableAttribute($column)) {
            $locale = app()->getLocale();

            return "$column->\"$.$locale\"";
        }

        return $column;
    }

    public function make(Builder $query)
    {
        $this->query = $query;

        if ($column = $this->request->get('sortBy')) {
            $sortDesc = filter_var($this->request->get('sortDesc'), FILTER_VALIDATE_BOOLEAN);

            $this->query->orderByRaw(
                $this->getLocalizedColumn($column).' '.($sortDesc ? 'desc' : 'asc')
            );
        }

        return $this;
    }

    public function columns($columns)
    {
        $this->columns = $columns;

        return $this;
    }

    public function headings($headings)
    {
        $this->headings = $headings;

        return $this;
    }

    public function searchables($columns)
    {
        if ($search = $this->request->get('search')) {
            $search = Str::lower($search);

            $this->query->where(function (Builder $query) use ($columns, $search) {
                foreach ($columns as $column) {
                    $explode = explode('.', $column);

                    $relation = null;

                    if ($explode) {
                        $column = array_pop($explode);

                        if ($explode) {
                            $relation = implode('.', $explode);
                        }
                    }

                    if ($relation) {
                        $query->orWhereHas($relation, function (Builder $query) use ($column, $search) {
                            $query->whereRaw(
                                "LOWER({$this->getLocalizedColumn($column)}) like \"%{$search}%\""
                            );
                        });
                        continue;
                    }

                    $query->orWhereRaw(
                        "LOWER({$this->getLocalizedColumn($column)}) like \"%{$search}%\""
                    );
                }
            });
        }

        return $this;
    }

    public function name($name)
    {
        $this->name = $name;

        return $this;
    }

    public function export($export, $name = 'data')
    {
        $this->export = new $export($this->query);
        $this->name = $name;

        return $this;
    }

    /**
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function perform()
    {
        if ($this->request->get('export')) {
            $currentDate = date('dmY-His');

            return Excel::download(
                $this->export,
                "{$this->name}-export-$currentDate.xlsx"
            );
        }

        return $this->query->paginate($this->request->get('perPage'), $this->columns);
    }
}
