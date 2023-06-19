<?php

namespace Database\Factories;

use App\Models\Buku;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pengajuan>
 */
class PengajuanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_buku' => fake()->randomElement(Buku::pluck('id')),
            'id_user' => fake()->randomElement(User::pluck('id')),
            'tanggal_peminjaman' => fake()->dateTimeBetween('now', '+6 days'),
            'tanggal_pengembalian' => fake()->dateTimeBetween('+1 week', '+2 week'),
            'status' => fake()->randomElement(["pending", "approved", "rejected", "returned"])
        ];
    }
}
