<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $factory->define(User::class, function (Faker $faker) {
            $departments = Department::pluck('id');
            $sections = Section::pluck('id');
            $roles = ['employee', 'manager', 'head'];
            $usertypes = ['user', 'approval', 'admin'];
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'department_id' => $faker->randomElement($departments),
            'section_id' => $faker->randomElement($sections),
            'role' => $faker->randomElement($roles),
            'usertype' => $faker->randomElement($usertypes),
            'remember_token' => Str::random(10),
        ];
    });

    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
