    @extends('layouts.admin')
@section('title', 'Панель администратора - Путешествия')
@section('content')
    <h1>Путешествия</h1>
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th><a href="{{route('admin.travelpost.sorter',['field'=>'title'])}}" class="btn btn-info btn-sm"> Заголовок</a></th>
                <th>Дата публикации</th>
                <th>Описание</th>
                <th>slug</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($travelposts as $travelpost)
                <tr>
                    <td>{{ $travelpost->id }}</td>
                   <td>{{ $travelpost->title }}</td>
                    <td>{{ $travelpost->created_at->format('Y.m.d') }}</td>
                    <td>{{ $travelpost->description }}</td>
                    <td>{{ $travelpost->slug }}</td>
                    <td>
                        <a href="{{ route('travelpost.show', $travelpost->id) }}" class="btn btn-info btn-sm">Просмотр</a>
                        <a href="{{ route('travelpost.edit', $travelpost->id) }}" class="btn btn-warning btn-sm">Редактировать</a>
                        <form action="{{ route('travelpost.destroy', $travelpost->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Вы уверены?')">Удалить</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection