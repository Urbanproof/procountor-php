<?php

namespace Procountor\Procountor\Resources;

use Procountor\Procountor\Collection\InvoiceCollection;
use Procountor\Procountor\Interfaces\Read\Invoice as InvoiceIn;
use Procountor\Procountor\Response\Invoice as InvoiceOut;


class Invoices extends AbstractResourceRequest
{

    protected static string $apiPath = 'invoices';
    protected static string $interfaceIn = InvoiceIn::class;
    protected static string $interfaceOut = InvoiceOut::class;
    protected static string $collectionType = InvoiceCollection::class;

}
