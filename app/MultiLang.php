<?php


namespace App;


trait MultiLang
{

    public function getLanguages(){
        return [
            'kz' => 'Казахский',
            'ru' => 'Руский'
        ];
    }

    public function getLangLabel(){
        if($this->lang){
            return (isset($this->getLanguages()[$this->lang])) ? $this->getLanguages()[$this->lang] : null;
        }
        return null;
    }
}