<?php

namespace App\Services;

use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use App\Models\Company;

class CompanyService
{
    public function list()
    {
        return Company::select(['id', 'name'])
            ->paginate();
    }

    public function store(StoreCompanyRequest $request): Company
    {
        return Company::create($request->validated());
    }

    public function update(UpdateCompanyRequest $request, Company $company): Company
    {
        $company->update($request->validated());

        return $company;
    }

    public function destroy(Company $company): bool
    {
        return $company->delete();
    }
}
