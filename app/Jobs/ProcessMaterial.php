<?php

namespace App\Jobs;

use App\Helpers\AppHelper;
use App\Http\Controllers\Components\LibreOfficeComponent;
use App\Models\Document;
use App\Models\Material;
use App\Models\MaterialImage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use romanzipp\QueueMonitor\Traits\IsMonitored;

class ProcessMaterial implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, IsMonitored;

    public $timeout = 600;

    /**
     * Экземпляр подкаста.
     *
     * @var \App\Models\Material
     */
    protected $material_id;

    protected $method;
    protected $old_images = array();

    /**
     * Create a new job instance.
     *
     * @param  string  $method
     * @param  int|null  $material_id
     * @param  array  $old_images
     * @return void
     */
    public function __construct(string $method, int $material_id = null, $old_images = array())
    {
        $this->material_id = $material_id;
        $this->method = $method;
        $this->old_images = $old_images;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->queueProgress(0);
        $material = Material::find($this->material_id);
        if ($this->method == 'updating') {
            Log::debug('Solr start');
            foreach ($this->old_images as $image_id) {
                $image = Document::find($image_id);
                AppHelper::solrDeleteImage($image->id, $image->extension);
                Log::debug('Solr deleted image: '.$image->id);
            }
            Log::debug('Solr end');
        }
        elseif ($this->method == 'deleted') {
            Log::debug('Solr start');
            AppHelper::solrDeleteDocument($this->material_id);

            Log::debug('Solr deleted document: '.$material->id);

            $this->queueProgress(50);

            foreach ($this->old_images as $image_id) {
                $image = Document::find($image_id);
                AppHelper::solrDeleteImage($image->id, $image->extension);
                Log::debug('Solr deleted image: '.$image->id);
            }
            Log::debug('Solr end');
        }
        elseif ($material) {
            /**
             * @var Document $file
             */
            $file = $material->file()->first();
            if ($file) {
                Log::debug('Solr start');
                $content = fopen($file->getRealPath(), 'r');

                // Changed to extracting before add/edit with ajax. Delete this later
                // $material->file_text = AppHelper::solrExtractText($content, $file->name);
                // $material->save();

                // Indexing to solr
                AppHelper::solrAddDocument($content, $file->name, $material->id);
                Log::debug('Solr indexed document: '.$material->id);

                $this->queueProgress(10);

                if ($file->isWord()) {
                    $convert = new LibreOfficeComponent($file->getRealPath());
                    $filename = $convert->convertToPdf();
                    $file_id = AppHelper::saveDocument($filename, 'analyzes', $file->creator_id);
                    $file = Document::find($file_id);
                    $content = fopen($file->getRealPath(), 'r');
                }

                if ($file->isPdf()) {
                    $images = AppHelper::extractImages($content, $file->name);
                    Log::debug('Solr extracted images: '.count($images));
                    foreach ($images as $image) {
                        $image_id = AppHelper::saveDocument($image, 'materials', $file->creator_id);
                        $material->images()->attach($image_id);
                    }
                    $this->queueProgress(50);
                    foreach ($material->images()->get()->all() as $image){
                        $image_content = fopen($image->getRealPath(), 'r');
                        AppHelper::solrAddImage($image_content, $image->name, $image->id);
                        Log::debug('Solr indexed image: '.$image->id);
                    }
                } elseif ($file->isImage()) {
                    AppHelper::solrAddImage($content, $file->name, $file->id);
                    Log::debug('Solr indexed main image: '.$file->id);
                }
                Log::debug('Solr end');
            }
        }
        $this->queueProgress(100);
    }
}
