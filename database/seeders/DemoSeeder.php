<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\AiAssistSession;
use App\Models\Customer;
use App\Models\Estimate;
use App\Models\EstimateLine;
use App\Models\Invoice;
use App\Models\InvoiceLine;
use App\Models\Part;
use App\Models\Property;
use App\Models\ServiceJob;
use App\Models\TechnicianTask;
use App\Models\User;
use App\Services\ModuleManager;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        $users = $this->seedUsers();
        app(ModuleManager::class)->syncFromConfig();

        $customers = $this->seedCustomers();
        $jobs = $this->seedJobs($customers, $users);
        $this->seedEstimatesAndInvoices($customers, $jobs, $users);
        $this->seedTechnicianTasks($jobs, $users);
        $this->seedAi($jobs, $users);
        $this->seedParts();
    }

    /** @return array<string, User> */
    protected function seedUsers(): array
    {
        $password = config('trades.demo.password', 'password');

        $defs = [
            'super' => ['name' => 'Imran Ahmed', 'email' => 'admin@tradeflow.test', 'role' => UserRole::SuperAdmin, 'org' => 'ImranDev BD', 'title' => 'Platform Architect', 'trade' => null],
            'admin' => ['name' => 'Sara Chowdhury', 'email' => 'ops@tradeflow.test', 'role' => UserRole::Admin, 'org' => 'Metro Trade Co', 'title' => 'Ops Admin', 'trade' => null],
            'manager' => ['name' => 'Jamal Uddin', 'email' => 'dispatch@tradeflow.test', 'role' => UserRole::Manager, 'org' => 'Metro Trade Co', 'title' => 'Dispatch Manager', 'trade' => 'multi'],
            'staff' => ['name' => 'Rafi Hasan', 'email' => 'tech@tradeflow.test', 'role' => UserRole::Staff, 'org' => 'Metro Trade Co', 'title' => 'Lead Technician', 'trade' => 'plumbing'],
            'hvac' => ['name' => 'Nusrat Jahan', 'email' => 'hvac@tradeflow.test', 'role' => UserRole::Staff, 'org' => 'Metro Trade Co', 'title' => 'HVAC Technician', 'trade' => 'hvac'],
            'client' => ['name' => 'Greenview Residences', 'email' => 'client@tradeflow.test', 'role' => UserRole::Client, 'org' => 'Greenview Residences', 'title' => 'Property Manager', 'trade' => null],
            'demo' => ['name' => 'Demo User', 'email' => config('trades.demo.email'), 'role' => UserRole::Demo, 'org' => 'Demo Shop', 'title' => 'Evaluator', 'trade' => 'multi'],
        ];

        $users = [];
        foreach ($defs as $key => $def) {
            $users[$key] = User::query()->updateOrCreate(
                ['email' => $def['email']],
                [
                    'name' => $def['name'],
                    'password' => $password,
                    'role' => $def['role'],
                    'organization_name' => $def['org'],
                    'job_title' => $def['title'],
                    'trade_specialty' => $def['trade'],
                    'phone' => '+88015'.random_int(10000000, 99999999),
                    'is_active' => true,
                    'email_verified_at' => now(),
                ]
            );
        }

        return $users;
    }

    /** @return array<string, array{customer: Customer, property: Property}> */
    protected function seedCustomers(): array
    {
        $items = [
            ['name' => 'Greenview Residences', 'slug' => 'greenview-residences', 'type' => 'property_mgmt', 'label' => 'Tower B Unit 1204', 'city' => 'Dhaka', 'equip' => 'Tankless WH + central AC'],
            ['name' => 'Bayleaf Cafe', 'slug' => 'bayleaf-cafe', 'type' => 'commercial', 'label' => 'Kitchen Line', 'city' => 'Chattogram', 'equip' => 'Grease trap + walk-in cooler'],
            ['name' => 'Hassan Family Home', 'slug' => 'hassan-family-home', 'type' => 'residential', 'label' => 'Main House', 'city' => 'Savar', 'equip' => '1.5T split AC + PVC stack'],
        ];

        $out = [];
        foreach ($items as $item) {
            $customer = Customer::query()->updateOrCreate(
                ['slug' => $item['slug']],
                [
                    'name' => $item['name'],
                    'contact_name' => 'Site Contact',
                    'email' => Str::slug($item['slug']).'@example.test',
                    'phone' => '+8801711000000',
                    'account_type' => $item['type'],
                    'status' => 'active',
                    'notes' => 'Priority trades account for plumbing/HVAC demo.',
                ]
            );

            $property = Property::query()->updateOrCreate(
                ['customer_id' => $customer->id, 'label' => $item['label']],
                [
                    'address_line' => 'Service Road 7',
                    'city' => $item['city'],
                    'region' => 'Dhaka Division',
                    'postal_code' => '1200',
                    'country' => 'BD',
                    'property_type' => $item['type'] === 'residential' ? 'home' : 'office',
                    'access_notes' => 'Call ahead; park in visitor bay.',
                    'equipment_notes' => $item['equip'],
                ]
            );

            $out[$item['slug']] = compact('customer', 'property');
        }

        return $out;
    }

    /**
     * @param  array<string, array{customer: Customer, property: Property}>  $customers
     * @param  array<string, User>  $users
     * @return array<int, ServiceJob>
     */
    protected function seedJobs(array $customers, array $users): array
    {
        $plan = [
            ['JOB-2401', 'greenview-residences', 'Burst supply line — Tower B', 'plumbing', 'emergency', 'on_site', 'staff', 450],
            ['JOB-2402', 'bayleaf-cafe', 'Walk-in cooler not holding temp', 'hvac', 'high', 'en_route', 'hvac', 890],
            ['JOB-2403', 'hassan-family-home', 'Annual AC tune-up', 'hvac', 'normal', 'scheduled', 'hvac', 120],
            ['JOB-2404', 'greenview-residences', 'Clogged kitchen stack', 'drain', 'high', 'scheduled', 'staff', 220],
            ['JOB-2405', 'bayleaf-cafe', 'Install new faucet bank', 'plumbing', 'low', 'completed', 'staff', 610],
        ];

        $jobs = [];
        foreach ($plan as [$number, $key, $title, $trade, $priority, $status, $techKey, $amount]) {
            $bundle = $customers[$key];
            $jobs[] = ServiceJob::query()->updateOrCreate(
                ['number' => $number],
                [
                    'customer_id' => $bundle['customer']->id,
                    'property_id' => $bundle['property']->id,
                    'technician_id' => $users[$techKey]->id,
                    'title' => $title,
                    'trade_type' => $trade,
                    'priority' => $priority,
                    'status' => $status,
                    'description' => 'Demo dispatch job for TradeFlow plumbing/HVAC workflows.',
                    'scheduled_at' => now()->subHours(random_int(1, 12)),
                    'eta_at' => now()->addHours(random_int(1, 4)),
                    'started_at' => in_array($status, ['on_site', 'en_route', 'completed'], true) ? now()->subHour() : null,
                    'completed_at' => $status === 'completed' ? now()->subMinutes(40) : null,
                    'quoted_amount' => $amount,
                ]
            );
        }

        return $jobs;
    }

    /**
     * @param  array<string, array{customer: Customer, property: Property}>  $customers
     * @param  array<int, ServiceJob>  $jobs
     * @param  array<string, User>  $users
     */
    protected function seedEstimatesAndInvoices(array $customers, array $jobs, array $users): void
    {
        $estimate = Estimate::query()->updateOrCreate(
            ['number' => 'EST-501'],
            [
                'slug' => 'est-501-walk-in-cooler',
                'customer_id' => $customers['bayleaf-cafe']['customer']->id,
                'service_job_id' => $jobs[1]->id,
                'created_by' => $users['manager']->id,
                'title' => 'Walk-in cooler repair estimate',
                'trade_type' => 'hvac',
                'status' => 'sent',
                'subtotal' => 820,
                'tax_amount' => 70,
                'total' => 890,
                'deposit_required' => 200,
                'valid_until' => now()->addDays(7),
                'notes' => 'Includes diagnostic, refrigerant top-up, and condenser clean.',
            ]
        );

        EstimateLine::query()->updateOrCreate(
            ['estimate_id' => $estimate->id, 'sort_order' => 1],
            ['description' => 'Diagnostic + labor (2 hrs)', 'quantity' => 2, 'unit_price' => 85, 'line_total' => 170]
        );
        EstimateLine::query()->updateOrCreate(
            ['estimate_id' => $estimate->id, 'sort_order' => 2],
            ['description' => 'Refrigerant + condenser service', 'quantity' => 1, 'unit_price' => 650, 'line_total' => 650]
        );

        $invoice = Invoice::query()->updateOrCreate(
            ['number' => 'INV-901'],
            [
                'slug' => 'inv-901-faucet-bank',
                'customer_id' => $customers['bayleaf-cafe']['customer']->id,
                'service_job_id' => $jobs[4]->id,
                'estimate_id' => null,
                'created_by' => $users['admin']->id,
                'title' => 'Faucet bank install',
                'status' => 'partial',
                'subtotal' => 560,
                'tax_amount' => 50,
                'total' => 610,
                'amount_paid' => 200,
                'balance_due' => 410,
                'issued_at' => now()->subDays(2),
                'due_at' => now()->addDays(12),
                'pdf_path' => 'invoices/INV-901.pdf',
                'notes' => 'Deposit received on site via card.',
            ]
        );

        InvoiceLine::query()->updateOrCreate(
            ['invoice_id' => $invoice->id, 'sort_order' => 1],
            ['description' => 'Commercial faucet set', 'quantity' => 2, 'unit_price' => 145, 'line_total' => 290]
        );
        InvoiceLine::query()->updateOrCreate(
            ['invoice_id' => $invoice->id, 'sort_order' => 2],
            ['description' => 'Install labor', 'quantity' => 3, 'unit_price' => 90, 'line_total' => 270]
        );

        Estimate::query()->updateOrCreate(
            ['number' => 'EST-502'],
            [
                'slug' => 'est-502-burst-line',
                'customer_id' => $customers['greenview-residences']['customer']->id,
                'service_job_id' => $jobs[0]->id,
                'created_by' => $users['staff']->id,
                'title' => 'Emergency burst line repair',
                'trade_type' => 'plumbing',
                'status' => 'approved',
                'subtotal' => 420,
                'tax_amount' => 30,
                'total' => 450,
                'deposit_required' => 0,
                'valid_until' => now()->addDay(),
                'notes' => 'Approved verbally on site.',
            ]
        );
    }

    /**
     * @param  array<int, ServiceJob>  $jobs
     * @param  array<string, User>  $users
     */
    protected function seedTechnicianTasks(array $jobs, array $users): void
    {
        TechnicianTask::query()->updateOrCreate(
            ['service_job_id' => $jobs[0]->id, 'technician_id' => $users['staff']->id],
            [
                'status' => 'in_progress',
                'checked_in_at' => now()->subMinutes(45),
                'field_notes' => 'Shutoff located; replacing 1/2" copper section.',
                'parts_used' => '1/2" copper, couplings, flux',
                'completion_pct' => 60,
            ]
        );

        TechnicianTask::query()->updateOrCreate(
            ['service_job_id' => $jobs[1]->id, 'technician_id' => $users['hvac']->id],
            [
                'status' => 'checked_in',
                'checked_in_at' => now()->subMinutes(10),
                'field_notes' => 'En route complete; starting amp draw check.',
                'parts_used' => null,
                'completion_pct' => 15,
            ]
        );
    }

    /**
     * @param  array<int, ServiceJob>  $jobs
     * @param  array<string, User>  $users
     */
    protected function seedAi(array $jobs, array $users): void
    {
        AiAssistSession::query()->updateOrCreate(
            [
                'service_job_id' => $jobs[1]->id,
                'purpose' => 'diagnose',
            ],
            [
                'user_id' => $users['hvac']->id,
                'status' => 'completed',
                'prompt' => 'Walk-in cooler not holding temp; compressor short-cycling.',
                'response' => 'Likely dirty condenser or low charge. Check amp draw, coil cleanliness, and superheat before adding refrigerant.',
                'tokens_used' => 412,
            ]
        );

        AiAssistSession::query()->updateOrCreate(
            [
                'service_job_id' => $jobs[0]->id,
                'purpose' => 'customer_sms',
            ],
            [
                'user_id' => $users['manager']->id,
                'status' => 'completed',
                'prompt' => 'Draft SMS: tech on site for burst line, ETA finish 90 min.',
                'response' => 'Hi — our plumber is on site for the burst supply line. Water is isolated and repair should finish in about 90 minutes. We will text when pressure is restored.',
                'tokens_used' => 188,
            ]
        );
    }

    protected function seedParts(): void
    {
        $parts = [
            ['PL-COUP-12', 'copper-coupling-half', '1/2" Copper Coupling', 'plumbing', 'fittings', 1.2, 4.5, 120],
            ['HV-FILT-20', 'hvac-filter-20x20', '20x20 MERV-13 Filter', 'hvac', 'filters', 6.0, 18.0, 40],
            ['PL-FAUC-CM', 'commercial-faucet', 'Commercial Deck Faucet', 'plumbing', 'fixtures', 78.0, 145.0, 8],
            ['HV-CAP-35', 'run-cap-35uf', '35uF Run Capacitor', 'hvac', 'electrical', 9.5, 28.0, 22],
        ];

        foreach ($parts as [$sku, $slug, $name, $trade, $cat, $cost, $price, $qty]) {
            Part::query()->updateOrCreate(
                ['sku' => $sku],
                [
                    'slug' => $slug,
                    'name' => $name,
                    'trade_type' => $trade,
                    'category' => $cat,
                    'unit_cost' => $cost,
                    'unit_price' => $price,
                    'stock_qty' => $qty,
                    'supplier' => 'TradeSupply BD',
                    'is_active' => true,
                    'notes' => 'Demo parts catalog SKU.',
                ]
            );
        }
    }
}
