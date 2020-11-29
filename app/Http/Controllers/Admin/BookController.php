<?php

namespace App\Http\Controllers\Admin;

use App\AudioFile;
use App\Author;
use App\Book;
use App\BookPages;
use App\BookToGenre;
use App\Favorite;
use App\Genre;
use App\Publisher;
use App\UserBook;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books = Book::query()->orderBy('created_at','desc')->get();

        return view('adminPanel.book.index', [
            'books' => $books,
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function book_pages(Request $request, $id)
    {
        $book_pages = BookPages::query()->where('book_id', $id);
        $book = Book::query()->find( $id);
        $status = $request->get('status');
        $pageNumber = $request->get('pageNumber');
        if(isset($status)){
            $book_pages->where('status',$request->get('status'));
        }
        if(isset($pageNumber)){
            $book_pages->where('page',$request->get('pageNumber'));
        }
        $book_pages = $book_pages->paginate(10);
        return view('adminPanel.book.book_pages', [
            'book_pages' => $book_pages,
            'book' => $book,
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit_book_pages(Request $request, $id)
    {
        $book_page = BookPages::query()->find($id);
        if($book_page->update([
            'status' => $request->get('status'),
            'content' => str_replace(['&nbsp;', '&ndash;'],[' ','–'],$request->get('content')),
        ])){
            return redirect()->route('booksPages',$book_page->book_id)
                ->with('success',"Страница {$book_page->page}  успешно обновлена");
        }

        return redirect()->route('booksPages',$book_page->book_id)
            ->with('error','Ошибка при изменения!');
    }

    public function remove_book_page(Request $request){
        $request->validate([
            'book_id' => 'required',
            'page' => 'required',
        ]);
        $page = $request->page;
        BookPages::query()
            ->where('book_id', $request->book_id)
            ->where('page','>=', $page)
            ->orderBy('page')
            ->each(function ($book_page) use ($page){
                /**
                 * @var BookPages $book_page
                 */
                if($page == $book_page->page){
                    $book_page->delete();
                }else{
                    $book_page->page --;
                    $book_page->save();
                }
            });
        return redirect()->route('booksPages',$request->book_id)
            ->with('success',"Страница {$page}  успешно удалена");
    }

    public function sort_audio(Request $request, $id){
        $ids= $request->get('audio_file_ids');
        AudioFile::query()->whereIn('id',$ids)->each(function ($file) use ($ids){
            $file->order = array_search($file->id,$ids);
            $file->save();
        });
        return response('OK',200);
    }

    public function remove_audio($id){
        $audioFile = AudioFile::query()->find($id);
        if($audioFile){
            if($book = Book::query()->find($audioFile->book_id)){
                $book->duration -= $audioFile->duration;
                $book->save();
            }
            $audioFile->removeAudioFile();
            $audioFile->delete();
        }
        return response('OK',200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $genres  = Genre::all();
        $authors = Author::all();
        $publishers = Publisher::all();

        return view('adminPanel.book.create', [
            'genres' => $genres,
            'authors' => $authors,
            'publishers' => $publishers
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $image_link = $request->file('image_link');
        $book_link = $request->file('book_link');
        $audio_files = $request->file('audio_files');

        if (null !== $image_link) {
            $extensionImage = $image_link->getClientOriginalExtension();
            Storage::disk('public')->put($image_link->getFilename().'.'.$extensionImage,  File::get($image_link));
        }

        if (null !== $book_link) {
            $extensionPdf = $book_link->getClientOriginalExtension();
            Storage::disk('public')->put($book_link->getFilename().'.'.$extensionPdf,  File::get($book_link));
        }


        $data = [
            'name'         => $request->name,
            'type' => $request->type,
            'preview_text' => $request->preview_text,
            'detail_text'  => $request->detail_text,
            'price'        => $request->price,
            'author_id'    => $request->author_id,
            'publisher_id' => $request->publisher_id,
            'background_color' => $request->background_color,
            'lang'         => $request->lang,
            'is_free'      => $request->is_free,
        ];

        if (null !== $image_link) {
            $data = array_merge($data, [
                'image_link'   => '/uploads/' . $image_link->getFilename() . '.' . $extensionImage,
            ]);
        }

        if (null !== $book_link) {
            $data = array_merge($data, [
                'book_link'    => '/uploads/' . $book_link->getFilename() . '.'. $extensionPdf,
            ]);
        }



        $book = Book::create($data);
        $duration = 0;
        if (null !== $audio_files) {
            include(base_path("libs/getid3/getid3.php"));
            foreach ($audio_files as $audio_file){
                $extensionAudio = $audio_file->getClientOriginalExtension();
                Storage::disk('public')->put($audio_file->getFilename().'.'.$extensionAudio,  File::get($audio_file));
                $file_name = '/uploads/' . $audio_file->getFilename() . '.' . $extensionAudio;
                $getID3 = new \getID3;
                $fileInfo = $getID3->analyze(public_path($file_name));
                $playtime_seconds = $fileInfo['playtime_seconds'];

                $file_duration = intval($playtime_seconds);
                $duration += $file_duration;

                $file = new AudioFile();
                $file->audio_link  = $file_name;
                $file->duration  = $file_duration;
                $file->book_id = $book->id;
                $file->file_size = $audio_file->getSize();
                $file->content_type = $audio_file->getClientMimeType();
                $file->original_name = $audio_file->getClientOriginalName();
                $file->title = ' ';
                $file->save();
            }
            $book->duration = $duration;
            $book->save();
        }

        if($request->genres){
            foreach ($request->genres as $genre_id){
                $link = new BookToGenre([
                    'book_id' => $book->id,
                    'genre_id' => $genre_id
                ]);
                $link->save();
            }
        }

        return redirect()->route('booksPage')
            ->with('success','Книга успешно добавлена.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function show(Book $book)
    {
        return view('adminPanel.book.show',compact('book'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function edit(Book $book)
    {
        $genres  = Genre::all();
        $authors = Author::all();
        $publishers = Publisher::all();
        return view('adminPanel.book.edit',[
            'book' => $book,
            'genres' => $genres,
            'authors' => $authors,
            'publishers' => $publishers
        ]);
    }

    public function loadAudioFiles($id){
        $data = [];
        AudioFile::query()->where('book_id',$id)->each(function ($file) use (&$data){
            $data[] = [
                'name' => $file->original_name,
                'path' => $file->audio_link,
                'size' => $file->file_size
            ];
        });
        return new JsonResponse($data,'200');
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Book $book)
    {
        $image_link = $request->file('image_link');
        $book_link = $request->file('book_link');
        $audio_files = $request->file('audio_files');

        if (null !== $image_link) {
            $extensionImage = $image_link->getClientOriginalExtension();
            Storage::disk('public')->put($image_link->getFilename().'.'.$extensionImage,  File::get($image_link));
        }

        if (null !== $book_link) {
            $extensionPdf = $book_link->getClientOriginalExtension();
            Storage::disk('public')->put($book_link->getFilename().'.'.$extensionPdf,  File::get($book_link));
        }

        $duration = $book->duration;
        if (null !== $audio_files) {
            include(base_path("libs/getid3/getid3.php"));
            foreach ($audio_files as $audio_file){
                $extensionAudio = $audio_file->getClientOriginalExtension();
                Storage::disk('public')->put($audio_file->getFilename().'.'.$extensionAudio,  File::get($audio_file));
                $file_name = '/uploads/' . $audio_file->getFilename() . '.' . $extensionAudio;
                $getID3 = new \getID3;
                $fileInfo = $getID3->analyze(public_path($file_name));
                $playtime_seconds = $fileInfo['playtime_seconds'];

                $file_duration = intval($playtime_seconds);
                $duration += $file_duration;
                $file = new AudioFile();
                $file->duration  = $file_duration;
                $file->audio_link  = $file_name;
                $file->book_id = $book->id;
                $file->file_size = $audio_file->getSize();
                $file->content_type = $audio_file->getClientMimeType();
                $file->original_name = $audio_file->getClientOriginalName();
                $file->title = ' ';
                $file->save();
            }
        }

        $data = [
            'name'         => $request->name,
            'preview_text' => $request->preview_text,
            'type' => $request->type,
            'duration' => $duration,
            'detail_text'  => $request->detail_text,
            'price'        => $request->price,
            'author_id'    => $request->author_id,
            'publisher_id' => $request->publisher_id,
            'background_color' => $request->background_color,
            'lang'         => $request->lang,
            'is_free'      => $request->is_free,
            'pdf_to_html'  => $request->pdf_to_html,
        ];

        if($request->generate_html){
            $data['pdf_hash'] = $request->generate_html;
        }

        if (null !== $image_link) {
            $data = array_merge($data, [
                'image_link'   => '/uploads/' . $image_link->getFilename() . '.' . $extensionImage,
            ]);
        }

        if (null !== $book_link) {
            $data = array_merge($data, [
                'book_link'    => '/uploads/' . $book_link->getFilename() . '.'. $extensionPdf,
            ]);
        }

        $audio_files = $request->get('audio_file_titles');
        if(!empty($audio_files) && is_array($audio_files)){
            AudioFile::query()->whereIn('id', array_keys($audio_files))->each(function ($file) use($audio_files){
                $data = $audio_files[$file->id];
                if(isset($data['title'])){
                    $file->title = $data['title'];
                    $file->save();
                }
            });
        }

        $book->update($data);

        BookToGenre::query()->where('book_id',$book->id)->delete();

        if($request->genres){
            foreach ($request->genres as $genre_id){
                $link = new BookToGenre([
                    'book_id' => $book->id,
                    'genre_id' => $genre_id
                ]);
                $link->save();
            }
        }

        return redirect()->route('booksPage')
            ->with('success','Книга успешно обновлена');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Book $book
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Book $book)
    {
        if($book->delete()){
            BookPages::query()->where(['book_id' => $book->id])->delete();
            Favorite::query()
                ->where(['object_type' => Favorite::FAVORITE_BOOK_TYPE, 'object_id' => $book->id])
                ->orWhere(['object_type' => Favorite::FAVORITE_AUDIO_BOOK_TYPE, 'object_id' => $book->id])
                ->delete();
            UserBook::query()->where('book_id', $book->id)->delete();
        }

        return redirect()->route('booksPage')
            ->with('success','Книга успешно удалена');
    }
}
