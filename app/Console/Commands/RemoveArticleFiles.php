<?php

namespace App\Console\Commands;

use App\Article;
use App\AudioFile;
use App\Banner;
use App\Book;
use App\BookShelf;
use App\Helpers\Formatter;
use App\Tariff;
use App\User;
use App\Video;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class RemoveArticleFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dariya:clear-extra-files';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove extra file in article,book';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $article_images = Article::query()->whereNotNull('image_link')->groupBy('image_link')->pluck('image_link')->map(function ($image_link){
            if($image_link){
                $image_link = substr($image_link,1);
                if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
                    $image_link = str_replace('/','\\', $image_link);
                }
                return public_path($image_link);
            }
            return null;
        })->toArray();

        $book_images = Book::query()->whereNotNull('image_link')->groupBy('image_link')->pluck('image_link')->map(function ($image_link){
            if($image_link){
                $image_link = substr($image_link,1);
                if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
                    $image_link = str_replace('/','\\', $image_link);
                }
                return public_path($image_link);
            }
            return null;
        })->toArray();

        $book_pdf_files = Book::query()->whereNotNull('book_link')->groupBy('book_link')->pluck('book_link')->map(function ($book_link){
            if($book_link){
                $book_link = substr($book_link,1);
                if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
                    $book_link = str_replace('/','\\', $book_link);
                }
                return public_path($book_link);
            }
            return null;
        })->toArray();

        $book_audio_files = AudioFile::query()->whereNotNull('audio_link')->groupBy('audio_link')->pluck('audio_link')->map(function ($audio_link){
            if($audio_link){
                $audio_link = substr($audio_link,1);
                if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
                    $audio_link = str_replace('/','\\', $audio_link);
                }
                return public_path($audio_link);
            }
            return null;
        })->toArray();

        $video_images = Video::query()->whereNotNull('image_link')->groupBy('image_link')->pluck('image_link')->map(function ($image_link){
            if($image_link){
                $image_link = substr($image_link,1);
                if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
                    $image_link = str_replace('/','\\', $image_link);
                }
                return public_path($image_link);
            }
            return null;
        })->toArray();

        $video_files = Video::query()->whereNotNull('local_video_link')->groupBy('local_video_link')->pluck('local_video_link')->map(function ($local_video_link){
            if($local_video_link){
                $local_video_link = substr($local_video_link,1);
                if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
                    $local_video_link = str_replace('/','\\', $local_video_link);
                }
                return public_path($local_video_link);
            }
            return null;
        })->toArray();

        $banner_images = Banner::query()->whereNotNull('file_url')->groupBy('file_url')->pluck('file_url')->map(function ($file_url){
            if($file_url){
                $file_url = substr($file_url,1);
                if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
                    $file_url = str_replace('/','\\', $file_url);
                }
                return public_path($file_url);
            }
            return null;
        })->toArray();

        $tariff_images = Tariff::query()->whereNotNull('image_url')->groupBy('image_url')->pluck('image_url')->map(function ($image_url){
            if($image_url){
                $image_url = substr($image_url,1);
                if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
                    $image_url = str_replace('/','\\', $image_url);
                }
                return public_path($image_url);
            }
            return null;
        })->toArray();

        $profile_images = User::query()->whereNotNull('profile_photo_path')->groupBy('profile_photo_path')->pluck('profile_photo_path')->map(function ($profile_photo_path){
            if($profile_photo_path){
                if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
                    $profile_photo_path = str_replace('/','\\', $profile_photo_path);
                }
                return public_path($profile_photo_path);
            }
            return null;
        })->toArray();

        $book_shelf_images = BookShelf::query()->whereNotNull('image_url')->groupBy('image_url')->pluck('image_url')->map(function ($image_url){
            if($image_url){
                if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
                    $image_url = str_replace('/','\\', $image_url);
                }
                return public_path($image_url);
            }
            return null;
        })->toArray();

        $need_files = array_merge($article_images, $book_images, $book_pdf_files, $book_audio_files, $video_images, $video_files, $banner_images, $tariff_images, $profile_images, $book_shelf_images);
        $upload_files = File::files(public_path('uploads'));

        $bar = $this->output->createProgressBar(count($upload_files));

        $i = 0;
        $extra_files = [];
        $extra_file_size = 0;
        foreach ($upload_files as $file){
            $real_path = $file->getRealPath();
            if(!in_array($real_path, $need_files)){
               $i++;
               $extra_files[] = $real_path;
               $extra_file_size += $file->getSize();
            }
        }
        $upload_profile_files_dirs = File::directories(public_path('uploads/profile'));
        foreach ($upload_profile_files_dirs as $user_dir){
            $upload_profile_files = File::files($user_dir);
            foreach ($upload_profile_files as $profile_file){
                $real_path = $profile_file->getRealPath();
                if(!in_array($real_path, $need_files)){
                    $i++;
                    $extra_files[] = $real_path;
                    $extra_file_size += $file->getSize();
                }
            }
        }

        $upload_book_shelf_files_dirs = File::directories(public_path('uploads/book_shelfs'));
        foreach ($upload_book_shelf_files_dirs as $user_dir){
            $upload_book_shelf_files = File::files($user_dir);
            foreach ($upload_book_shelf_files as $book_shelf_file){
                $real_path = $book_shelf_file->getRealPath();
                if(!in_array($real_path, $need_files)){
                    $i++;
                    $extra_files[] = $real_path;
                    $extra_file_size += $file->getSize();
                }
            }
        }
        $upload_book_shelf_files = File::files(public_path('uploads/book_shelfs'));
        foreach ($upload_book_shelf_files as $book_shelf_file){
            $real_path = $book_shelf_file->getRealPath();
            if(!in_array($real_path, $need_files)){
                $i++;
                $extra_files[] = $real_path;
                $extra_file_size += $file->getSize();
            }
        }
        $bar->finish();
        $extra_file_size = Formatter::bytesToHuman($extra_file_size);
        $this->info("\nНайдено всего лишний файлов: {$i} с размером {$extra_file_size}");
        if ($this->confirm('Хотите удалить их?')) {
            $s = 0;
            foreach ($extra_files as $file_path){
                if(unlink($file_path)){
                    $s++;
                    $this->info("\nФайл {$file_path} удален!");
                }else{
                    $this->error("\nОшибка при удаление файла: $file_path");
                }
            }
            $count = count($extra_files);
            $this->info("\nВсего лишний файлов {$s} из {$count}");
        }
        return 0;
    }
}
