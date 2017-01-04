<?php

use Illuminate\Database\Seeder;
use App\Storage;

class StorageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 1; $i <= 4; $i++) {
            $idI = $this->createStorage('Regal ' . $i, str_pad($i, 3, '0', STR_PAD_LEFT));
            for($x = 1; $x <= 3; $x++) {
                $idX = $this->createStorage('Boden ' . $x, str_pad($x, 3, '0', STR_PAD_LEFT), $idI);
                for($y = 1; $y <= 5; $y++) {
                    $idY = $this->createStorage('Fach ' . $y, str_pad($y, 3, '0', STR_PAD_LEFT), $idX);
                }
            }
        }
    }

    private function createStorage($name, $short, $parent = null) {
        $storage = new Storage;
        $storage->short_code = $short;
        $storage->name = $name;
        $storage->parent_storage = $parent;
        $storage->save();

        return $storage->id;
    }
}
