<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Estimate;
use App\Models\Invoice;
use App\Models\Part;
use App\Models\ServiceJob;
use App\Models\TechnicianTask;
use App\Services\ModuleManager;
use Illuminate\View\View;

class MarketingController extends Controller
{
    public function home(ModuleManager $modules): View
    {
        return view('marketing.home', [
            'modules' => $modules->all(),
            'enabledCount' => count($modules->enabledKeys()),
            'weeklyHours' => $modules->weeklyHoursSaved(),
            'openJobs' => ServiceJob::query()->whereNotIn('status', ['completed', 'cancelled'])->count(),
            'estimates' => Estimate::query()->count(),
            'invoices' => Invoice::query()->count(),
            'tasks' => TechnicianTask::query()->count(),
            'customers' => Customer::query()->where('status', 'active')->take(3)->get(),
            'jobs' => ServiceJob::query()->with('customer')->latest()->take(4)->get(),
        ]);
    }

    public function features(ModuleManager $modules): View
    {
        return view('marketing.features', [
            'modules' => $modules->all()->groupBy(fn (array $m) => $m['category'] ?? 'general'),
        ]);
    }

    public function modules(ModuleManager $modules): View
    {
        return view('marketing.modules', [
            'modules' => $modules->all(),
            'weeklyHours' => $modules->weeklyHoursSaved(),
        ]);
    }

    public function dispatch(): View
    {
        return view('marketing.dispatch', [
            'jobs' => ServiceJob::query()->with(['customer', 'technician'])->latest('scheduled_at')->take(10)->get(),
        ]);
    }

    public function estimates(): View
    {
        return view('marketing.estimates', [
            'estimates' => Estimate::query()->with('customer')->latest()->take(8)->get(),
            'invoices' => Invoice::query()->with('customer')->latest()->take(8)->get(),
            'parts' => Part::query()->where('is_active', true)->take(6)->get(),
        ]);
    }

    public function pricing(ModuleManager $modules): View
    {
        $hours = $modules->weeklyHoursSaved();

        return view('marketing.pricing', [
            'weeklyHours' => $hours,
            'weeklyValue' => $hours * 55,
            'moduleCount' => $modules->all()->count(),
            'enabledCount' => count($modules->enabledKeys()),
        ]);
    }

    public function demo(): View
    {
        return view('marketing.demo', [
            'email' => config('trades.demo.email'),
            'password' => config('trades.demo.password'),
        ]);
    }
}
