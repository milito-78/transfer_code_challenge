<?php
namespace Tests\Unit;

use App\Entities\UserCardEntity;
use App\Entities\UserEntity;
use App\Infrastructure\Database\Mysql\Models\User;
use App\Infrastructure\Database\Mysql\Models\UserCard;
use App\Infrastructure\Database\Mysql\UserRepository;
use App\Infrastructure\Repositories\IUserRepository;
use Database\Seeders\UserAccountSeeder;
use Database\Seeders\UserCardSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserRepositoryTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test find user by mobile
     */
    public function test_find_user_by_mobile(): void
    {
        /**
         * Seed database
         */
        $this->seed([UserSeeder::class,UserAccountSeeder::class,UserCardSeeder::class]);


        /**
         * @var User $seed
         */
        $seed = User::query()->first();

        /**
         * @var IUserRepository $repository
         */
        $repository = $this->app->make(UserRepository::class);

        $user = $repository->findUserByMobile($seed->mobile);
        $this->assertInstanceOf(UserEntity::class,$user);
        $this->assertNotNull($user);
        $this->assertEquals($user->mobile,$seed->mobile);
        $this->assertEquals($user->id,$seed->id);
    }

    /**
     * Test cannot find user by mobile
     */
    public function test_cannot_find_user_by_mobile(): void
    {
        /**
         * Seed database
         */
        $this->seed([UserSeeder::class,UserAccountSeeder::class,UserCardSeeder::class]);


        /**
         * @var IUserRepository $repository
         */
        $repository = $this->app->make(UserRepository::class);

        $user = $repository->findUserByMobile("not_a_mobile");
        $this->assertNull($user);
    }

    /**
     * Test find user by id
     */
    public function test_find_user_by_id(): void
    {
        /**
         * Seed database
         */
        $this->seed([UserSeeder::class,UserAccountSeeder::class,UserCardSeeder::class]);


        /**
         * @var User $seed
         */
        $seed = User::query()->first();

        /**
         * @var IUserRepository $repository
         */
        $repository = $this->app->make(UserRepository::class);

        $user = $repository->findUserById($seed->id);
        $this->assertInstanceOf(UserEntity::class,$user);
        $this->assertNotNull($user);
        $this->assertEquals($user->mobile,$seed->mobile);
        $this->assertEquals($user->id,$seed->id);
    }

    /**
     * Test cannot find user by id
     */
    public function test_cannot_find_user_by_id(): void
    {
        /**
         * Seed database
         */
        $this->seed([UserSeeder::class,UserAccountSeeder::class,UserCardSeeder::class]);


        /**
         * @var IUserRepository $repository
         */
        $repository = $this->app->make(UserRepository::class);

        $user = $repository->findUserById(0);
        $this->assertNull($user);
    }


    /**
     * Test find card by card_number
     */
    public function test_get_card_by_card_number(): void
    {
        /**
         * Seed database
         */
        $this->seed([UserSeeder::class,UserAccountSeeder::class,UserCardSeeder::class]);

        /**
         * @var IUserRepository $repository
         */
        $repository = $this->app->make(UserRepository::class);

        /**
         * @var UserCard $card
         */
        $card = UserCard::query()->with(["user","account"])->first();

        $found = $repository->getByCardNumber($card->card_number);
        $this->assertInstanceOf(UserCardEntity::class,$found);
        $this->assertNotNull($found);
        $this->assertEquals($found->card_number,$card->card_number);
        $this->assertEquals($found->id,$card->id);
        $this->assertEquals($found->id,$card->id);
        $this->assertEquals($found->user->id , $card->user->id);
    }

    /**
     * Test cannot find card by card_number
     */
    public function test_cannot_find_card()
    {
        /**
         * Seed database
         */
        $this->seed([UserSeeder::class,UserAccountSeeder::class,UserCardSeeder::class]);

        /**
         * @var IUserRepository $repository
         */
        $repository = $this->app->make(UserRepository::class);


        $user = $repository->getByCardNumber("not_a_number");
        $this->assertNull($user);
    }

}
