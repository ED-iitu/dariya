@extends('layouts.admin-app')
@section('admin-content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h2>Обновление жанра < {{ $page->title }} ></h2>
                </div>
                <div>
                    <a class="btn btn-primary" href="{{ route('pagesPage') }}"> Вернуться назад</a>
                </div>
            </div>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('page.update', $page->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row mt-5 p-3 bg-light text-dark">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <input type="text" value="{{ $page->title }} " name="title" class="form-control" placeholder="Название">
                    </div>
                </div>
            </div>
            <div id="page-blocks" class="row mt-3 mb-3 bg-light text-dark">
                <div class="container-fluid">
                    @foreach($page->data as $key=>$block)
                        @include('page.blocks.'.$block['type'], [$key,$block])
                    @endforeach
                </div>
            </div>
            <div class="row mt-3 p-3 bg-light text-dark">
                <div class="col-md-10">
                    <p>Добавьте блоки из списка</p>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modalBlocks"><i
                                class="fa fa-plus"></i> Добавить блок
                    </button>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-primary">Обновить</button>
            </div>
        </form>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="modalBlocksEdit" data-backdrop="static" data-keyboard="false" tabindex="-1"
         aria-labelledby="modalBlocksEditLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalBlocksEditLabel">Редкатирование блока</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">'
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="title">Заголовок</label>
                                <input type="text" value="" name="title" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="title">Текст</label>
                                <textarea type="text" value="" name="text" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="title">Изображение</label>
                                <input type="file" id="blocks-edit-image" name="image" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                    <button id="modal_save_edit_block" type="button" class="btn btn-primary">Сохранить</button>
                </div>
            </div>
        </div>
    </div>
    @include('page.template-modal')
@endsection