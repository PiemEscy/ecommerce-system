<?php
namespace App\Repositories;

use App\Models\Account;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegisterAccountRepository extends BaseRepository
{
    public function __construct(Account $model)
    {
        parent::__construct($model);
    }

    public function createAccount(array $data)
    {
        $formatData = $this->formatAccount($data);
        return $this->model->create($formatData);
    }

    public function formatAccount(array $data)
    {
        return [
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ];
    }

}
