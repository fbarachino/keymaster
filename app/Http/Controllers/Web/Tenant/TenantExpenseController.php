<?php

namespace App\Http\Controllers\Web\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use Illuminate\Http\Request;

class TenantExpenseController extends Controller
{
    public function index(Request $request)
    {
        $tenant = $request->user()->tenant;

        $expenses = Expense::where('tenant_id', $tenant->id)
            ->orderBy('expense_date', 'desc')
            ->paginate(20);

        return view('tenant.expenses.index', compact('expenses'));
    }

    public function show(Expense $expense)
    {
        abort_unless($expense->tenant_id === auth()->user()->tenant->id, 403);

        return view('tenant.expenses.show', compact('expense'));
    }
}
