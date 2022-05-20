<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
//use App\Models\UploadedFiles;
use App\Models\FilesContent;
use App\Models\UploadedFiles;
use League\Csv\Reader;

class UploadCSV implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $file_id;
    public $filename;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($file_id,$filename)
    {
        $this->file_id = $file_id;
        $this->filename = $filename;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        /*
        $uploadFiles = new UploadedFiles;
        $uploadFiles->where()
        $uploadFiles->status = 1; // STATUS = 1 is PROCESSING
        $uploadFiles->update();
        */

        //load the CSV document from a file path
        $csv = Reader::createFromPath(storage_path('app\\files\\'.$this->filename), 'r');
        $csv->setHeaderOffset(0);

        $input_bom = $csv->getInputBOM();

        if ($input_bom === Reader::BOM_UTF16_LE || $input_bom === Reader::BOM_UTF16_BE) {
            $csv->addStreamFilter('convert.iconv.UTF-16/UTF-8');
        }

        foreach ($csv as $record){
            $upload = new FilesContent;
            if(!$upload->where('UNIQUE_KEY', '=', $record['UNIQUE_KEY'])->exists()){
                $upload->file_id = $this->file_id;
                $upload->UNIQUE_KEY = $record['UNIQUE_KEY'];
                $upload->PRODUCT_TITLE = $record['PRODUCT_TITLE'];
                $upload->PRODUCT_DESCRIPTION = $record['PRODUCT_DESCRIPTION'];
                $upload->STYLE = $record['STYLE#'];
                $upload->AVAILABLE_SIZES = $record['AVAILABLE_SIZES'];
                $upload->BRAND_LOGO_IMAGE = $record['BRAND_LOGO_IMAGE'];
                $upload->THUMBNAIL_IMAGE = $record['THUMBNAIL_IMAGE'];
                $upload->COLOR_SWATCH_IMAGE = $record['COLOR_SWATCH_IMAGE'];
                $upload->PRODUCT_IMAGE = $record['PRODUCT_IMAGE'];
                $upload->SPEC_SHEET = $record['SPEC_SHEET'];
                $upload->PRICE_TEXT = $record['PRICE_TEXT'];
                $upload->SUGGESTED_PRICE = $record['SUGGESTED_PRICE'];
                $upload->CATEGORY_NAME = $record['CATEGORY_NAME'];
                $upload->SUBCATEGORY_NAME = $record['SUBCATEGORY_NAME'];
                $upload->COLOR_NAME = $record['COLOR_NAME'];
                $upload->COLOR_SQUARE_IMAGE = $record['COLOR_SQUARE_IMAGE'];
                $upload->COLOR_PRODUCT_IMAGE = $record['COLOR_PRODUCT_IMAGE'];
                $upload->COLOR_PRODUCT_IMAGE_THUMBNAIL = $record['COLOR_PRODUCT_IMAGE_THUMBNAIL'];
                $upload->SIZE = $record['SIZE'];
                $upload->QTY = $record['QTY'];
                $upload->PIECE_WEIGHT = $record['PIECE_WEIGHT'];
                $upload->PIECE_PRICE = $record['PIECE_PRICE'];
                $upload->DOZENS_PRICE = $record['DOZENS_PRICE'];
                $upload->CASE_PRICE = $record['CASE_PRICE'];
                $upload->PRICE_GROUP = $record['PRICE_GROUP'];
                $upload->CASE_SIZE = $record['CASE_SIZE'];
                $upload->INVENTORY_KEY = $record['INVENTORY_KEY'];
                $upload->SIZE_INDEX = $record['SIZE_INDEX'];
                $upload->SANMAR_MAINFRAME_COLOR = $record['SANMAR_MAINFRAME_COLOR'];
                $upload->MILL = $record['MILL'];
                $upload->PRODUCT_STATUS = $record['PRODUCT_STATUS'];
                $upload->COMPANION_STYLES = $record['COMPANION_STYLES'];
                $upload->MSRP = $record['MSRP'];
                $upload->MAP_PRICING = $record['MAP_PRICING'];
                $upload->FRONT_MODEL_IMAGE_URL = $record['FRONT_MODEL_IMAGE_URL'];
                $upload->BACK_MODEL_IMAGE = $record['BACK_MODEL_IMAGE'];
                $upload->FRONT_FLAT_IMAGE = $record['FRONT_FLAT_IMAGE'];
                $upload->BACK_FLAT_IMAGE = $record['BACK_FLAT_IMAGE'];
                $upload->PRODUCT_MEASUREMENTS = $record['PRODUCT_MEASUREMENTS'];
                $upload->PMS_COLOR = $record['PMS_COLOR'];
                $upload->GTIN = $record['GTIN'];
                $upload->save();
            }else{
                $upload = FilesContent::where('UNIQUE_KEY', '=', $record['UNIQUE_KEY']);

                $upload->update([
                    'PRODUCT_TITLE' => $record['PRODUCT_TITLE'],
                    'PRODUCT_DESCRIPTION' => $record['PRODUCT_DESCRIPTION'],
                    'STYLE' => $record['STYLE#'],
                    'AVAILABLE_SIZES' => $record['AVAILABLE_SIZES'],
                    'BRAND_LOGO_IMAGE' => $record['BRAND_LOGO_IMAGE'],
                    'THUMBNAIL_IMAGE' => $record['THUMBNAIL_IMAGE'],
                    'COLOR_SWATCH_IMAGE' => $record['COLOR_SWATCH_IMAGE'],
                    'PRODUCT_IMAGE' => $record['PRODUCT_IMAGE'],
                    'SPEC_SHEET' => $record['SPEC_SHEET'],
                    'PRICE_TEXT' => $record['PRICE_TEXT'],
                    'SUGGESTED_PRICE' => $record['SUGGESTED_PRICE'],
                    'CATEGORY_NAME' => $record['CATEGORY_NAME'],
                    'SUBCATEGORY_NAME' => $record['SUBCATEGORY_NAME'],
                    'COLOR_NAME' => $record['COLOR_NAME'],
                    'COLOR_SQUARE_IMAGE' => $record['COLOR_SQUARE_IMAGE'],
                    'COLOR_PRODUCT_IMAGE' => $record['COLOR_PRODUCT_IMAGE'],
                    'COLOR_PRODUCT_IMAGE_THUMBNAIL' => $record['COLOR_PRODUCT_IMAGE_THUMBNAIL'],
                    'SIZE' => $record['SIZE'],
                    'QTY' => $record['QTY'],
                    'PIECE_WEIGHT' => $record['PIECE_WEIGHT'],
                    'PIECE_PRICE' => $record['PIECE_PRICE'],
                    'DOZENS_PRICE' => $record['DOZENS_PRICE'],
                    'CASE_PRICE' => $record['CASE_PRICE'],
                    'PRICE_GROUP' => $record['PRICE_GROUP'],
                    'CASE_SIZE' => $record['CASE_SIZE'],
                    'INVENTORY_KEY' => $record['INVENTORY_KEY'],
                    'SIZE_INDEX' => $record['SIZE_INDEX'],
                    'SANMAR_MAINFRAME_COLOR' => $record['SANMAR_MAINFRAME_COLOR'],
                    'MILL' => $record['MILL'],
                    'PRODUCT_STATUS' => $record['PRODUCT_STATUS'],
                    'COMPANION_STYLES' => $record['COMPANION_STYLES'],
                    'MSRP' => $record['MSRP'],
                    'MAP_PRICING' => $record['MAP_PRICING'],
                    'FRONT_MODEL_IMAGE_URL' => $record['FRONT_MODEL_IMAGE_URL'],
                    'BACK_MODEL_IMAGE' => $record['BACK_MODEL_IMAGE'],
                    'FRONT_FLAT_IMAGE' => $record['FRONT_FLAT_IMAGE'],
                    'BACK_FLAT_IMAGE' => $record['BACK_FLAT_IMAGE'],
                    'PRODUCT_MEASUREMENTS' => $record['PRODUCT_MEASUREMENTS'],
                    'PMS_COLOR' => $record['PMS_COLOR'],
                    'GTIN' => $record['GTIN']
                ]);
            }
        }

    }
}
