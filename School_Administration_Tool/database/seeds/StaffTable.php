<?php

use Illuminate\Database\Seeder;
use App\Staff;
class StaffTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // How many genres you need, defaulting to 10
        $count = (int)$this->command->ask('How many Staff do you need ?', 10);

        $this->command->info("Creating {$count} Staff and setting their passwords.");

        // Create the Genre
        $genres = factory(App\Staff::class, $count)->create();

        $this->command->info('Sections Created!');
    }
}
