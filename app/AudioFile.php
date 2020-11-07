<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AudioFile extends Model
{
    protected $table = 'audio_files';

    protected $fillable = [
        'book_id', 'title', 'original_name', 'content_type', 'file_size', 'audio_link', 'order',
    ];

    public function removeAudioFile(){
        if(file_exists(base_path($this->audio_link))){
            unlink(base_path($this->audio_link));
        }
    }
}
