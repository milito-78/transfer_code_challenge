<?php

namespace App\Http\Controllers\Api\V1;

use App\Entities\UserCardEntity;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\TransferByCardRequest;
use App\Services\Transactions\TransactionService;
use App\Services\Users\UserService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class CardTransferController extends Controller
{
    public function __construct(
        private readonly UserService $userService,
        private readonly TransactionService $transactionService,
    )
    {
    }

    /**
     * Transfer amount by card
     * @param TransferByCardRequest $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function transferByCardToCard(TransferByCardRequest $request): \Illuminate\Http\JsonResponse
    {
        /**
         * @var UserCardEntity $origin
         */
        $origin         = $this->userService->getCardByCardNumber($request->get("origin_card_number"));
        /**
         * @var UserCardEntity $origin
         */
        $destination    = $this->userService->getCardByCardNumber($request->get("destination_card_number"));

        $amount         = $request->get("amount");



        if (!$this->transactionService->hasEnoughInAccount($origin->account_id,$amount)) {
            throw ValidationException::withMessages([
                "amount" => "You don't have enough amount "
            ]);
        }

        try {
            $transaction = $this->transactionService->transferAmountByCard($origin->account_id,$origin->id,$destination->account_id,$destination->id,$amount);
        }catch (Exception $exception){
            logger()->error("Error during transaction : " . $exception->getMessage(), ["context" => $exception, "request" => $request]);
            return response()->json([
                "message" => "There is a error during transaction. Please try again later."
            ],500);
        }

        //TODO send message
        return response()->json([
            "message" => "successfully done",
            "data" => [
                "tracking_code" => $transaction->tracking_code
            ]
        ],200);
    }
}
