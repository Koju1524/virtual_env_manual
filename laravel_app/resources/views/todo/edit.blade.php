@extends ('layouts.app')
@section ('content')

<h2 class="mb-3">ToDo編集</h2>
{!! Form::open(['route' => ['todo.update', $todo->id], 'method' => 'PUT']) !!}
  <div class="form-group">
    {!! Form::input('text', 'content', $todo->content, ['required', 'class' => 'form-control']) !!}
    <!-- <input type="text" class="form-control" placeholder="ToDo内容"> -->
  </div>
  {!! Form::submit('更新', ['class' => 'btn btn-success float-right']) !!}
  <!-- <button type="submit" class="btn btn-success float-right">更新</button> -->
{!! Form::close() !!}

@endsection