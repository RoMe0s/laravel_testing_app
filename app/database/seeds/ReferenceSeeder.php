<?php

use App\Models\Reference;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ReferenceSeeder extends Seeder
{
    private const DEFAULT_REFERENCES = [
        'Make' => [
            'BMW',
            'Mercedes',
            'Jeep',
        ],
        'BMW Model' => [
            '3 Series',
            '5 Series',
            '7 Series',
        ],
        'Mercedes Model' => [
            'C Class',
            'E Class',
            'S Class',
        ],
        'Jeep Model' => [
            'Wrangler',
            'Cherokee',
            'Grand Cherokee',
        ],
        'Color' => [
            'White',
            'Silver',
            'Black',
            'Other',
        ],
        'Drivetrain' => [
            '2x4',
            '4x4',
        ],
    ];

    public function run(): void
    {
        DB::beginTransaction();

        try {
            foreach (self::DEFAULT_REFERENCES as $referenceName => $referenceValues) {
                /** @var Reference $reference */
                $reference = Reference::query()->updateOrCreate(
                    ['key' => Str::slug($referenceName)],
                    ['name' => $referenceName]
                );

                foreach ($referenceValues as $referenceValue) {
                    $reference->values()->updateOrCreate(['value' => $referenceValue]);
                }
            }

            DB::commit();
        } catch (Throwable $exception) {
            DB::rollBack();

            throw $exception;
        }
    }
}
