<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder {

  /**
   * Seed the application's database.
   */
  public function run(): void {
    DB::statement('SET FOREIGN_KEY_CHECKS=0;');
    DB::table('users')->truncate();
    DB::statement('SET FOREIGN_KEY_CHECKS=1;');

    User::factory()->create([
        'name' => 'Rejoanul Alam',
        'password' => Hash::make('123456'),
        'email' => 'rejoanul.alam@gmail.com',
    ]);
  }
}
