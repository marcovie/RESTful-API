<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        if (App::Environment() === 'local')
        {//Only run this Factory if on local and NOT PRODUCTION if this doesn't ease you just comment line out for safety when going live.
            $this->call(DataUserWithExpensesFactory::class);//Change .env file to production when going live.
        }
        Schema::enableForeignKeyConstraints();
    }
}
