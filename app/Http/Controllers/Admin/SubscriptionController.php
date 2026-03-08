<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use App\Models\Plan;
use App\Models\User;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    private function authCheck()
    {
        return session('admin_logged_in');
    }

    public function index(Request $request)
    {
        if (!$this->authCheck()) return redirect()->route('admin.login');

        $query = Subscription::with(['user', 'plan']);

        if ($request->status) {
            $query->where('status', $request->status);
        }
        if ($request->search) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('name', 'like', '%'.$request->search.'%')
                  ->orWhere('email', 'like', '%'.$request->search.'%');
            });
        }

        $subscriptions = $query->orderBy('created_at', 'desc')->paginate(20);

        $stats = [
            'active'   => Subscription::where('status', 'active')->count(),
            'canceled' => Subscription::where('status', 'canceled')->count(),
            'revenue'  => Subscription::where('status', 'active')->sum('amount'),
        ];

        return view('admin.subscriptions.index', compact('subscriptions', 'stats'));
    }

    public function show($id)
    {
        if (!$this->authCheck()) return redirect()->route('admin.login');
        $subscription = Subscription::with(['user', 'plan'])->findOrFail($id);
        return view('admin.subscriptions.show', compact('subscription'));
    }

    public function cancel($id)
    {
        if (!$this->authCheck()) return redirect()->route('admin.login');
        Subscription::findOrFail($id)->update(['status' => 'canceled', 'canceled_at' => now()]);
        return back()->with('success', 'Předplatné bylo zrušeno.');
    }

    public function plans()
    {
        if (!$this->authCheck()) return redirect()->route('admin.login');
        $plans = Plan::orderBy('price')->get();
        return view('admin.plans.index', compact('plans'));
    }

    public function createPlan()
    {
        if (!$this->authCheck()) return redirect()->route('admin.login');
        return view('admin.plans.create');
    }

    public function storePlan(Request $request)
    {
        if (!$this->authCheck()) return redirect()->route('admin.login');

        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'slug'        => 'required|string|unique:plans,slug',
            'price'       => 'required|numeric|min:0',
            'interval'    => 'required|in:monthly,yearly',
            'description' => 'nullable|string',
            'features'    => 'nullable|string',
            'active'      => 'boolean',
        ]);

        $validated['features'] = $validated['features'] ?? '';
        $validated['active']   = $request->has('active');

        Plan::create($validated);

        return redirect()->route('admin.plans.index')->with('success', 'Plán byl vytvořen.');
    }

    public function editPlan($id)
    {
        if (!$this->authCheck()) return redirect()->route('admin.login');
        $plan = Plan::findOrFail($id);
        return view('admin.plans.edit', compact('plan'));
    }

    public function updatePlan(Request $request, $id)
    {
        if (!$this->authCheck()) return redirect()->route('admin.login');

        $plan = Plan::findOrFail($id);

        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'price'       => 'required|numeric|min:0',
            'interval'    => 'required|in:monthly,yearly',
            'description' => 'nullable|string',
            'features'    => 'nullable|string',
        ]);

        $validated['active'] = $request->has('active');
        $plan->update($validated);

        return redirect()->route('admin.plans.index')->with('success', 'Plán byl aktualizován.');
    }

    public function destroyPlan($id)
    {
        if (!$this->authCheck()) return redirect()->route('admin.login');
        Plan::findOrFail($id)->delete();
        return redirect()->route('admin.plans.index')->with('success', 'Plán byl smazán.');
    }
}