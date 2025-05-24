<?php
namespace App\Services;

use App\Repositories\BudgetRepository;
use App\Repositories\ExpenseRepository;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BudgetService
{
    protected $budgetRepo;
    protected $expenseRepo;

    public function __construct(BudgetRepository $budgetRepo, ExpenseRepository $expenseRepo)
    {
        $this->budgetRepo   = $budgetRepo;
        $this->expenseRepo  = $expenseRepo;
    }

    public function setMonthlyBudget($amount)
    {
        $month = Carbon::now()->format('Y-m');
        return $this->budgetRepo->setAmount(Auth::id(), $month, $amount);
    }

    public function getRemaining()
    {
        $month    = Carbon::now()->format('Y-m');
        $budget   = $this->budgetRepo->forMonth(Auth::id(), $month);
        $expenses = $this->expenseRepo->allForUser(Auth::id())
                          ->where('date', 'like', "$month%")
                          ->sum('amount');

        return [
            'budget'    => $budget->amount,
            'spent'     => $expenses,
            'remaining' => $budget->amount - $expenses,
        ];
    }
}
