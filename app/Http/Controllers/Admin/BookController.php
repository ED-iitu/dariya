<?php

namespace App\Http\Controllers\Admin;

use App\Author;
use App\Book;
use App\Genre;
use App\Publisher;
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
        $request->validate([
            'image_link' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $image_link = $request->file('image_link');
        $book_link = $request->file('book_link');
        $extensionImage = $image_link->getClientOriginalExtension();
        $extensionPdf = $book_link->getClientOriginalExtension();
        Storage::disk('public')->put($book_link->getFilename().'.'.$extensionPdf,  File::get($book_link));
        Storage::disk('public')->put($image_link->getFilename().'.'.$extensionImage,  File::get($image_link));

        $data = [
            'name'         => $request->name,
            'preview_text' => $request->preview_text,
            'detail_text'  => $request->detail_text,
            'price'        => $request->price,
            'author_id'    => $request->author_id,
            'publisher_id' => $request->publisher_id,
            'lang'         => $request->lang,
            'is_free'      => $request->is_free,
            'book_link'    => '/uploads/' . $book_link->getFilename() . '.'. $extensionPdf,
            'image_link'   => '/uploads/' . $image_link->getFilename() . '.' . $extensionImage,
        ];

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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Book $book)
    {
        $request->validate([
            'name'         => 'required',
            'preview_text' => 'required',
            'detail_text'  => 'required',
            'price'        => 'required',
        ]);

        $book->update($request->all());

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
