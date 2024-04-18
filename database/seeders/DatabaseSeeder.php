<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin Kullanıcı Oluşturma
        $this->createAdminUser();
        $this->createModeratorUser();
        $this->createUserUser();
        // Gereken diğer seed işlemlerini burada başlatabilirsiniz
    }

    /**
     * Admin kullanıcı oluşturur ve kullanıcıya admin rolünü atar.
     */
    private function createAdminUser(): void
    {
        // Admin kullanıcı bilgileri
        $adminUser = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('admin123'),
        ]);

        Role::create([
            'user_id' => $adminUser->id,
            'role' => 'admin',
        ]);
    }

    private function createModeratorUser(): void
    {
        // Moderator kullanıcı bilgileri
        $moderatorUser = User::factory()->create([
            'name' => 'Moderator',
            'email' => 'mod@mod.com',
            'password' => bcrypt('mod123'),
        ]);

        Role::create([
            'user_id' => $moderatorUser->id,
            'role' => 'moderator',
        ]);
    }

    private function createUserUser(): void
    {
        // User kullanıcı bilgileri
        $userUser = User::factory()->create([
            'name' => 'User',
            'email' => 'user@user.com',
            'password' => bcrypt('user123'),
        ]);

        Role::create([
            'user_id' => $userUser->id,
            'role' => 'user',
        ]);

    }
}
