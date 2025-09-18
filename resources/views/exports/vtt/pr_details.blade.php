<table cellspacing="3" bgcolor="#000000" style="border: 1px solid #000;">
    <thead>
        <tr>
            <td colspan="6"><h1><strong>DEPARTMENT OF EDUCATION</strong></h1></td>
        </tr>
        <tr>
            <td colspan="6"><i>Pasig City, Metro Manila</i></td>
        </tr>
        <tr>
            <td colspan="6"></td>
        </tr>
        <tr>
            <td colspan="6"><h1><strong>PURCHASE REQUEST (PR)</strong></h1></td>
        </tr>
        <tr>
            <td colspan="6"></td>
        </tr>
        <tr>
            <td colspan="1">OFFICE:</td>
            <td colspan="5"><strong>{{$prHeader->office->dept_name ?? ''}}</strong> </td>
        </tr>
        <tr>
            <td colspan="1">F/P/P Code:</td>
            <td colspan="5"><strong>{{$prHeader->office_id ?? ''}}</strong> </td>
        </tr>
        <tr>
            <td colspan="1">PR No.:</td>
            <td colspan="5"><strong>{{$prHeader->pr_no ?? ''}}</strong> </td>
        </tr>
        <tr>
            <td colspan="1">PR Date:</td>
            <td colspan="5"><strong>{{$prHeader->pr_date ?? ''}}</strong> </td>
        </tr>
        <tr class="fw-bolder fs-6 text-gray-900">
            <th rowspan="2">CODE</th>
            <th rowspan="2">ITEM DESCRIPTION</th>
            <th rowspan="2">UNIT</th>
            <th rowspan="2">QTY.</th>
            <th rowspan="2">UNIT COST</th>
            <th rowspan="2">TOTAL COST</th>
        </tr>
    </thead>
    <tbody>
    <tr></tr>
    @forelse($prDetailItems as $itemKey => $itemDetails)
        @php
            $total_per_category = 0;
        @endphp
        <tr class="table-primary">
            <td colspan="6" class="text-center" style="background-color: #0b0e18 !important;"><strong style="text-transform: uppercase">{{ $itemKey }}</strong></td>
        </tr>
        @foreach($itemDetails as $key => $value)
            <tr>
                <td>
                    {{$value['items']['ngas_code'] ? $value['items']['ngas_code'] : $value['items']['id']}}
                </td>
                <td>
                    {{$value['item']}}
                </td>
                <td>
                    {{$value['item_unit']}}
                </td>
                <td>
                    {{ number_format( $value['item_total_qty'], 2) }}
                </td>
                <td>
                    {{ number_format($value['item_unit_cost'], 2)  ?? '' }}
                </td>
                <td>
                    {{ $value['item_total_cost'] ? number_format($value['item_total_cost'], 2) : '' }}
                </td>
            </tr>
            @php
                $total_per_category += $value['item_total_cost'];
            @endphp
        @endforeach
        @if( !empty($total_per_category))
            <tr class="table-active">
                <td colspan="5"><strong>Sub Total</strong></td>
                <td colspan="1"><strong>{{ $total_per_category ? number_format((int) array_sum((array) $total_per_category ?? 0), 2) : '' }} </strong></td>
            </tr>
        @endif
    @empty
        <tr>
            <td colspan="6" class="text-center"><p class="bg-lighten p-5"><strong>No item(s) selected</strong></p></td>
        </tr>
    @endforelse
    {{--<td colspan="1"><strong>{{ number_format($prHeader->pr_amount, 2)  }} </strong></td>--}}
    {{--@if(!empty($prHeader->pr_amount))--}}
        <tr class="table-warning">
            <td colspan="5"><strong>Grand Total</strong></td>
            <td colspan="1"><strong>{{ number_format($prHeader->pr_amount, 2)  }} </strong></td>
        </tr>
    {{--@endif--}}
    </tbody>
    <tfoot>
    <tr>
        <td colspan="6"></td>
    </tr>
    <tr>
        <td colspan="2">Prepared by:</td>
        <td colspan="2">Date Submitted: </td>
        <td colspan="2">{{$prHeader->date_submitted}} </td>
    </tr>
    <tr>
        <td></td>
        <td colspan="5"><strong>{{ strtoupper($prHeader->prepared_by) }}</strong></td>
    </tr>
    <tr>
        <td></td>
        <td colspan="5">{{ strtoupper($prHeader->designation_prepared) }}</td>
    </tr>
    </tfoot>
</table>
