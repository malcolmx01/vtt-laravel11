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
        <th colspan="5"></th>
    </tr>
    <tr>
        <td colspan="5"><h2>SUPPLIES AVAILABILITY INQUIRY</h2></td>
    </tr>
    <tr>
        <td colspan="2">
            OFFICE: {{$header->office->dept_name ?? ''}}<br/>
            Responsibility Center Code: {{$header->office->dept_code ?? ''}}
        </td>
        <td colspan="3">
            SAI No.: {{$header->sai_no ?? ''}}<br/>
            Date: {{ date('m/d/Y', strtotime($header->sai_date)) }}
        </td>
    </tr>
    <tr>
        <th>ITEM No.</th>
        <th>ITEM/DESCRIPTION</th>
        <th>UNIT</th>
        <th>QTY.</th>
        <th>Status of Stock</th>
    </tr>
    </thead>

    {{--<thead>--}}
    {{--<tr>--}}
    {{--<td colspan="3" rowspan="3">--}}
        {{--<p>OFFICE:</p>--}}
        {{--<p style="text-align: center">{{$header->office->dept_name ?? ''}}</p>--}}
    {{--</td>--}}
        {{--<td colspan="2">Responsibility Center Code:</td><td>{{$header->office ?? ''}}</td>--}}
    {{--</tr>--}}
    {{--<tr>--}}
        {{--<td colspan="2">SAI No.: {{$header->sai_no ?? ''}}</td>--}}
        {{--<td>Date: {{ date('m/d/Y', strtotime($header->sai_date)) }}</td>--}}
        {{--<td>Date: </td>--}}
    {{--<td>Date: _____________</td>--}}
    {{--</tr>--}}
    {{--<tr>--}}
        {{--<th>ITEM No.</th>--}}
        {{--<th>ITEM/DESCRIPTION</th>--}}
        {{--<th>UNIT</th>--}}
        {{--<th>QTY.</th>--}}
        {{--<th>Status of Stock</th>--}}
    {{--</tr>--}}
    {{--</thead>--}}
    <tbody>
    @forelse($details as $itemKey => $itemDetails)
        <tr>
            <td>
                {{$itemDetails->id}}
            </td>
            <td>
               <h3 style="font-weight: bold">{{$itemDetails->item}}</h3><br/>
                {!! $itemDetails->details ?? '' !!}
            </td>
            <td>
                {{$itemDetails->item_unit}}
            </td>
            <td>
                {{ number_format( $itemDetails->item_total_qty ) }}
            </td>
            <td>
                {{ $itemDetails->stock }}
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="5">No item(s)</td>
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
        <td> x - x - x - x - x - x - x - x - x - x - x - x - x - x - x - x - x </td>
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
    <tr>
        <td colspan="5">Purpose / Remarks: &nbsp;&nbsp;&nbsp;
            {!! $header->remarks ?? '' !!}
        </td>
    </tr>
    </tbody>
    <tfoot>
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td colspan="2">
            <strong>Inquired by:</strong>
        </td>
        <td colspan="3">
            <strong>Status provided by:</strong>
        </td>
    </tr>
    <tr>
        <td colspan="2"></td>
        <td colspan="3"></td>
    </tr>
    <tr>
        <td colspan="2">
            <strong>{{ strtoupper( $header->inquired_name ?? '' ) }}</strong>
        </td>
        <td colspan="3">
            <strong>{{ strtoupper( $header->prepared_name ?? '' ) }}</strong>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            {{ $header->inquired_designation ?? '' }}
        </td>
        <td colspan="3">
            {{ $header->prepared_designation ?? '' }}
        </td>
    </tr>
    <tr>
        <td colspan="2">
            Date: ___________________________
        </td>
        <td colspan="3">
            Date: ___________________________
        </td>
    </tr>
    <tr>
        <td colspan="2"></td>
        <td colspan="3"></td>
    </tr>
    </tfoot>
</table>
