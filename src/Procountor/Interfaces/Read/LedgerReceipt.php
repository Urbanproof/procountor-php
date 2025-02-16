<?php

namespace Procountor\Procountor\Interfaces\Read;

use Procountor\Procountor\Interfaces\LedgerReceiptCommon;
use Procountor\Procountor\Collection\AttachmentCollection;

interface LedgerReceipt extends LedgerReceiptCommon
{

    /**
     * Unique identifier of the ledger receipt. Generated by Procountor and present in the object returned.
     *
     * @return null|int
     */
    public function getReceiptId(): ?int;

    /**
     * Ledger receipt VAT status. This can be overridden on transaction level.
     * Use here the numeric parts of VAT status codes listed in "VAT defaults" in Procountor.
     * For example, for VAT status code "vat_12", use value 12.
     * The VAT status used must be enabled for the current receipt type (sales/purchase).
     *
     * @return int
     */
    public function getVatStatus(): int;

    /**
     * ID of the linked invoice.
     * For sales and purchase invoice ledger receipts, this refers to the invoice the receipt holds accounting data for.
     * For journal receipts, an invoice is automatically generated to store certain data fields.
     * Use this ID in POST /attachments endpoint.
     * @see LedgerReceipt::getAttachments()
     *
     * @return null|int
     */
    public function getInvoiceId(): ?int;

    /**
     * Number of the linked invoice. Automatically generated by Procountor.
     *
     * @return int
     */
    public function getInvoiceNumber(): int;

    /**
     * List of attachments added to this receipt.
     * Use POST and DELETE /attachments to add and delete attachments
     * @see https://dev.procountor.com/api-reference/#operations-Attachments-saveAttachment
     * @see https://dev.procountor.com/api-reference/#operations-Attachments-deleteAttachment
     * @return null|AttachmentCollection
     */
    public function getAttachments(): ?AttachmentCollection;
}
