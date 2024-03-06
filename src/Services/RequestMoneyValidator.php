<?php

declare(strict_types=1);

namespace App\Services;

use App\DTO\Request;
use App\DTO\Transaction;

class RequestMoneyValidator
{
    public function __construct(protected float $deviation)
    {
    }

    public function validate(Request $request, Transaction $transaction): bool
    {
        return $this->validateCurrency($request->currency, $transaction->currency)
            && $this->validateDeviation($request->amount, $transaction->amount);
    }

    private function validateCurrency(string $requestCurrency, string $transactionCurrency): bool
    {
        return strtolower($requestCurrency) === strtolower($transactionCurrency);
    }

    private function validateDeviation(float $requestAmount, float $transactionAmount): bool
    {
        return bccomp(
            number_format(1 - $this->deviation, 2),
            number_format($transactionAmount/$requestAmount, 2),
            2
            ) >= 0;
    }
}