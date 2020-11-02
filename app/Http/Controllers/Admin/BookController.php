<?php

namespace App\Http\Controllers\Admin;

use App\AudioFile;
use App\Author;
use App\Book;
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
        dd($_FILES,$request->file('audio_files'));
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
        $book->delete();

        return redirect()->route('booksPage')
            ->with('success','Книга успешно удалена');
    }
}
