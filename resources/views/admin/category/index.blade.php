@extends('layouts.admin')
@section('title', 'Все категории')

@section('content')
<div class="container-fluid mt-4">
  <div class="row">
    <div class="col-12">
      <div class="card shadow-sm">
        <div class="card-header">
          <h3 class="card-title">Список категорий</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body table-responsive p-0">
          <table class="table table-hover text-nowrap table-bordered align-middle">
            <thead class="table-dark">
              <tr>
                <th style="width: 50px">#</th>
                <th>Название</th>
                <th>Описание</th>
                <th>Slug</th>
                <th style="width: 150px">Действия</th>
              </tr>
            </thead>
            <tbody>
                @foreach($categories as $category)
              <tr>
                <td>1</td>
                <td>{{$category->title}}</td>
                <td class="text-wrap">{{$category->description}}</td>
                <td>{{$category->slug}}</td>
                <td>
                  <a href="#" class="btn btn-sm btn-primary"><i class="bi bi-pencil"></i> Редактировать</a>
                  <a href="#" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i> Удалить</a>
                </td>
              </tr>
              @endforeach
              
            </tbody>
          </table>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
    </div>
  </div>
</div>
@endsection
