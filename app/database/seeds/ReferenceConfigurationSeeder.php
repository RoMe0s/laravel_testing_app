<?php

use App\Models\Reference;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ReferenceConfigurationSeeder extends Seeder
{
    private const DEFAULT_REFERENCE_CONFIGURATIONS = [
        'BMW Model' => [
            'Make' => ['BMW'],
        ],
        'Mercedes Model' => [
            'Make' => ['Mercedes'],
        ],
        'Jeep Model' => [
            'Make' => ['Jeep'],
        ],
        'Drivetrain' => [
            'Make' => ['Jeep'],
            'Jeep Model' => ['Grand Cherokee'],
        ],
    ];

    public function run(): void
    {
        $references = Reference::query()->with('values')->get();

        DB::beginTransaction();

        try {
            foreach (self::DEFAULT_REFERENCE_CONFIGURATIONS as $referenceName => $configuration) {
                /** @var Reference $reference */
                $reference = $references->firstWhere('key', Str::slug($referenceName));

                if (is_null($reference)) {
                    throw new InvalidArgumentException("Reference [$referenceName] is missed.");
                }

                foreach ($configuration as $relatedReferenceName => $referenceValues) {
                    $relatedReference = $references->firstWhere('key', Str::slug($relatedReferenceName));

                    if (is_null($relatedReference)) {
                        throw new InvalidArgumentException("Reference [$relatedReferenceName] is missed.");
                    }

                    foreach ($referenceValues as $referenceValue) {
                        $relatedReferenceValue = $relatedReference->values->firstWhere('value', $referenceValue);

                        if (is_null($relatedReferenceValue)) {
                            throw new InvalidArgumentException("Reference value [$relatedReferenceValue] in reference [$relatedReferenceName] is missed.");
                        }

                        $reference->dependOnValues()->attach($relatedReferenceValue);
                    }
                }
            }

            DB::commit();
        } catch (Throwable $exception) {
            DB::rollBack();

            throw $exception;
        }
    }
}
