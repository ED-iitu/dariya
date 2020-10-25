<?php


namespace App\Helpers;


class Share extends \Jorenvh\Share\Share
{
    /**
     * Vk share link
     *
     * @return \Jorenvh\Share\Share
     */
    public function vk()
    {
        $url = config('laravel-share.services.vk.uri') . $this->url;
        $url = $url . '&title=' . urlencode($this->title);
        $this->buildLink('vk', $url);

        return $this;
    }
}