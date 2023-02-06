<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class PermissionRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Role::query()->firstOrCreate([
            'title' => 'ADMIN',
            'slug'  => 'admin'
        ]);
        Role::query()->firstOrCreate([
            'title' => 'USER',
            'slug'  => 'user'
        ]);

        //---------------- permission seeder by routes name
        $route_lists = Route::getRoutes()->getRoutesByName();
        foreach ($route_lists as $name => $route) {
            Permission::query()->firstOrCreate([
                'slug'  => $name,
                'title' => Str::upper(str_replace(['.', '-'], ' ', $name))
            ]);

        }
    }
}
