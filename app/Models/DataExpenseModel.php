<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\DataUserModel;

class DataExpenseModel extends Model
{
    const TABLE_NAME = 'data_expenses';

    const PAGINATION = 5;

    protected $table = self::TABLE_NAME;

    protected $fillable = [
        'user_id', 'amount', 'description'
    ];

    public function user() {
        return $this->belongsTo(DataUserModel::class, 'id', 'user_id');
    }

    public function format() {//this incase want to format certain fields for api display
        return [
            'id'            => $this->id,
            'amount'        => ($this->amount/100),//converts Pence/Cents to Decimal for display purpose
            'description'   => $this->description,
            'created_at'    => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at'    => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }

    public static function fetchExpenses(DataUserModel $dataUserModel, $request) {
        $dataExpenseModel = $dataUserModel->expense();

        if(!is_null($request->sort))
            $dataExpenseModel->orderby($request->sort, (!is_null($request->orderby))?$request->orderby:'asc');

        if(!is_null($request->from_date))
            $dataExpenseModel->whereDate('updated_at', '>=', date('Y-m-d 00:00:00', strtotime($request->from_date)));

        if(!is_null($request->to_date))
            $dataExpenseModel->whereDate('updated_at', '<=', date('Y-m-d 23:59:59', strtotime($request->to_date)));

        $dataExpenseModel = tap($dataExpenseModel->paginate(self::PAGINATION), function($paginatedInstance){
            return $paginatedInstance->getCollection()->transform(function ($expense) {
                return $expense->format(); //Wrote a map format in DataExpenseModel as in future might only want to display specific fields in specific format.
            });
        });
        return $dataExpenseModel;
    }

    public static function findorfail(DataUserModel $dataUserModel, $id) {
        return $dataUserModel->expense()->findOrFail($id);
    }
}
