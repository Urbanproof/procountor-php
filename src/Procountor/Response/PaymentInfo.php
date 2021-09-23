<?php

namespace Procountor\Procountor\Response;

use Procountor\Procountor\Interfaces\BankAccountInterface;
use Procountor\Procountor\Interfaces\PaymentInfoInterface;
use DateTime;
use stdClass;

class PaymentInfo extends AbstractResponse implements PaymentInfoInterface
{

    //['BANK_TRANSFER', 'DIRECT_DEBIT', 'DIRECT_PAYMENT', 'CLEARING', 'CREDIT_CARD_CHARGE', 'FOREIGN_PAYMENT', 'OTHER', 'CASH', 'DOMESTIC_PAYMENT_PLUSGIRO', 'DOMESTIC_PAYMENT_BANKGIRO', 'DOMESTIC_PAYMENT_CREDITOR', 'DKLMPKRE', 'NETS'],
    public function getPaymentMethod(): string
    {
        return $this->data->paymentMethod;
    }

    //Currency of the payment in ISO 4217 format. Example: EUR. ,
    public function getCurrency(): string
    {
        return $this->data->currency;
    }
    //Payment reference code. If specified, must be a valid reference code, if not specified the code will be automatically generated. The last digit is a check digit. ,
    public function getBankReferenceCode(): ?string
    {
        return $this->data->bankReferenceCode;
    }
    //Payment bank account. Not required if payment method is cash. ,
    public function getBankAccount(): ?BankAccountInterface
    {
        return new BankAccount($this->data->bankAccount);
    }
    //Payment due date. ,
    public function getDueDate(): DateTime
    {
        return new DateTime($this->data->dueDate);
    }
    //Currency exchange rate. Calculated as the amount of one unit of domestic currency in foreign currency. Only foreign currency payments should have a value other than 1.
    public function getCurrencyRate(): float
    {
        return $this->data->currencyRate;
    }
}
