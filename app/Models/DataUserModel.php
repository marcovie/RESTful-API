<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Laravel\Passport\HasApiTokens;
use App\Models\DataExpenseModel;

class DataUserModel extends Authenticatable
{
    use HasApiTokens, Notifiable;

    const TABLE_NAME = 'data_users';

    const RULE_REGISTER = [
        'name'      => 'required|string',
        'email'     => 'required|string|email|unique:data_users',
        'password'  => 'required|string' // Left this simple for you guys to test. Please see below example of better solution
        // 'password' => [
        //             'required',
        //             'confirmed',
        //             'min:8',
        //             'regex:/[a-z]/',      // must contain at least one lowercase letter
        //             'regex:/[A-Z]/',      // must contain at least one uppercase letter
        //             'regex:/[0-9]/',      // must contain at least one digit
        //             'regex:/[@$!%*#?&]/', // must contain a special character
        //         ]
    ];

    const RULE_LOGIN = [
        'email' => 'required|string|email',
        'password' => 'required|string'
    ];

    protected $table = self::TABLE_NAME;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'last_login_ip', 'last_login',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function expense() {
        return $this->hasMany(DataExpenseModel::class, 'user_id', 'id');
    }

    public function format() {//this incase want to format certain fields for api display
        return [
            'name'          => $this->name,
            'email'         => $this->email,
            'created_at'    => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at'    => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
