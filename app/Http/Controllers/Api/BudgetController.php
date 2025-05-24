<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\BudgetService;
use Illuminate\Http\Request;

class BudgetController extends Controller
{
    public function __construct(protected BudgetService $service) {}

    public function show()
    {
        return response()->json($this->service->getRemaining());
    }

    public function update(Request $request)
    {
        $request->validate(['amount' => 'required|numeric|min:0']);
        return response()->json($this->service->setMonthlyBudget($request->amount));
    }
}
