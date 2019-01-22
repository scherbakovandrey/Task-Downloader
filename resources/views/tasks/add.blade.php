@extends('layout')

@section('title', 'Add New Task')

@section('content')
    <h1 class="title">Add New Task</h1>

    <form method="POST" action="/tasks">
        {{ csrf_field() }}

        @if ($errors->any())
            <div class="notification is-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="field">
            <label class="label" for="url">Resouce URL</label>

            <div class="control">
                <input class="input {{ $errors->has('url') ? 'is-danger' : '' }}" name="url" value="{{ old('url') }}" placeholder="Resource URL" type="url" required>
            </div>
        </div>

        <div class="field">
            <div class="control">
                <button type="submit" class="button is-link">Add New Task</button>
            </div>
        </div>
    </form>

@endsection