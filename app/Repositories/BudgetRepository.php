<?php
namespace App\Repositories;

use App\Models\Budget;

class BudgetRepository
{
    public function forMonth($userId, $month)
    {
        return Budget::firstOrCreate(
            ['user_id' => $userId, 'month' => $month],
            ['amount'  => 0]
        );
    }

    public function setAmount($userId, $month, $amount)
    {
        $budget = $this->forMonth($userId, $month);
        $budget->amount = $amount;
        $budget->save();
        return $budget;
    }
}
