<?php

namespace Test;

use App\DTO\Request;
use App\DTO\Transaction;
use App\Services\RequestMoneyValidator;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class RequestMoneyValidatorTest extends TestCase
{
    #[DataProvider('dataProvider')]
    public function testValidate(
        Request $request,
        Transaction $transaction,
        float $deviation,
        bool $result
    ): void {
        $validator = new RequestMoneyValidator($deviation);

        $this->assertEquals($result, $validator->validate($request, $transaction));
    }

    public static function dataProvider(): array
    {
        $request1 = new Request();
        $request1->amount = 100;
        $request1->currency = 'USD';

        $transaction1 = new Transaction();
        $transaction1->amount = 90;
        $transaction1->currency = 'USD';

        $request2 = new Request();
        $request2->amount = 100;
        $request2->currency = 'USD';

        $transaction2 = new Transaction();
        $transaction2->amount = 97.54;
        $transaction2->currency = 'USD';

        return [
            [$request1, $transaction1, 0.1, true],
            [$request2, $transaction2, 0.01, false]
        ];
    }
}
