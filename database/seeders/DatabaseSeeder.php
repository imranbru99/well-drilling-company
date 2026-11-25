<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\KnowledgeArticle;
use App\Models\Payment;
use App\Models\Post;
use App\Models\Product;
use App\Models\Project;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        foreach (['admin', 'manager', 'staff'] as $role) {
            Role::findOrCreate($role);
        }

        $admin = User::query()->updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'phone' => '(918) 555-0100',
            ]
        );
        $admin->syncRoles(['admin']);

        User::query()->updateOrCreate(
            ['email' => 'manager@stoneborewell.com'],
            [
                'name' => 'Marisa Quinn',
                'password' => Hash::make('password'),
                'role' => 'manager',
                'phone' => '(918) 555-0101',
            ]
        )->syncRoles(['manager']);

        User::query()->updateOrCreate(
            ['email' => 'crew@stoneborewell.com'],
            [
                'name' => 'Derek Holt',
                'password' => Hash::make('password'),
                'role' => 'staff',
                'phone' => '(918) 555-0102',
            ]
        )->syncRoles(['staff']);

        $settings = [
            'company_name' => 'Stonebore Well Co.',
            'company_phone' => '(918) 555-0147',
            'company_email' => 'hello@stoneborewell.com',
            'whatsapp' => '19185550147',
            'service_area' => 'Tulsa, Broken Arrow, Owasso, Claremore & Northeast Oklahoma',
            'tax_rate' => '8.5',
        ];
        foreach ($settings as $key => $value) {
            Setting::setValue($key, $value);
        }

        $products = [
            ['name' => '4" PVC Well Casing (20 ft)', 'sku' => 'WELL-CAS-4-20', 'category' => 'casing', 'unit_cost' => 85, 'unit_price' => 145, 'stock_qty' => 48],
            ['name' => '6" Steel Casing Joint', 'sku' => 'WELL-CAS-6-ST', 'category' => 'casing', 'unit_cost' => 160, 'unit_price' => 275, 'stock_qty' => 22],
            ['name' => 'Submersible Pump 1.5 HP', 'sku' => 'WELL-PMP-15', 'category' => 'pumps', 'unit_cost' => 420, 'unit_price' => 780, 'stock_qty' => 14],
            ['name' => 'Submersible Pump 3 HP', 'sku' => 'WELL-PMP-30', 'category' => 'pumps', 'unit_cost' => 690, 'unit_price' => 1180, 'stock_qty' => 8],
            ['name' => 'Pressure Tank 44 Gal', 'sku' => 'WELL-TNK-44', 'category' => 'tanks', 'unit_cost' => 210, 'unit_price' => 385, 'stock_qty' => 16],
            ['name' => 'Well Cap & Seal Kit', 'sku' => 'WELL-CAP-KIT', 'category' => 'fittings', 'unit_cost' => 38, 'unit_price' => 72, 'stock_qty' => 40],
            ['name' => 'Pitless Adapter Assembly', 'sku' => 'WELL-PIT-AD', 'category' => 'fittings', 'unit_cost' => 95, 'unit_price' => 175, 'stock_qty' => 18],
            ['name' => 'Water Test Sample Kit', 'sku' => 'WELL-TST-KIT', 'category' => 'testing', 'unit_cost' => 18, 'unit_price' => 45, 'stock_qty' => 60],
        ];
        foreach ($products as $product) {
            Product::query()->updateOrCreate(['sku' => $product['sku']], $product + ['unit' => 'ea', 'is_active' => true]);
        }

        $customers = collect([
            ['name' => 'Elena Briggs', 'email' => 'elena@example.com', 'phone' => '(918) 555-4401', 'company' => null, 'city' => 'Broken Arrow', 'state' => 'OK', 'zip' => '74012', 'address' => '8812 Aspen Ridge Rd'],
            ['name' => 'Cole Ramirez', 'email' => 'cole@ramirezranch.com', 'phone' => '(918) 555-4410', 'company' => 'Ramirez Cattle Co.', 'city' => 'Claremore', 'state' => 'OK', 'zip' => '74017', 'address' => '4100 Blue Stem Rd'],
            ['name' => 'Nadia Okonkwo', 'email' => 'facilities@riverbendcampus.com', 'phone' => '(918) 555-4499', 'company' => 'Riverbend Campus', 'city' => 'Tulsa', 'state' => 'OK', 'zip' => '74133', 'address' => '7200 Riverbend Blvd'],
            ['name' => 'Hank Mercer', 'email' => 'hank.mercer@example.com', 'phone' => '(539) 555-4188', 'company' => null, 'city' => 'Owasso', 'state' => 'OK', 'zip' => '74055', 'address' => '27 Prairie Hollow Ln'],
            ['name' => 'Sable Nguyen', 'email' => 'sable@greenvalleyhoa.org', 'phone' => '(918) 555-4177', 'company' => 'Green Valley HOA', 'city' => 'Tulsa', 'state' => 'OK', 'zip' => '74137', 'address' => '1900 Green Valley Dr'],
        ])->map(fn ($c) => Customer::query()->updateOrCreate(['email' => $c['email']], $c));

        $projects = [
            ['customer' => 0, 'title' => 'Residential well — 280 ft domestic', 'service_type' => 'residential', 'status' => 'scheduled', 'sq_ft' => 280, 'quoted_amount' => 14800],
            ['customer' => 1, 'title' => 'Livestock well + 3 HP pump', 'service_type' => 'agricultural', 'status' => 'in_progress', 'sq_ft' => 420, 'quoted_amount' => 26500],
            ['customer' => 2, 'title' => 'Campus backup groundwater well', 'service_type' => 'commercial', 'status' => 'quoted', 'sq_ft' => 510, 'quoted_amount' => 48900],
            ['customer' => 3, 'title' => 'Pump pull & pressure tank swap', 'service_type' => 'pump', 'status' => 'completed', 'sq_ft' => 0, 'quoted_amount' => 1850, 'final_amount' => 2120],
            ['customer' => 4, 'title' => 'Low-yield hydrofracturing rehab', 'service_type' => 'hydrofrac', 'status' => 'invoiced', 'sq_ft' => 310, 'quoted_amount' => 6200, 'final_amount' => 6450],
        ];

        $projectModels = [];
        foreach ($projects as $i => $p) {
            $customer = $customers[$p['customer']];
            $projectModels[] = Project::query()->updateOrCreate(
                ['job_number' => 'JOB-26'.str_pad((string) ($i + 1), 3, '0', STR_PAD_LEFT)],
                [
                    'customer_id' => $customer->id,
                    'title' => $p['title'],
                    'service_type' => $p['service_type'],
                    'status' => $p['status'],
                    'sq_ft' => $p['sq_ft'],
                    'quoted_amount' => $p['quoted_amount'],
                    'final_amount' => $p['final_amount'] ?? null,
                    'start_date' => now()->subDays(10 - $i)->toDateString(),
                    'site_address' => trim(($customer->address ?? '').', '.$customer->city.', '.$customer->state),
                    'notes' => 'Seeded demo job for Stonebore ERP. Depth stored in sq_ft field (feet).',
                ]
            );
        }

        foreach ([0, 1, 3, 4] as $idx) {
            $project = $projectModels[$idx];
            $invoice = Invoice::query()->updateOrCreate(
                ['invoice_number' => 'INV-26'.str_pad((string) ($idx + 1), 3, '0', STR_PAD_LEFT)],
                [
                    'customer_id' => $project->customer_id,
                    'project_id' => $project->id,
                    'issue_date' => now()->subDays(8 - $idx)->toDateString(),
                    'due_date' => now()->addDays(14)->toDateString(),
                    'subtotal' => $project->final_amount ?? $project->quoted_amount,
                    'tax' => round(($project->final_amount ?? $project->quoted_amount) * 0.085, 2),
                    'total' => round(($project->final_amount ?? $project->quoted_amount) * 1.085, 2),
                    'amount_paid' => in_array($project->status, ['completed', 'invoiced'], true) ? round(($project->final_amount ?? $project->quoted_amount) * 1.085, 2) : 0,
                    'status' => in_array($project->status, ['completed', 'invoiced'], true) ? 'paid' : 'sent',
                ]
            );

            if ($invoice->status === 'paid') {
                Payment::query()->updateOrCreate(
                    ['reference' => 'PMT-'.$invoice->invoice_number],
                    [
                        'invoice_id' => $invoice->id,
                        'amount' => $invoice->total,
                        'paid_at' => now()->subDays(3)->toDateString(),
                        'method' => 'card',
                        'notes' => 'Demo payment',
                    ]
                );
            }
        }

        Appointment::query()->updateOrCreate(
            ['title' => 'Site survey — Briggs acreage'],
            [
                'customer_id' => $customers[0]->id,
                'project_id' => $projectModels[0]->id,
                'type' => 'survey',
                'starts_at' => now()->addDays(2)->setTime(9, 0),
                'ends_at' => now()->addDays(2)->setTime(10, 30),
                'status' => 'scheduled',
                'location' => $customers[0]->address,
            ]
        );
        Appointment::query()->updateOrCreate(
            ['title' => 'Ranch well drill day'],
            [
                'customer_id' => $customers[1]->id,
                'project_id' => $projectModels[1]->id,
                'type' => 'drill',
                'starts_at' => now()->addDays(9)->setTime(7, 0),
                'ends_at' => now()->addDays(9)->setTime(17, 0),
                'status' => 'confirmed',
                'location' => $customers[1]->address,
            ]
        );

        $posts = [
            [
                'title' => 'How Deep Should a Domestic Well Be in Northeast Oklahoma?',
                'excerpt' => 'Depth depends on aquifer, not gossip — here is how Stonebore sets expectations before the first bit turns.',
                'cover' => 'https://images.unsplash.com/photo-1548839140-29a749e1cf4d?auto=format&fit=crop&w=1400&q=80',
                'body' => "Neighbors love to quote a single magic depth. Real wells vary with local geology, seasonal water tables, and yield targets.\n\nStonebore reviews nearby well logs when available, plans casing for the expected aquifer interval, and documents static and pumping levels after development. If your acreage needs reliable household pressure, start with a site survey — not a rumor from the next section road.",
            ],
            [
                'title' => 'Signs Your Submersible Pump Is Failing',
                'excerpt' => 'Short cycling, sandy water, and tripped breakers are early warnings — not quirks to ignore.',
                'cover' => 'https://images.unsplash.com/photo-1621905252507-b35492cc74b4?auto=format&fit=crop&w=1400&q=80',
                'body' => "A healthy well system should deliver steady pressure without hammering the tank or tripping breakers. Sand in fixtures, frequent pump starts, or a sudden drop in yield often point to a failing submersible, check valve, or tank pre-charge issue.\n\nStonebore diagnoses amperage draw and tank settings before recommending a pull. Replacing parts blindly costs more than a proper service call.",
            ],
            [
                'title' => 'When Hydrofracturing Makes Sense for Low-Yield Wells',
                'excerpt' => 'Stimulation is not a miracle — it is a targeted option for the right rock.',
                'cover' => 'https://images.unsplash.com/photo-1581092918056-0c4c3acd3789?auto=format&fit=crop&w=1400&q=80',
                'body' => "Hydrofracturing can open fractures and improve yield in suitable formations after standard development falls short. It is not a fix for every dry hole, and it should follow a clear evaluation of geology and existing casing.\n\nWe retest yield after stimulation so you can compare gallons-per-minute before and after — then decide on pump sizing with real numbers.",
            ],
        ];
        foreach ($posts as $post) {
            Post::query()->updateOrCreate(
                ['slug' => Str::slug($post['title'])],
                [
                    'title' => $post['title'],
                    'excerpt' => $post['excerpt'],
                    'body' => $post['body'],
                    'cover_image' => $post['cover'],
                    'is_published' => true,
                    'published_at' => now()->subDays(random_int(2, 20)),
                ]
            );
        }

        $articles = [
            ['category' => 'issues', 'title' => 'Pump short cycles every few minutes', 'body' => "1. Check pressure tank pre-charge (usually 2 PSI below cut-in).\n2. Inspect for a failed bladder or waterlogged tank.\n3. Verify check valve is holding.\n4. Look for leaks on the house side of the system.\n5. Measure pump amperage; schedule a pull if the motor is failing."],
            ['category' => 'issues', 'title' => 'Cloudy or sandy water after drilling', 'body' => "New wells often need extended development and clearing. Run the pump as directed, avoid drinking until bacteria tests pass, and call Stonebore if sand persists after the recommended clear-out period — screens or pump placement may need adjustment."],
            ['category' => 'guides', 'title' => 'Residential drill day timeline', 'body' => "Day 0: Confirm utilities, access path for the rig, and staging for casing.\nMorning: Mobilize, set up, begin drilling.\nMidday: Case and grout as required for the formation.\nAfternoon: Develop the well and record water levels.\nFollow-up: Install pump package, pressure tank, and disinfection; schedule water testing."],
            ['category' => 'guides', 'title' => 'How to prepare for a site survey', 'body' => "Mark preferred well locations and known septic/leach fields. Note power availability and gate codes. Share any prior well logs. Clear a path for the drill rig. Stonebore will assess access, discuss expected depth ranges, and provide a written estimate."],
            ['category' => 'admin', 'title' => 'Admin ERP quick start', 'body' => "Login at /admin with admin@example.com / password.\n1. Add customers in CRM.\n2. Create a Job/Project with depth (ft) and quote.\n3. Schedule appointments for survey/drill/pump service.\n4. Convert completed jobs to invoices and record payments.\n5. Use AI Studio for blog drafts and troubleshooting suggestions.\n6. Update company Settings for phone, WhatsApp, and tax rate."],
            ['category' => 'admin', 'title' => 'Roles: Admin, Manager, Staff', 'body' => "Admin: full ERP + settings + users.\nManager: jobs, inventory, invoices, scheduling.\nStaff: field-facing records and appointment updates.\nAssign roles on the Users resource."],
            ['category' => 'troubleshoot', 'title' => 'Job running over casing estimate', 'body' => "Compare actual depth vs quoted interval. Log extra casing joints on the job notes, create a change-order invoice line, and update inventory stock quantities for casing SKUs."],
            ['category' => 'troubleshoot', 'title' => 'Chatbot giving demo answers only', 'body' => "Demo mode is expected without API keys. Add OPENAI_API_KEY or GEMINI_API_KEY to .env, then clear config cache. The public chatbot and AI Studio will prefer live models when keys are present."],
        ];
        foreach ($articles as $article) {
            KnowledgeArticle::query()->updateOrCreate(
                ['slug' => Str::slug($article['title'])],
                [
                    'title' => $article['title'],
                    'category' => $article['category'],
                    'body' => $article['body'],
                    'is_published' => true,
                ]
            );
        }
    }
}
