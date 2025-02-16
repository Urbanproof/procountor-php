<?php

namespace Procountor\Procountor\Response;

use Procountor\Procountor\Interfaces\Read\Transaction as TransactionRead;
use Procountor\Procountor\Collection\DimensionItemValueCollection;

class Transaction extends AbstractResponse implements TransactionRead
{
    //Unique identifier for the ledger transaction. Automatically generated by Procountor and present in the object returned. ,
    public function getId(): int
    {
        return $this->data->id;
    }

    //Transaction type. Depends on the transaction and the ledger account in question. Type REVERSING_ENTRY is used to indicate the first row of a ledger receipt for a specific logic on the UI. Typically, it represents a transaction for a balance sheet account. Note that ledger receipts with no transactions marked as reversing entries are possible. Type ENTRY is the general type for transactions. It can be used even on the first rows of ledger receipts. Type RECONCILIATION_ENTRY is used for getting the sum of transactions on a receipt to reconcile (to equal zero). Generally, all ledger receipts should reconcile. Procountor does not automatically create reconciliation entries for ledger receipts created or updated through the API. If VAT is used, a reconciliation row might be necessary due to remainders and rounding. For both REVERSING_ENTRY and RECONCILIATION_ENTRY transactions, vatStatus cannot be defined and vatPercent must be 0. Additionally, transactions of those types cannot be removed from a ledger receipt once created. = ['RECONCILIATION_ENTRY', 'REVERSING_ENTRY', 'ENTRY'],
    public function getTransactionType(): string
    {
        return $this->data->transactionType;
    }

    //Ledger account number for the transaction. Must be valid for the current Procountor environment. Use GET /coa to obtain the chart of accounts. ,
    public function getAccount(): string
    {
        return $this->data->account;
    }

    public function setAccount(string $account): self
    {
        $this->data->account = $account;
        return $this;
    }

    //Transaction accounting value. Scale: 2. ,
    public function getAccountingValue(): float
    {
        return $this->data->accountingValue;
    }

    //Transaction VAT percentage. Must be a percentage currently in use for the company. ,
    public function getVatPercent(): float
    {
        return $this->data->vatPercent;
    }

    //Transaction VAT type. = ['SALES', 'PURCHASE'],
    public function getVatType(): ?string
    {
        return $this->data->vatType ?? null;
    }

    //Transaction VAT status. This overrides the VAT status set for the parent ledger receipt. Use here the numeric parts of VAT status codes listed in "VAT defaults" in Procountor. For example, for VAT status code "vat_12", use value 12. The VAT status used must be enabled for the current receipt type (sales/purchase). ,
    public function getVatStatus(): ?int
    {
        return $this->data->vatStatus ?? null;
    }

    //Transaction description. Visible on ledger receipt printouts. Max length 255. ,
    public function getDescription(): ?string
    {
        return $this->data->description ?? null;
    }

    //Transaction balance code. Only available if the use balance sheet setting is enabled. Max length 255. ,
    public function getBalanceCode(): ?string
    {
        return $this->data->balanceCode ?? null;
    }

    //List of allocation ids related to the transaction. Only for GET cannot be modified through PUT or POST. ,
    public function getAllocations(): ?array
    {
        return $this->data->allocations ?? null;
    }

    //Partner id. Can be provided in Norwegian environments only. The given partner id must match a partner of type different than PERSON, existing in the current Procountor environment. ,
    public function getPartnerId(): ?int
    {
        return $this->data->partnerId ?? null;
    }

    //Values of dimension items associated with this transaction. The number of provided dimension items must be within the dimension max count defined by the purchased Procountor license. Provided dimension pairs (dimension id - item id) must be unique within the list provided. ,
    public function getDimensionItemValues(): ?DimensionItemValueCollection
    {
        if (empty($this->data->dimensionItemValues)) {
            return null;
        }

        return new DimensionItemValueCollection(...array_map(
            fn ($itemValue) => new DimensionItemValue($itemValue),
            $this->data->dimensionItemValues
        ));
    }

    //VAT deduction percentage for the transaction.
    public function getVatDeductionPercent(): ?float
    {
        return $this->data->vatDeductionPercent ?? null;
    }
}
