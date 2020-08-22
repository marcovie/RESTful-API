<?php

use Illuminate\Database\Seeder;
use App\Models\DataUserModel;
use App\Models\DataExpenseModel;

class DataUserWithExpensesFactory extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = factory(DataUserModel::class)->create();

        factory(DataExpenseModel::class)->times(10)->create([
            'user_id' => $user->id
        ]);
    }
}
