<?php

namespace Tests\Unit\Repositories;

use App\Http\Repositories\User\UserRepository;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected $userRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->userRepository = new UserRepository(new User);
    }

    public function testFindByEmailReturnsUserWhenEmailExists()
    {
        $user = User::factory()->create(['email' => 'test@example.com']);
        $foundUser = $this->userRepository->findByEmail('test@example.com');
        $this->assertEquals($user->id, $foundUser->id);
    }

    public function testFindByEmailReturnsNullWhenEmailDoesNotExist()
    {
        $foundUser = $this->userRepository->findByEmail('nonexistent@example.com');
        $this->assertNull($foundUser);
    }

    public function testFindByDocumentReturnsUserWhenDocumentExists()
    {
        $user = User::factory()->create(['document' => '123456789']);
        $foundUser = $this->userRepository->findByDocument('123456789');
        $this->assertEquals($user->id, $foundUser->id);
    }

    public function testFindByDocumentReturnsNullWhenDocumentDoesNotExist()
    {
        $foundUser = $this->userRepository->findByDocument('987654321');
        $this->assertNull($foundUser);
    }

    public function testFindByAccountReturnsUserWhenAccountExists()
    {
        $user = User::factory()->create();
        $user->account()->create(['account' => '12345', 'digit' => '6']);
        $foundUser = $this->userRepository->findByAccount('12345', '6');
        $this->assertEquals($user->id, $foundUser->id);
    }

    public function testFindByAccountReturnsNullWhenAccountDoesNotExist()
    {
        $foundUser = $this->userRepository->findByAccount('54321', '6');
        $this->assertNull($foundUser);
    }

    public function testFindUserWithAccountReturnsUserWithAccountWhenIdExists()
    {
        $user = User::factory()->create();
        $user->account()->create(['account' => '12345', 'digit' => '6']);
        $foundUser = $this->userRepository->findUserWithAccount($user->id);
        $this->assertEquals($user->id, $foundUser->id);
        $this->assertNotNull($foundUser->account);
    }

    public function testFindUserWithAccountReturnsNullWhenIdDoesNotExist()
    {
        $foundUser = $this->userRepository->findUserWithAccount(999);
        $this->assertNull($foundUser);
    }
}
