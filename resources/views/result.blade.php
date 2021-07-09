<form action="{{$method == 'POST' ? route('create-task') : route('update-task', ['id' => $task->id])}}" method="POST">
    @if ($method == 'PUT')
    {{method_field('put')}}
    @endif
    <div class="mt-4">
        <x-label for="title" :value="__('Title')" />
        <input id="title" class="block mt-1 w-full" type="text" name="title" value="{{$task->title}}" required autofocus />
    </div>
    <div class="mt-4">
        <x-label for="description" :value="__('Description')" />
        <textarea id="description" class="block mt-1 w-full" type="text" name="description">{{$task->description}}</textarea>
    </div>
    
    @if (!$disabled)
    
    <select name="assignee_id" id="assignee_id">
        @foreach($tables as $data)
        @if ($task->assignee_id === $data->id) {
        <option selected value="{{ $data->id }}">{{ $data->name }}</option>
        }
        @else
        {
        <option value="{{ $data->id }}">{{ $data->name }}</option>
        }
        @endif
        @endforeach
    </select>
    @else
   
    <select name="assignee_id" id="assignee_id" disabled>
        @foreach($tables as $data)
        @if ($task->assignee_id === $data->id) {
        <option selected value="{{ $data->id }}">{{ $data->name }}</option>
        }
        @else
        {
        <option value="{{ $data->id }}">{{ $data->name }}</option>
        }
        @endif
        @endforeach
    </select>
    @endif

    <select id="status_id" name="status_id" class="form-control">
        @foreach ($statuses as $s)
        @if ($task->status_id === $s->id)
        <option selected value="{{ $s->id }}">{{ $s->name }}</option>
        @else
        <option value="{{ $s->id }}">{{ $s->name }}</option>
        @endif
        @endforeach
    </select>
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />


    <button type="submit">Submit</button>

</form>