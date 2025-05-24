<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ExpenseService;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function __construct(protected ExpenseService $service)
    {
        $this->middleware('validate.expense')->only(['store','update']);
    }

    public function index()
    {
        return response()->json($this->service->list());
    }

    public function store(Request $request)
    {
        return response()->json($this->service->create($request->all()), 201);
    }

    public function show($id)
    {
        // you could implement show if needed...
    }

    public function update(Request $request, $id)
    {
        return response()->json($this->service->update($id, $request->all()));
    }

    public function destroy($id)
    {
        $this->service->delete($id);
        return response()->noContent();
    }
}
