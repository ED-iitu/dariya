<?php


namespace App\Helpers;


class PdfToHtml
{
    protected $file;

    protected $output_dir;

    public function __construct($options = [])
    {
        foreach ($options as $option=>$value){
            if(property_exists($this,$option)){
                $this->{$option} =$value;
            }
        }
    }

    public function parse(){
        dd($this->file);
    }
}