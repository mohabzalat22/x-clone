@if ($errors->any())
    <div class="alert alert-danger rounded-0 border border-start-danger m-2">
        @foreach ($errors->all() as $e)
            <div class="p-1">{{$e}}</div>
        @endforeach  
    </div>
@endif