<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;

class FillProductsCharCommand extends Command
{
    protected $signature = 'app:add-ch';

    protected $description = 'Add characteristics to products';

    const SIZE_CH_ID = 1;
    const HEIGHTOF_MODULE_CH_ID = 2;
    const LENGH_CH_ID = 3;
    const COUNTRY_CH_ID = 4;
    const TYPE_CH_ID = 5;
    const MOUNT_CH_ID = 6;
    const POWER_CH_ID = 7;
    const PERFOMANCE_CH_ID = 8;


    public function handle()
    {
        $sizeValues = ['250x124', '250x125', '250x126', '250x127', '250x128', '250x129', '250x130', '250x131', '250x132', '250x133'];
        $heightOfModuleValues = ['Полноразмерный', 'Половинный'];
        $lengthValues = ['250x456', '250x457', '250x458', '250x459', '250x460', '250x461', '250x462', '250x463', '250x464', '250x465'];
        $countryValues = ['Россия', 'Китай', 'Турция', 'Украина', 'Беларусь', 'Польша', 'Германия', 'Франция', 'Италия', 'Испания'];
        $typeValues = ['Электрическая', 'Бензиновая'];
        $mountValues = ['Горизонтальный', 'Вертикальный'];
        $powerValues = ['1000', '1100', '1200', '1300', '1400', '1500', '1600', '1700', '1800', '1900'];
        $performanceValues = ['10000', '11000', '12000', '13000', '14000', '15000', '16000', '17000', '18000', '19000'];

        Product::with('category.parent')->get()->each(function ($product) use ($sizeValues, $heightOfModuleValues, $lengthValues, $countryValues, $typeValues, $mountValues, $powerValues, $performanceValues) {
            if (in_array($product->category->parent?->id,[1,2])) {
                $product->category->characteristics()->sync([self::SIZE_CH_ID, self::HEIGHTOF_MODULE_CH_ID, self::LENGH_CH_ID, self::COUNTRY_CH_ID, self::TYPE_CH_ID, self::MOUNT_CH_ID, self::POWER_CH_ID, self::PERFOMANCE_CH_ID]);
                
                $product->characteristics()->syncWithoutDetaching([
                    self::SIZE_CH_ID => ['value' => $sizeValues[array_rand($sizeValues)]],
                    self::HEIGHTOF_MODULE_CH_ID => ['value' => $heightOfModuleValues[array_rand($heightOfModuleValues)]],
                    self::LENGH_CH_ID => ['value' => $lengthValues[array_rand($lengthValues)]],
                    self::COUNTRY_CH_ID => ['value' => $countryValues[array_rand($countryValues)]],
                    self::TYPE_CH_ID => ['value' => $typeValues[array_rand($typeValues)]],
                    self::MOUNT_CH_ID => ['value' => $mountValues[array_rand($mountValues)]],
                    self::POWER_CH_ID => ['value' => $powerValues[array_rand($powerValues)]],
                    self::PERFOMANCE_CH_ID => ['value' => $performanceValues[array_rand($performanceValues)]],
                ]);
            }
        });
    }
}
