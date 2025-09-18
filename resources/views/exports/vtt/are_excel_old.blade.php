<table>
    <thead>
        <tr>
            <th colspan="2" rowspan="5"></th>
            <th colspan="3"></th>
            <th></th>
        </tr>
        <tr>
            <th colspan="3">Republic of the Philippines</th>
            <th></th>
        </tr>
        <tr>
            <th colspan="3"><strong>DEPARTMENT OF EDUCATION</strong></th>
            <th></th>
        </tr>
        <tr>
            <th colspan="3">Pasig City, Metro Manila</th>
            <th></th>
        </tr>
        <tr>
            <th colspan="4"></th>
        </tr>
        <tr>
            <td colspan="6"></td>
        </tr>

        <tr>
            <td colspan="6"><h2>Acknowledgement Receipt for Equipment</h2></td>
        </tr>

        {{--<tr>--}}
            {{--<td colspan="3" rowspan="3">--}}
                {{--<p>REQUISITIONING OFFICE:</p>--}}
                {{--<p style="text-align: center">{{$header->office->dept_name ?? ''}}</p>--}}
            {{--</td>--}}
            {{--<td colspan="2">P.R. No.: {{$header->pr_no ?? ''}}</td>--}}
            {{--<td>Date: {{ date('m/d/Y', strtotime($header->pr_date)) }}</td>--}}
        {{--</tr>--}}
        {{--<tr>--}}
            {{--<td colspan="2">SAI No.:_____________________</td>--}}
            {{--<td colspan="2">SAI No.:</td>--}}
            {{--<td>Date: _____________</td>--}}
            {{--<td>Date: </td>--}}
        {{--</tr>--}}
        {{--<tr>--}}
            {{--<td colspan="2">ALOBS No.:__________________</td>--}}
            {{--<td colspan="2">ALOBS No.:</td>--}}
            {{--<td>Date: </td>--}}
            {{--<td>Date: _____________</td>--}}
        {{--</tr>--}}
        <tr>
            <th>ITEM No.</th>
            <th>UNIT</th>
            <th>ITEM/DESCRIPTION</th>
            <th>QTY.</th>
            <th>ESTIMATED<br>UNIT COST</th>
            <th>ESTIMATED<br>TOTAL COST</th>
        </tr>
    </thead>
    <tbody>
    @forelse($details as $itemKey => $itemDetails)
        @php
            $grandtotal = 0;
        @endphp
        @foreach($itemDetails as $key => $value)
            <tr>
                <td>
                    {{--{{$value['id']['ngas_code'] ? $value['items']['ngas_code'] : $value['items']['id']}}--}}
                    {{$value['id']}}
                </td>
                <td>
                    {{$value['item_unit']}}
                </td>
                <td>
                    {{$value['item']}}
                </td>
                <td>
                    {{ number_format( $value['item_total_qty']) }}
                </td>
                <td>
                    {{ number_format($value['item_unit_cost'], 2)  ?? '' }}
                </td>
                <td>
                    {{ $value['item_total_cost'] ? number_format($value['item_total_cost'], 2) : '' }}
                </td>
            </tr>
            @php
                $grandtotal += $value['item_total_cost'];
            @endphp
        @endforeach
    @empty
        <tr>
            <td colspan="6" class="text-center"><p class="bg-lighten p-5"><strong>No item(s) selected</strong></p></td>
        </tr>
    @endforelse
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td> x - x - x - x - x - x - x - x - x - x - x - x</td>
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
        <td></td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td><strong>NOTE:</strong></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td>
            <p>{{ strip_tags($header->remarks ?? '') }}</p>
            {{--<p>{!! $header->remarks ?? '' !!}</p>--}}
        </td>
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
        <td></td>
    </tr>
    <tr class="table-warning">
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td><strong>Grand Total</strong></td>
        <td><strong>{{ number_format($grandtotal, 2)  }} </strong></td>
    </tr>
    </tbody>
    <tfoot>
        {{--<tr>--}}
            {{--<td colspan="2"><strong>Remarks: </strong></td>--}}
            {{--<td colspan="4" rowspan="2">--}}
                {{--<p>{{ $header->remarks ?? '' }}</p>--}}
            {{--</td>--}}
        {{--</tr>--}}
        <tr>
            <td colspan="2"></td>
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
            <td></td>
            <td colspan="3"></td>
        </tr>
        <tr>
            <td colspan="2"><strong>Signature</strong></td>
            <td></td>
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
