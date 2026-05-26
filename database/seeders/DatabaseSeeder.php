<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Book;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::updateOrCreate(
            ['email' => 'admin@bookify.com'],
            [
                'name'     => 'Admin Bookify',
                'username' => 'admin',
                'phone'    => '081200000001',
                'email'    => 'admin@bookify.com',
                'password' => Hash::make('admin123'),
                'role'     => 'admin',
            ]
        );

        // Petugas
        User::updateOrCreate(
            ['email' => 'petugas@bookify.com'],
            [
                'name'     => 'Petugas Bookify',
                'username' => 'petugas',
                'phone'    => '081200000002',
                'email'    => 'petugas@bookify.com',
                'password' => Hash::make('petugas123'),
                'role'     => 'petugas',
            ]
        );

        // User biasa
        User::updateOrCreate(
            ['email' => 'user@bookify.com'],
            [
                'name'     => 'User Bookify',
                'username' => 'userbiasa',
                'phone'    => '081200000003',
                'email'    => 'user@bookify.com',
                'password' => Hash::make('user1234'),
                'role'     => 'user',
            ]
        );

        // Categories
        $categories = [
            'Fiksi',
            'Non-Fiksi',
            'Teknologi',
            'Sejarah',
            'Biografi',
            'Sains',
            'Pendidikan',
            'Agama',
        ];

        foreach ($categories as $categoryName) {
            Category::updateOrCreate(['name' => $categoryName]);
        }

        // Sample Books
        $books = [
            [
                'title' => 'Laskar Pelangi',
                'author' => 'Andrea Hirata',
                'category_id' => Category::where('name', 'Fiksi')->first()->id,
                'stock' => 5,
                'summary' => 'Novel tentang perjuangan anak-anak di Belitung untuk mendapatkan pendidikan.',
            ],
            [
                'title' => 'Bumi Manusia',
                'author' => 'Pramoedya Ananta Toer',
                'category_id' => Category::where('name', 'Fiksi')->first()->id,
                'stock' => 3,
                'summary' => 'Novel sejarah tentang kehidupan di masa kolonial Belanda.',
            ],
            [
                'title' => 'Clean Code',
                'author' => 'Robert C. Martin',
                'category_id' => Category::where('name', 'Teknologi')->first()->id,
                'stock' => 4,
                'summary' => 'Panduan menulis kode yang bersih dan mudah dipelihara.',
            ],
            [
                'title' => 'Sejarah Indonesia Modern',
                'author' => 'M.C. Ricklefs',
                'category_id' => Category::where('name', 'Sejarah')->first()->id,
                'stock' => 2,
                'summary' => 'Sejarah Indonesia dari masa kolonial hingga era reformasi.',
            ],
            [
                'title' => 'Steve Jobs',
                'author' => 'Walter Isaacson',
                'category_id' => Category::where('name', 'Biografi')->first()->id,
                'stock' => 3,
                'summary' => 'Biografi lengkap pendiri Apple Inc.',
            ],
        ];

        foreach ($books as $bookData) {
            Book::updateOrCreate(
                ['title' => $bookData['title']],
                $bookData
            );
        }
    }
}
