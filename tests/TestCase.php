<?php

namespace Tests;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function createUser(): User
    {
        $user = User::factory()->create();

        $user->createToken($user->name)->plainTextToken;

        return $user;
    }

    public function createUserRaw(): array
    {
        return User::factory()->raw();
    }

    public function createProductForUser(User $user): Product
    {
        return Product::factory()
            ->for($user)
            ->create();
    }

    public function getProductForUserRaw(User $user): array
    {
        return Product::factory()
            ->for($user)
            ->raw();
    }
}
