<?php

namespace App\Imports;

use App\Models\Premiums\PremiumMazii;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Validators\Failure;


class PremiumImport implements ToModel, WithHeadingRow, SkipsOnFailure, WithValidation, WithChunkReading, ShouldQueue
{
    use Importable;

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new PremiumMazii([
            'userId' => $row['userid'],
            'transaction' => $row['transaction'],
            'provider' => $row['provider'],
            'created_at' => $row['created_at'],
            'updated_at' => $row['updated_at'],
            'expire_at' => $row['expire_at'],
        ]);
    }

    public function rules(): array
    {
        return [
            '*.transaction' => ['unique:mazii.premium,transaction']
        ];
    }

    public function onFailure(Failure ...$failures)
    {
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
