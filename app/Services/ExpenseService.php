<?php
namespace App\Services;

use App\Repositories\ExpenseRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class ExpenseService
{
    protected $repo;

    public function __construct(ExpenseRepository $repo)
    {
        $this->repo = $repo;
    }

    public function list()
    {
        return $this->repo->allForUser(Auth::id());
    }

    public function create(array $data)
    {
        if ($data['amount'] <= 0) {
            throw ValidationException::withMessages(['amount' => 'Amount must be > 0']);
        }
        // other validations...

        $data['user_id'] = Auth::id();
        return $this->repo->create($data);
    }

    public function update($id, array $data)
    {
        if (isset($data['amount']) && $data['amount'] <= 0) {
            throw ValidationException::withMessages(['amount' => 'Amount must be > 0']);
        }

        return $this->repo->update($id, $data, Auth::id());
    }

    public function delete($id)
    {
        return $this->repo->delete($id, Auth::id());
    }
}
