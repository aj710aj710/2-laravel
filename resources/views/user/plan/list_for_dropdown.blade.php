@if(count($plans)>0)
    <option value="">{{__("Select Plan")}}</option>
    @foreach($plans as $item)
        <option value="{{$item->id}}">{{$item->name}}</option>
    @endforeach
@endif

