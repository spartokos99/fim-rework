<?php

namespace Database\Seeders;

use App\Models\Asset;
use App\Models\Team;
use App\Models\TeamCategory;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Team + User
        $u = User::create([
            'name' => 'Nico',
            'email' => 'nbartokos@gmail.com',
            'password' => "\$2y\$12\$67Xcq30GQJxhbgQEjmxRvOtu8Ua81JFUHh4.hWt3lmdevK6.4R3BG",
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $t = Team::create([
            'name' => 'Team 01',
            'slug' => 'team-01',
            'description' => 'A team for testing purposes.',
            'owner_id' => 1,
            'color' => '#FF5733',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $t->members()->syncWithoutDetaching([$u->id]);

        // Category
        $c = TeamCategory::create([
            'team_id' => $t->id,
            'title' => 'Test Category',
            'slug' => 'test-category',
            'parent_id' => -1,
            'order' => 1,
            'prefix' => '🧪',
            'creator_id' => $u->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Assets
        $a = Asset::create([
            'team_id' => $t->id,
            'category_id' => $c->id,
            'creator_id' => $u->id,
            'title' => 'Test Asset 01',
            'slug' => 'test-asset-01',
            'description' => 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat.',
            'image' => 'assets/images/01KNQ53YWJ89ZAYYM0WQ74QQWZ.jpg',
            'publish_at' => now()->addDays(2),
            'hide_at' => null,
            'variants' => '[{"name":"Bag","quantity":10,"prices":[{"amount":1,"currency":"EUR","price":55},{"amount":10,"currency":"EUR","price":480}],"show_warning":true,"warning_level":5}]',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
