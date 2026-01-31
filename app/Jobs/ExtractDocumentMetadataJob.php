<?php

namespace App\Jobs;

use App\Models\Document;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ExtractDocumentMetadataJob implements ShouldQueue
{
    use Queueable, Dispatchable, InteractSWithQueue, SerializesModels ;
     

    public int $tries = 2;
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

       // simulate failure
       if (random_int(1, 3) === 1 ){
        throw new \Exception('Metadata extract fail');
       }


        Log::info('Extracting metadata for document', [
            'document_id' => $this->document->id,
        ]);

        sleep(3);

        Log::info('Metadata extracted for document', [
            'document_id' => $this->document->id,
        ]);
    }
}
