<?php

namespace App\Jobs;

use App\Models\Document;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProcessDocumentJob implements ShouldQueue
{
    use Queueable, Dispatchable, InteractsWithQueue, SerializesModels;


    public int $tries = 3;
    public int $timeout = 10;
    public Document $document;

    /**
     * Create a new job instance.
     */
    public function __construct(Document $document)
    {
        $this->document = $document;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if ($this->document->status === 'processed') {
            return;
        }
        Log::info('Processing document', [
            'document_id' => $this->document->id,
        ]);

        sleep(5); // simulate heavy work 

        $this->document->update([
            'status' => 'processed',
        ]);

        Log::info('Document processed', [
            'document_id' => $this->document->id,
        ]);
    }
}
