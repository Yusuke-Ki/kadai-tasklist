@extends('layouts.app')

@section('content')

<h1>id: {{ $tasklist->id }} のタスクリスト編集ページ</h1>

    {!! Form::model($tasklist, ['route' => ['tasklists.update', $tasklist->id], 'method' => 'put']) !!}

        {!! Form::label('content', 'メッセージ:') !!}
        {!! Form::text('content') !!}

        {!! Form::submit('更新') !!}

    {!! Form::close() !!}

<!-- Write content for each page here -->

@endsection