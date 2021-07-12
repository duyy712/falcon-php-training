<html lang="en">

<head>
    <title> Laravel training</title>
</head>

<body>
    <h1>Hello, {{auth()->user()->name}}</h1>
    <a href="{{ route('new-task')}}">Create new task</a>
    <table border="1">
        <tr>
            <td><b>Title</b></td>
            <td><b>Description</b></td>
            <td><b>Assignee</b></td>
            <td><b>Assigner</b></td>
            <td><b>Status</b></td>
        </tr>
        @foreach($tasks as $t)
        <tr>
            <td>{{$t->title}}</td>
            <td>{{$t->description}}</td>
            <td>{{$t->assignee ? $t->assignee->name : ''}}</td>
            <td>{{$t->assigner->name}}</td>
            <td>{{$t->status->name}}</td>
            @if (auth()->user()->is_admin || auth()->user()->id == $t->assigner->id)
            <td><a href="{{route('edit-task', ['id' => $t->id])}}"> Edit </a></td>
            @endif
        </tr>
        @endforeach
    </table>

    <form action="{{ route('logout') }}" method="POST">
        @csrf


        <button type="submit">
            {{ __('Logout') }}
        </button>
    </form>
</body>

</html>