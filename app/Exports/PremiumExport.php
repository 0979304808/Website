<?php

namespace App\Exports;

use App\Models\Premiums\PremiumMazii;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;


class PremiumExport implements FromQuery, WithMapping, WithHeadings
{
    use Exportable;

    /**
     * @return \Illuminate\Support\Collection
     */

    private $sort;
    private $filter;
    private $search;

    public function __construct($sort, $filter, $search)
    {
        $this->sort = $sort;
        $this->filter = $filter;
        $this->search = $search;
    }

    public function query()
    {
        $sort = $this->sort;
        $filter = $this->filter;
        $search = $this->search;
        if ($sort == 'old') {
            $sort = 'asc';
        }
        if ($sort == 'new') {
            $sort = 'desc';
        }
        $select = [
            'userId',
            'transaction',
            'provider',
            'created_at',
            'updated_at',
        ];
        $model = PremiumMazii::query()->with(['user'])->select($select);
        if ($filter != null ){
            return $model->where('provider',$filter)
                ->orderBy('created_at', $sort);
        }
        if ($search != null ){
            return $model->whereHas('user', function ($query) use ($search) {
                $query->where('userId', 'like', '%' . $search . '%');
                $query->orWhere('email', 'like', '%' . $search . '%');
            })->orWhere('transaction', 'like', '%' . $search . '%')->orWhere('premiumId', 'like', '%' . $search . '%');
        }
        return $model->orderBy('created_at', $sort);
    }

    public function map($premium): array
    {
        return [
            isset($premium->user->userId) ? $premium->user->userId : '',
            isset($premium->user->username) ? $premium->user->username : '',
            isset($premium->user->email) ? $premium->user->email : '',
            isset($premium->transaction) ? $premium->transaction : '',
            isset($premium->provider) ? $premium->provider : '',
            isset($premium->created_at) ? $premium->created_at : '',
            isset($premium->updated_at) ? $premium->updated_at : '',
        ];
    }

    public function headings(): array
    {
        return [
            'UserId',
            'Username',
            'Email',
            'Transaction',
            'Provider',
            'Created_at',
            'Updated_at',
        ];
    }
}

