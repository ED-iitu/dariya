<?php

namespace App\Http\Controllers\Admin;

use App\AudioFile;
use App\Author;
use App\Book;
use App\BookPages;
use App\BookToGenre;
use App\Genre;
use App\Publisher;
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
        $books = Book::all();

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
        $book_pages = $book_pages->paginate(100);
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
            'content' => $request->get('content'),
        ])){
            return redirect()->route('booksPages',$book_page->book_id)
                ->with('success',"Страница {$book_page->page}  успешно обновлена");
        }

        return redirect()->route('booksPages',$book_page->book_id)
            ->with('error','Ошибка при изменения!');
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



        Book::create($data);

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
        }

        return redirect()->route('booksPage')
            ->with('success','Книга успешно удалена');
    }
}
