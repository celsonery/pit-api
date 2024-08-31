<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use App\Models\Company;
use App\Services\CompanyService;
use Illuminate\Http\JsonResponse;

class CompanyController extends Controller
{
    public function __construct(protected CompanyService $companyService)
    {
    }

    public function index(): JsonResponse
    {
        $companies = $this->companyService->list();

        return response()->json($companies);
    }

    public function store(StoreCompanyRequest $request)
    {
        $company = $this->companyService->store($request);

        return response()->json($company);
    }

    public function show(Company $company)
    {
        return response()->json($company);
    }

    public function update(UpdateCompanyRequest $request, Company $company)
    {
        $company = $this->companyService->update($request, $company);

        return response()->json($company);
    }

    public function destroy(Company $company)
    {
        $company = $this->companyService->destroy($company);

        return response()->json(['message' => 'Company deleted!']);
    }
}
