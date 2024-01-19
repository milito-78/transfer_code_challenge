<?php
namespace Tests\Unit;

use App\Entities\Enums\TransactionTypeEnums;
use App\Entities\TransactionEntity;
use App\Entities\UserCardEntity;
use App\Entities\UserEntity;
use App\Infrastructure\Database\Mysql\Models\Transaction;
use App\Infrastructure\Database\Mysql\Models\TransactionFee;
use App\Infrastructure\Database\Mysql\Models\User;
use App\Infrastructure\Database\Mysql\Models\UserCard;
use App\Infrastructure\Database\Mysql\TransactionRepository;
use App\Infrastructure\Database\Mysql\UserRepository;
use App\Infrastructure\Repositories\ITransactionRepository;
use App\Infrastructure\Repositories\IUserRepository;
use Database\Seeders\TransactionSeeder;
use Database\Seeders\UserAccountSeeder;
use Database\Seeders\UserCardSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Tests\TestCase;

class TransactionRepositoryTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test get balance for an account
     */
    public function test_find_get_balance(): void
    {
        /**
         * Seed database
         */
        $this->seed([UserSeeder::class,UserAccountSeeder::class,UserCardSeeder::class]);
        /**
         * @var Transaction $transaction
         */
        $transaction = Transaction::factory()->create([
            "type" => TransactionTypeEnums::Increase,
            "amount" => 100000
        ]);
        $transaction->load("card");

        /**
         * @var ITransactionRepository $repository
         */
        $repository = $this->app->make(TransactionRepository::class);

        $balance = $repository->getBalanceForAccount($transaction->card->account_id);
        $this->assertIsInt($balance);
        $this->assertNotEquals(0, $balance);
    }

    /**
     * Test create card transfer
     */
    public function test_create_card_transfer(): void
    {
        /**
         * Seed database
         */
        $this->seed([UserSeeder::class,UserAccountSeeder::class,UserCardSeeder::class]);
        /**
         * @var UserCard $origin
         */
        $origin = UserCard::query()->inRandomOrder()->first();
        Transaction::factory()->create([
            "type" => TransactionTypeEnums::Increase,
            "amount" => 100000,
            "card_id" => $origin->id
        ]);

        /**
         * @var UserCard $dest
         */
        $dest   = UserCard::query()->inRandomOrder()->where("id", "!=" , $origin->id)->first();
        $amount = 10000;

        /**
         * @var ITransactionRepository $repository
         */
        $repository = $this->app->make(TransactionRepository::class);

        $transaction = $repository->createTransferAmountByCard($origin->id,$origin->account_id,$amount,500,$dest->id,$dest->account_id);
        $this->assertNotNull($transaction);
        $this->assertInstanceOf(TransactionEntity::class, $transaction);
        $this->assertEquals($amount, $transaction->amount);
        $this->assertEquals(500, $transaction->fee);
        $this->assertEquals($amount-500, $transaction->pure_amount);
        $this->assertEquals($origin->id, $transaction->card_id);
        $this->assertEquals($dest->id, $transaction->dest_card_id);
        $this->assertNotNull($transaction->tracking_code);

        $this->assertDatabaseCount(Transaction::class,3);
        $this->assertDatabaseCount(TransactionFee::class,1);
        $this->assertDatabaseHas(TransactionFee::class,[
            "amount"            => 500,
            "transaction_id"    => $transaction->id
        ]);
    }

    /**
     * Test get transaction list
     */
    public function test_get_transaction_list(): void
    {
        /**
         * Seed database
         */
        $this->seed([UserSeeder::class,UserAccountSeeder::class,UserCardSeeder::class,TransactionSeeder::class]);
        $ids = UserCard::query()->get("id")->pluck("id")->toArray();

        /**
         * @var ITransactionRepository $repository
         */
        $repository = $this->app->make(TransactionRepository::class);

        $result = $repository->getTransactionsForUsersLimit($ids,10);
        $this->assertNotNull($result);
        $this->assertInstanceOf(Collection::class,$result);
        $this->assertNotEquals(0,$result->count());
    }

}
