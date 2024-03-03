@forelse($monthlyRevenue as $item)
    <tr>
        <td>{{$item['month']}}</td>
        <td>{{showPrice($item['revenue'])}}</td>
    </tr>
@empty
    <tr>
        <td class="text-center " colspan="2">{{__("No Data Found")}}</td>
    </tr>
@endforelse
