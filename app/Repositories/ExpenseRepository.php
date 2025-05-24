<?php
namespace App\Repositories;

use App\Models\Expense;

class ExpenseRepository
{
    public function allForUser($userId)
    {
        return Expense::where('user_id', $userId)->orderBy('date', 'desc')->get();
    }

    public function find($id, $userId)
    {
        return Expense::where('id', $id)
                      ->where('user_id', $userId)
                      ->firstOrFail();
    }

    public function create(array $data)
    {
        return Expense::create($data);
    }

    public function update($id, array $data, $userId)
    {
        $expense = $this->find($id, $userId);
        $expense->update($data);
        return $expense;
    }

    public function delete($id, $userId)
    {
        $expense = $this->find($id, $userId);
        return $expense->delete();
    }
}
