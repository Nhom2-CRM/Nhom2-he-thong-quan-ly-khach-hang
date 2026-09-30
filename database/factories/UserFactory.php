<?php
namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
class UserFactory extends Factory
{
 public function definition(): array { return ['name'=>fake()->name(),'email'=>fake()->unique()->safeEmail(),'password'=>Hash::make('Password123'),'business_group'=>'Nhóm A','role'=>'sales','status'=>'active','activated_at'=>now(),'remember_token'=>Str::random(10)]; }
}
