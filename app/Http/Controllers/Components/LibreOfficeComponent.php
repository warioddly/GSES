<?php


namespace App\Http\Controllers\Components;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use NcJoes\OfficeConverter\OfficeConverter;

class LibreOfficeComponent
{
    var $bin;
    var $filename;
    public function __construct($filename)
    {
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            $this->bin = 'soffice';
        } else {
            $this->bin = 'libreoffice7.2';
        }
        $this->filename = $filename;
    }

    public function convertToPdf(){
        $converter = new OfficeConverter($this->filename, null, $this->bin);
        $dirname = dirname($this->filename);
        $filename = pathinfo($this->filename, PATHINFO_FILENAME).'.pdf';
        $converter->convertTo($filename); //generates pdf file in same directory as test-file.docx

        return $dirname.'/'.$filename;
    }

    public function convertToTxt(){
        $converter = new OfficeConverter($this->filename, dirname($this->filename), $this->bin);
        $dirname = dirname($this->filename);
        $filename = pathinfo($this->filename, PATHINFO_FILENAME).'.txt';

        $converter->convertTo($filename); //generates pdf file in same directory as test-file.docx

        return $dirname.'/'.$filename;
    }
}
