<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CompanyController extends Controller
{
    public function insertCompany(Request $request)
    {
        $data = $request->all();

        return DB::transaction(function () use ($data) {  // to rollback from DB if any issue occurs
            $data['creator_user_id'] = Auth::id();
            $company = Company::create($data);

            return $this->respond($company);
        });
    }


    public function getAllCompanies()
    {
        $companies = Company::all();
        return $this->respond($companies);
    }
}
