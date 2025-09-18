<table>
    <thead>
        <tr>
            <th colspan="5"></th>
        </tr>
        <tr>
            <th colspan="5">Republic of the Philippines</th>
        </tr>
        <tr>
            <th colspan="5"><strong>DEPARTMENT OF EDUCATION</strong></th>
        </tr>
        <tr>
            <th colspan="5">Pasig City, Metro Manila</th>
        </tr>
        <tr>
            <th colspan="5"></th>
        </tr>
        <tr>
            <td colspan="5"></td>
        </tr>
        <tr>
            <td colspan="5"><h2>INVENTORY CUSTODIAN SLIP</h2></td>
        </tr>
        <tr>
            <td colspan="3">
            </td>
            <td colspan="2">
                <strong>PRS No.: {{$header->ics_no ?? ''}}</strong>
            </td>
        </tr>
        {{--<tr>--}}
            {{--<th>ITEM No.</th>--}}
            {{--<th>UNIT</th>--}}
            {{--<th>ITEM/DESCRIPTION</th>--}}
            {{--<th>QTY.</th>--}}
            {{--<th>ESTIMATED<br>UNIT COST</th>--}}
            {{--<th>ESTIMATED<br>TOTAL COST</th>--}}
        {{--</tr>--}}
        <tr>
            <th>QTY.</th>
            <th>UNIT</th>
            <th>ITEM/DESCRIPTION</th>
            <th>INVENTORY<br>ITEM NO.</th>
            <th>ESTIMATED<br>USEFUL LIFE</th>
        </tr>
    </thead>
    <tbody>
    @forelse($details as $itemKey => $itemDetails)
        @php
{{--            $grandtotal = 0;--}}
        @endphp
        {{--@foreach($itemDetails as $key => $value)--}}
            <tr>
                <td>
                    {{--{{$value['id']['ngas_code'] ? $value['items']['ngas_code'] : $value['items']['id']}}--}}
                    {{ number_format( $itemDetails->item_total_qty ) }}
                </td>
                <td>
                    {{$itemDetails->item_unit}}
                </td>
                <td>
                    {{$itemDetails->item}}
                </td>
                <td>
                    {{$itemDetails->serial_no}}
                </td>
                <td>
                    {{$itemDetails->estimated_useful_life}}
                </td>
                {{--<td>--}}
                    {{--{{ number_format($itemDetails->item_unit_cost, 2)  ?? '' }}--}}
                {{--</td>--}}
                {{--<td>--}}
                    {{--{{ $itemDetails->item_total_cost ? number_format($itemDetails->item_total_cost, 2) : '' }}--}}
                {{--</td>--}}
            </tr>
            @php
                $grandtotal += $itemDetails->item_total_cost;
            @endphp
        {{--@endforeach--}}
    @empty
        <tr>
            <td colspan="5" class="text-center"><p class="bg-lighten p-5"><strong>No item(s) selected</strong></p></td>
        </tr>
    @endforelse
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="5"></td>
        </tr>
        <tr>
            <td colspan="2"></td>
            <td>
                <strong>Received from:</strong>
            </td>
            <td colspan="3">
                <strong>Received by:</strong>
            </td>
        </tr>
        <tr>
            <td colspan="2"></td>
            <td colspan="3"></td>
        </tr>
        <tr>
            <td colspan="2"><strong>Signature</strong></td>
            <td colspan="3"></td>
        </tr>
        <tr>
            <td colspan="2"><strong>Printed Name</strong></td>
            <td>
                <strong>{{ strtoupper( $header->received_from_name ) }}</strong>
            </td>
            <td colspan="3">
                <strong>{{ strtoupper( $header->received_by_name ?? '' ) }}</strong>
            </td>
        </tr>
        <tr>
            <td colspan="2"><strong>Designation</strong></td>
            <td>
                {{ $header->received_from_position }}
            </td>
            <td colspan="3">
                {{ $header->received_by_position ?? '' }}
            </td>
        </tr>
    </tfoot>

</table>
