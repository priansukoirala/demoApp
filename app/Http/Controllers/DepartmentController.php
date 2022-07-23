<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DepartmentController extends Controller
{
    public function insertDepartment(Request $request)
    {
        $data = $request->all();

        return DB::transaction(function () use ($data) {
            $data['creator_user_id'] = Auth::id();
            $department = Department::create($data);

            return $this->respond($department);
        });
    }

    public function getCompanyDepartments(Request $request)
    {
        $data = $request->all();
        $company_id = $data['company_id'];

        $department = Department::where('company_id', $company_id)->get();

        return $this->respond($department);
    }
}
