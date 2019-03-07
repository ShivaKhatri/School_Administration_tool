<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class SectionTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // How many genres you need, defaulting to 10
        $count = (int)$this->command->ask('How many Sections do you need ?', 10);

        $this->command->info("Creating {$count} sections.");

        // Create the Genre
        $genres = factory(App\Model\Section::class, $count)->create();

        $this->command->info('Sections Created!');
    }
}
