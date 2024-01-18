<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class TransferByCardRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "origin_card_number"        => "required|string|card_number",
            "destination_card_number"   => "required|string|card_number|different:origin_card_number|exists:user_cards,card_number",
            "amount"                    => "required|gte:1000|lte:50000000"
        ];
    }


    protected function prepareForValidation(): void
    {
        $this->merge([
            "origin_card_number" => purifier_to_english($this->get("origin_card_number")),
            "destination_card_number" => purifier_to_english($this->get("destination_card_number")),
            "amount" => purifier_to_english($this->get("amount")),
        ]);
    }


}
