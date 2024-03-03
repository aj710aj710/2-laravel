
<option value="">{{__('Select Plan')}}</option>
@foreach($plan as $item)
    <option value="{{$item->id}}">{{$item->name}}</option>
@endforeach
