<?php


use Illuminate\Support\Carbon;

if (!function_exists("purifier_to_english")){
    function purifier_to_english(?string $value) : string{
        if (!$value)
            return "";
        $enNumbers = range(0, 9);
        // 1. Persian decimal
        $persianDecimal = array('&#1776;', '&#1777;', '&#1778;', '&#1779;', '&#1780;', '&#1781;', '&#1782;', '&#1783;', '&#1784;', '&#1785;');
        // 2. Arabic decimal
        $arabicDecimal = array('&#1632;', '&#1633;', '&#1634;', '&#1635;', '&#1636;', '&#1637;', '&#1638;', '&#1639;', '&#1640;', '&#1641;');
        // 3. Arabic Numeric
        $arabic = array('٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩');
        // 4. Persian Numeric
        $persian = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹');

        $string =  str_replace($persianDecimal, $enNumbers, $value);
        $string =  str_replace($arabicDecimal, $enNumbers, $string);
        $string =  str_replace($arabic, $enNumbers, $string);
        return str_replace($persian, $enNumbers, $string);
    }
}

if (!function_exists("is_card_number_valid")){
    function is_card_number_valid($cardNumber): bool
    {
        if(empty($cardNumber) || strlen($cardNumber) !== 16) {
            return false;
        }
        $cardToArr = str_split($cardNumber);
        $cardTotal = 0;
        for($i = 0; $i<16; $i++) {
            $c = (int)$cardToArr[$i];
            if($i % 2 === 0) {
                $cardTotal += (($c * 2 > 9) ? ($c * 2) - 9 : ($c * 2));
            } else {
                $cardTotal += $c;
            }
        }
        return ($cardTotal % 10 === 0);
    }
}


if (! function_exists("resourceDateTimeFormat")){
    function resourceDateTimeFormat(Carbon $time = null): string
    {
        return (! is_null($time)) ? $time->toDateTimeString() : Carbon::now();
    }
}



if (!function_exists("logError")){
    function logError($error , string $message = "" , array $data  = [] , string $step = ""): void
    {
        $step = $step != "" ? $step : "#1";
        $message = $step . " "  . ($message != "" ? $message : "Error : " .$error->getMessage());
        $data = count($data) ? $data : ["exception" => $error];

        logger()->error(  $message, $data);
    }
}


if (!function_exists("json_created")){
    function json_created(string $message,mixed $data): \Illuminate\Http\JsonResponse{
        return response()->json([
            "message" => $message,
            "data" => $data
        ],201);
    }
}

if (!function_exists("json_success")){
    function json_success(string $message,mixed $data): \Illuminate\Http\JsonResponse{
        return response()->json([
            "message" => $message,
            "data" => $data
        ]);
    }
}

if (!function_exists("json_error")){
    function json_error(string $message,$status,mixed $data = null): \Illuminate\Http\JsonResponse{
        $response = [
            "message" => $message,
        ];
        if ($data)
            $response["data"] = $data;

        return response()->json($response,$status);
    }
}
