<?php

namespace App\Exports;

use App\Acme\Models\User;
use App\Acme\Resources\Core\UserExportResource;
use Maatwebsite\Excel\Concerns\FromCollection;

class UsersExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $users = User::select('username', 'first_name', 'last_name', 'email', 'contact_number', 'created_at')
            ->get();

        return UserExportResource::collection($users);
    }
}
