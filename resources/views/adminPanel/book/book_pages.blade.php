@extends('layouts.admin-app')
@section('admin-content')
    <style>
        .edit{
            font-size: 10px;
        }
    </style>
    <div class="container">
        <div class="mt-3 mb-2">
            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
            @endif
            @if ($message = Session::get('error'))
                <div class="alert alert-danger">
                    <p>{{ $message }}</p>
                </div>
            @endif
        </div>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">Номер страниц</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <th colspan="2">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                Найти <a href="{{route('booksPages', $book->id)}}?status=0">Отключенных</a>/<a href="{{route('booksPages', $book->id)}}?status=1">Включенных</a>
                            </div>
                        </div>
                    </div>
                    <form action="">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <input type="text" class="input-text" name="pageNumber" placeholder="1">
                                <button type="submit">Показать страницу</button>
                            </div>
                        </div>
                    </form>
                </th>
            </tr>
            @foreach($book_pages as $book_page)
            <tr>
                <th scope="row">
                    Страница {{ $book_page->page }}
                    @if($book_page->status)
                        <span class="badge badge-success">Success</span>
                    @else
                        <span class="badge badge-secondary">Secondary</span>
                    @endif
                </th>
                <td>
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#book_{{ $book_page->book_id }}_page_{{ $book_page->page }}">
                        Просмотр
                    </button>
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#edit_book_{{ $book_page->book_id }}_page_{{ $book_page->page }}">
                        Изменить
                    </button>

                    <!-- Modal -->
                    <div class="modal fade" id="book_{{ $book_page->book_id }}_page_{{ $book_page->page }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">{{ $book_page->book->name }}. Станица {{ $book_page->page }}</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    {!! $book_page->content  !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Modal -->
                    <div class="modal fade" id="edit_book_{{ $book_page->book_id }}_page_{{ $book_page->page }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form name="form_edit_book_{{ $book_page->book_id }}_page_{{ $book_page->page }}" action="{{ route('editBooksPages', $book_page->id) }}" method="post">
                                    @csrf
                                    <div class="modal-header">
                                        <h5 class="modal-title">{{ $book_page->book->name }}. Станица {{ $book_page->page }}</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <label for="lang">Статус: </label>
                                                    <input type="radio" name="status" @if($book_page->status) checked @endif value="1"> вкл
                                                    <input type="radio" name="status" @if(!$book_page->status) checked @endif value="0"> откл
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <textarea name="content" class="tiny_editor" cols="30" rows="10">{!! $book_page->content  !!}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                                        <button type="submit" class="btn btn-primary">Сохранить</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
{{$book_pages->links()}}
    </div>
@endsection