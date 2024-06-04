<?php

namespace Database\Seeders;

use App\Models\Comment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Comment::create([
            'post_id' => 1,
            'author' => 'anónimo',
            'text' => "eso es kulpa del perro hpta de petro tiene los de laprimera linea viviendo sabroso con piscina en suas casas",
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Comment::create([
            'post_id' => 2,
            'author' => 'mailo ríos',
            'text' => "de k les sirve cacturarlo si lo vamos aber en las calles la siguiente semana el alkalde se pasa la seguridad x las bolas",
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
