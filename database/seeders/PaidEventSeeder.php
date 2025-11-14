<?php

namespace Database\Seeders;

use App\Models\PaidEvent;
use Illuminate\Database\Seeder;

class PaidEventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Creating Paid Events...');

        // Create 20 paid events with variety
        $paidEvents = collect();

        // Create 10 published events (open for registration)
        $publishedEvents = PaidEvent::factory(10)->create([
            'status' => 'published',
            'registration_start_time' => now()->subDays(5),
            'registration_deadline' => now()->addDays(15),
        ]);
        $paidEvents = $paidEvents->merge($publishedEvents);

        // Create 5 draft events
        $draftEvents = PaidEvent::factory(5)->create([
            'status' => 'draft',
        ]);
        $paidEvents = $paidEvents->merge($draftEvents);

        // Create 5 closed events
        $closedEvents = PaidEvent::factory(5)->create([
            'status' => 'closed',
            'registration_deadline' => now()->subDays(5),
        ]);
        $paidEvents = $paidEvents->merge($closedEvents);

        $this->command->info('✅ Paid Events seeded successfully!');
        $this->command->info("   - {$paidEvents->count()} Paid Events created");
    }
}
