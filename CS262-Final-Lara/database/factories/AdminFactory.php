<?php

namespace Database\Factories;

use App\Models\Admin;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class AdminFactory extends Factory
{
    protected static ?string $password = null;

    protected $model = Admin::class;

    public function definition()
    {
        if (!self::$password) {
            self::$password = Hash::make('password'); // default password
        }

        return [
            'username' => $this->faker->userName(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => self::$password,
            'balance' => $this->faker->randomFloat(2, 0, 1000),  // random balance from 0.00 to 1000.00
            'profile_image' => null,
        ];
    }
}
