<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * @group Department Management
 * 
 * APIs to manage Department Module
 * 
 */
class DepartmentController extends Controller
{
    /**
     * Insert
     * 
     * API to store/insert department
     * 
     * @bodyParam department_name string required Example: Human Resource Department
     * @bodyParam company_id int required Example: 1
     *
     * @authenticated
     */
    public function insertDepartment(Request $request)
    {
        $data = $request->all();
        try {
            return DB::transaction(function () use ($data) {
                $data['creator_user_id'] = Auth::id();
                $department = Department::create($data);

                return $this->respond($department);
            });
        } catch (Exception $e) {
            $message = $e->getMessage();

            return $this->respondErrorWithMessage($message, 403, 403);
        }
    }

    /**
     * Get
     * 
     * API to get all departments of a company
     * 
     * @authenticated
     */
    public function getCompanyDepartments(Request $request)
    {
        $data = $request->all();
        $company_id = $data['company_id'];

        $departments = Department::where('company_id', $company_id)->get();

        return $this->respond($departments);
    }
}
