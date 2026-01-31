<?php

namespace App\Listeners;

use App\Events\DocumentUploaded;
use App\Jobs\ExtractDocumentMetadataJob;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Jobs\ProcessDocumentJob;
use Illuminate\Queue\InteractsWithQueue;

class StartDocumentProcessing
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(DocumentUploaded $event): void
    {
        ProcessDocumentJob::dispatch($event->document);
        ExtractDocumentMetadataJob::dispatch($event->document);
    }
}
