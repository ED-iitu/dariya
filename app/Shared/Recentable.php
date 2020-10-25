<?php


namespace App\Shared;


use Illuminate\Database\Eloquent\Collection;

trait Recentable
{
    public function setAsRecent(){
        $session_name = $this->getTable().'_recently_viewed';
        $recently_viewed = session()->get($session_name);
        if(!$recently_viewed || (count($recently_viewed) < 5 && !in_array($this->getKey(), $recently_viewed))){
            session()->push($session_name, $this->getKey());
        }elseif (count($recently_viewed) == 5 && !in_array($this->getKey(), $recently_viewed)){
            array_shift($recently_viewed);
            array_push($recently_viewed, $this->getKey());
            session([$session_name => $recently_viewed]);
        }
    }

    public function getRecents(){
        $session_name = $this->getTable().'_recently_viewed';
        $recently_viewed = session()->get($session_name);
        return $recently_viewed;
    }

    public static function recents(){
        if(with(new self())->getRecents()){
            //dd(with(new self())->getRecents());
            return self::class()::query()->findMany(with(new self())->getRecents());
        }
        return new Collection();
    }

    public static function class(){
        return get_called_class();
    }
}