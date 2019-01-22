@extends('layout')

@section('title', 'Tasks List')

@section('content')
    <h1 class="title">Tasks List</h1>

    @if (count($tasks))
    <table class="table is-fullwidth is-bordered">
        <thead>
        <tr>
            <th>Url</th>
            <th>Status</th>
            <th>Action</th>

        </tr>
        </thead>
        <tbody>

        @foreach($tasks as $task)

        <tr>
            <td>{{ $task->url }}</td>
            <td>{{ $task->getReadableStatus() }}</td>
            <td class="text-justify"><?= $task->isCompleted() ? ' <a href="/tasks/' . $task->id . '/download">Download</a>' : '' ?></td>
        </tr>

        @endforeach

        </tbody>
    </table>
    @else
        <p>Sorry, there are not any tasks!</p>
    @endif

@endsection
