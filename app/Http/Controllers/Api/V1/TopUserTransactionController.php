<?php

namespace App\Http\Controllers\Api\V1;

use App\Entities\UserEntity;
use App\Http\Controllers\Controller;
use App\Services\Transactions\TransactionService;
use App\Services\Users\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;

class TopUserTransactionController extends Controller
{
    public function __construct(
        private readonly UserService $userService,
        private readonly TransactionService $transactionService,
    )
    {

    }

    /**
     * Get top users
     *
     * @return JsonResponse
     */
    public function topUsers(): \Illuminate\Http\JsonResponse
    {
        $users          = $this->userService->getTopThreeUser();
        $cards          = collect();

        $users->each(function (UserEntity $entity) use($cards){
            $cards->push(...$entity->cards->toArray());
        });

        $transactions   = $this->transactionService->getLimitTransactionsForUsers($cards->unique()->toArray(),10);

        $users->each(function (UserEntity $entity) use($transactions){
            $found          = $transactions->whereIn("card_id", $entity->cards->toArray());
            $entity->cards  = collect();
            $entity->transactions = $found->values();
        });

        return response()->json([
            "message" => "successful",
            "data" => $users
        ]);
    }
}
