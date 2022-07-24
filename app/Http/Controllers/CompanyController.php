<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * @group Company Management
 * 
 * APIs to manage Company Module
 * 
 */
class CompanyController extends Controller
{
    /**
     * Insert
     * 
     * API to store/insert company
     * 
     * @bodyParam company_name string required Example: Hazesoft.co
     * @bodyParam company_location string required Example: Sankhamul, Kathmandu
     * @bodyParam contact_number string required Example: 983234824
     *
     * @authenticated
     */
    public function insertCompany(Request $request)
    {
        $data = $request->all();
        try {
            return DB::transaction(function () use ($data) {  // to rollback from DB if any issue occurs
                $data['creator_user_id'] = Auth::id();
                $company = Company::create($data);

                return $this->respond($company);
            });
        } catch (Exception $e) {
            $message = $e->getMessage();

            return $this->respondErrorWithMessage($message, 403, 403);
        }
    }

    /**
     * Get
     * 
     * API to get all companies (publicly)
     * 
     */
    public function getAllCompanies()
    {
        $companies = Company::all();
        return $this->respond($companies);
    }
}
