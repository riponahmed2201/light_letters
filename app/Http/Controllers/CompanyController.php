<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
class CompanyController extends Controller
{
    public function createCompany(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required',
            'org_name' => 'required',
            'address' => 'required',
            'tag_line' => 'required',
            'phone' => 'required',
        ]);
        $company = new Company;
        $company->client_id = $request->client_id;
        $company->org_name = $request->org_name;
        $company->address = $request->address;
        $company->website = $request->website;
        $company->tag_line = $request->tag_line;
        $company->email = $request->email;
        $company->phone = $request->phone;
        $company->save();
        return response()->json(['status'=>'success','company-info'=>$company],201);
    }
    public function getAllCompany(){
        $company = Company::all();
        return response()->json($company,200); //get all company
    }

    public function updateCompany(Request $request, $company_id)
    {
        //  $validatedData = $request->validate([
        //     'email' => 'required',
        //     'org_name' => 'required',
        //     'address' => 'required',
        //     'tag_line' => 'required',
        //     'phone' => 'required',
        // ]);
        $company = companyDetail($company_id);
        $company->client_id = $company_id;
        $company->org_name = $request->org_name;
        $company->address = $request->address;
        $company->website = $request->website;
        $company->tag_line = $request->tag_line;
        $company->email = $request->email;
        $company->phone = $request->phone;
        $company->save();
        return response()->json(['status'=>'successfully updated','company-info'=>$company],201);
    }

     public function deleteCompany($company_id)
    {
        $company = companyDetail($company_id);
        $company->delete();
        return response()->json(['status'=>'Removed Company','about-company'=>$company],200);
    }

    public function testCompany($company_id){
        $company = companyDetail($company_id);
        return response()->json($company,200);

    }
}
