@extends('layouts.admin')
@section('title', 'Создать категорию')
@section('content')
    <h2>Добавить категорию</h2>
    <div class="row">

        <div class="col-md-6">
            <!--begin::Quick Example-->
            <div class="card card-primary card-outline mb-4">
                <!--begin::Header-->
                <div class="card-header">
                    <div class="card-title">Новая категория</div>
                </div>

                <form method="POST" action="{{ route('category.store') }}">
                    @csrf
                    <!--begin::Body-->
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="title" class="form-label">Название категории</label>
                            <input type="text"  name="title" class="form-control" id="title" />

                        </div>
                        <div class="mb-3">
                            <label for="description"  class="form-label">Описание</label>
                            <input type="text" name="description" class="form-control" id="description" />
                        </div>
                        <div class="input-group mb-3">
                            <input type="file" class="form-control" id="image" name="image"/>
                            <label class="input-group-text" for="image">Изображение</label>
                        </div>

                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Добавить</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
@endsection
