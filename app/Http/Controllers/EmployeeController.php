<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
    public function insertEmployee(Request $request)
    {
        $data = $request->all();

        return DB::transaction(function () use ($data) {  // to rollback from DB if any issue occurs
            $data['creator_user_id'] = Auth::id();
            $company = Employee::create($data);
            return $this->respond($company);
        });
    }

    public function getAllEmployees(Request $request)
    {
        
    }
}
