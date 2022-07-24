<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * @group Employee Management
 * 
 * APIs to manage Employee Module
 * 
 */
class EmployeeController extends Controller
{
    /**
     * Insert
     * 
     * API to store/insert employee
     * 
     * @bodyParam employee_name string required Example: Anjan Parajuli
     * @bodyParam employee_number string required Example: 123
     * @bodyParam employee_email string required Example: anjan@hazesoft.com
     * @bodyParam employee_contact_number string required Example: 9832423424
     * @bodyParam employee_designation string required Example: Mid Level Laravel Developer
     * @bodyParam company_id int required Example: 1
     * @bodyParam department_id string Example: 1
     *
     * @authenticated
     */
    public function insertEmployee(Request $request)
    {
        $data = $request->all();
        try {
            return DB::transaction(function () use ($data) {  // to rollback from DB if any issue occurs
                $data['creator_user_id'] = Auth::id();

                $department_ids = $data['department_ids'];
                $employee = Employee::create($data);
                if (count($department_ids) > 0) {

                    foreach ($department_ids as $key => $department_id) {
                        DB::table('department_employee')->insert([
                            'employee_id' => $employee->id,
                            'department_id' => $department_id
                        ]);
                    }
                }

                return $this->respond($employee);
            });
        } catch (Exception $e) {
            $message = $e->getMessage();

            return $this->respondErrorWithMessage($message, 403, 403);
        }
    }
    /**
     * Get
     * 
     * API to get All Employee of a Company
     * 
     */
    public function getAllEmployeesOfCompany(Request $request)
    {
        $data = $request->all();
        $company_id = $data['company_id'];

        $employees = Employee::where('company_id', $company_id)->get();

        return $this->respond($employees);
    }
    /**
     * Get Employees of Specific Department
     * 
     * API to get All Employee of a Specific Department
     * 
     * @authenticated
     */
    public function getAllEmployeesOfDepartment(Request $request)
    {
        $data = $request->all();
        $company_id = $data['company_id'];
        $department_id = $data['department_id'];

        $employees = Employee::where('company_id', $company_id)->with(['departments' => function ($q) use ($department_id) {
            $q->where('department_id', $department_id);
        }])->get();

        return $this->respond($employees);
    }

    /**
     * Get Employees of Specific Department
     * 
     * API to get All Employee of a Specific Department
     * 
     * @authenticated
     */
    public function getEmployeeDetailsWithCompanyDepartment($id)
    {
        $employee = Employee::where('id', $id)->with('company', 'departments')->first();

        return $this->respond($employee);
    }
}
