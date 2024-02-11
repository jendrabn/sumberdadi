<?php

use App\Models\Community;
use App\Models\CommunityEvent;
use App\Models\CommunityEventAttendee;
use App\Models\CommunityMember;
use App\Models\CommunityRole;
use Illuminate\Database\Seeder;

class CommunitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CommunityRole::insert([
            ['name' => 'Member'],
            ['name' => 'Pengurus'],
            ['name' => 'Ketua'],
        ]);

        factory(Community::class, 5)->create();
        factory(CommunityMember::class, 100)->create();
        factory(CommunityEvent::class, 25)->create();
        factory(CommunityEventAttendee::class, 120)->create();
    }
}
