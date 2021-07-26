You have {{$count}} incompleted task(s). 
@if ($count >0)
<table border="1">
    <tr>
        <td><b>Title</b></td>
        <td><b>Description</b></td>        
        <td><b>Assigner</b></td>
        <td><b>Status</b></td>
    </tr>
    @foreach($tasks as $t)
    <tr>
        <td>{{$t->title}}</td>
        <td>{{$t->description}}</td>
        <td>{{$t->assigner->name}}</td>
        <td>{{$t->status->name}}</td>
     </tr>
    @endforeach
</table>
@endif