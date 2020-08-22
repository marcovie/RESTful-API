<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\DataUserModel;
use App\Models\DataExpenseModel;

class apiExpenseTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    protected $user;

    public function setUp():void {
        parent::setUp();

        $this->user = factory(DataUserModel::class)->create();

        $this->actingAs($this->user, 'api');
    }

    //Get records from index api
    public function test_expense_index()
    {
        $expense = factory(DataExpenseModel::class)->times(5)->create([
            'user_id' => $this->user->id
        ]);

        $this->user->expense()->saveMany($expense);

        $this->get(route('expense.index'))
        ->assertJsonStructure([
            'current_page',
            'total',
            'per_page',
            'data'          =>  ['*'=>['id','amount','description','created_at','updated_at']],
        ])
        ->assertStatus(200);
    }

    //Store value via api
    public function test_expense_store()
    {
        $data = [
            'amount'            => $this->faker->numberBetween($min = 1000, $max = 20000),//PENCE 10000 eg 100.00 from £10-200
            'description'       => $this->faker->randomElement(['Take out', 'Clothes', 'Groceries', 'Uber', 'Hotel', 'Amazon', 'Fuel']),
        ];

        $this->post(route('expense.store'), $data)
            ->assertStatus(201)
            ->assertJsonStructure(['id','amount','description','created_at','updated_at']);
    }

    //Show test
    public function test_expense_show()
    {
        $expense = factory(DataExpenseModel::class)->create([
            'user_id' => $this->user->id
        ]);

        $this->get(route('expense.show', $expense->id))
             ->assertJson($expense->format())
             ->assertStatus(200);
    }

    //Update a record
    public function test_expnse_update()
    {
        $expense = factory(DataExpenseModel::class)->create([
            'user_id' => $this->user->id
        ]);

        $updatedData = [
            'amount'            => $this->faker->numberBetween($min = 1000, $max = 20000),//PENCE 10000 eg 100.00 from £10-200
            'description'       => $this->faker->randomElement(['Take out', 'Clothes', 'Groceries', 'Uber', 'Hotel', 'Amazon', 'Fuel']),
        ];

        $expense->amount        = $updatedData['amount'];
        $expense->description   = $updatedData['description'];

        $this->json('PUT', route('expense.update', $expense->id), $updatedData)
            ->assertJson($expense->format())
            ->assertStatus(200);
    }

    //Destroy a recrod
    public function test_expense_destroy()
    {
        $expense = factory(DataExpenseModel::class)->create([
            'user_id' => $this->user->id
        ]);

        $this->delete(route('expense.destroy', $expense->id))->assertStatus(204);
    }
}
