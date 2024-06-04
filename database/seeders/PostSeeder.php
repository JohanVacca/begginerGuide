<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Post::create([
            'title' => 'Villavicencio sin agua',
            'body' => 'ola  soy jamesinforma estoy aki para informarles qu la ciudad de villavicencio sigue sin contar con serivico de acuedukto.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Post::create([
            'title' => 'Operasion jake',
            'body' => 'ola  soy jamesinforma estoy aki para informarles k hoy cayo grasias a las fuerzas armadas el hoy preso Codi alias culo susio',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
