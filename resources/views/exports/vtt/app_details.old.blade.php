<table cellspacing="3" bgcolor="#000000" style="border: 1px solid #000;">
    <thead>
        <tr>
            <td colspan="10"><h1><strong>DEPARTMENT OF EDUCATION</strong></h1></td>
        </tr>
        <tr>
            <td colspan="10"><i>Pasig City, Metro Manila</i></td>
        </tr>
        <tr>
            <td colspan="10"></td>
        </tr>
        <tr>
            <td colspan="10"><h1><strong>ANNUAL PROCUREMENT PLAN (APP) {{$appheader->app_year}}</strong></h1></td>
        </tr>
        <tr>
            <td colspan="10"></td>
        </tr>
        {{--<tr>
            <td colspan="1">END-USER/UNIT:</td>
            <td colspan="9"><strong>{{$appheader->office->dept_name ?? ''}}</strong> </td>
        </tr>
        <tr>
            <td colspan="1">F/P/P Code:</td>
            <td colspan="9"><strong>{{$appheader->office_id ?? ''}}</strong> </td>
        </tr>
        <tr>
            <td colspan="1">Control No.:</td>
            <td colspan="9"><strong>{{$appheader->plan_control_no ?? ''}}</strong> </td>
        </tr>
        <tr>
            <td colspan="10">Projects, Programs and Activities (PAPs)</td>
        </tr>--}}
        <tr class="fw-bolder fs-6 text-gray-900">
            <th rowspan="2">CODE</th>
            <th rowspan="2">GENERAL DESCRIPTION</th>
            <th rowspan="2">UNIT</th>
            <th rowspan="2">QTY.</th>
            <th rowspan="2">UNIT COST</th>
            <th rowspan="2">ESTIMATED BUDGET</th>
            <th colspan="4">SCHEDULE/MILESTONE OF ACTIVITIES</th>
        </tr>
        <tr>
            <th>1ST QTR</th>
            <th>2ND QTR</th>
            <th>3RD QTR</th>
            <th>4TH QTR</th>
        </tr>
    </thead>
    <tbody>
    @php
        $app_amount = 0;
    @endphp

    @forelse($AppDetailItems as $itemKey => $itemDetails)
        @php
            $total_per_category = 0;
        @endphp
        <tr class="table-primary">
            <td colspan="10" class="text-center" style="background-color: #0b0e18 !important;"><strong style="text-transform: uppercase">{{ $itemKey }}</strong></td>
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
                <td>
                    {{ number_format( $value['item_ttl_amt_1st'], 2) }}
                </td>
                <td>
                    {{ number_format( $value['item_ttl_amt_2nd'], 2) }}
                </td>
                <td>
                    {{ number_format( $value['item_ttl_amt_3rd'], 2) }}
                </td>
                <td>
                    {{ number_format( $value['item_ttl_amt_4th'], 2) }}
                </td>
            </tr>
            @php
                $total_per_category += $value['item_total_cost'];
                $app_amount += $value['item_total_cost'];
            @endphp
        @endforeach
{{--        @if( !empty($total_per_category))--}}
            <tr class="table-active">
                <td colspan="5"><strong>Sub Total</strong></td>
                <td colspan="1"><strong>{{ $total_per_category ? number_format((int) array_sum((array) $total_per_category ?? 0), 2) : '' }} </strong></td>
                <td colspan="4"></td>
            </tr>
        {{--@endif--}}
    @empty
        <tr>
            <td colspan="10" class="text-center"><p class="bg-lighten p-5"><strong>No item(s) selected</strong></p></td>
        </tr>
    @endforelse
    @if(!empty($app_amount))
        <tr {{--class="table-warning"--}}>
            <td colspan="5"><strong>Grand Total</strong></td>
            <td colspan="1"><strong>{{ number_format($app_amount, 2)  }} </strong></td>
            <td colspan="4"></td>
        </tr>
    @endif
    </tbody>
    <tfoot>
    <tr>
        <td colspan="10"></td>
    </tr>
    <tr>
        <td>Prepared by:</td>
    </tr>
    <tr>
        <td></td>
        <td colspan="9"><strong>{{ strtoupper($appheader->prepared_by) }}</strong></td>
    </tr>
    <tr>
        <td></td>
        <td colspan="9">{{ strtoupper($appheader->designation_prepared) }}</td>
    </tr>
    <tr>
        <td colspan="10"></td>
    </tr>
    <tr>
        <td colspan="1">Date Submitted: </td>
        <td colspan="9">{{$appheader->date_submitted}} </td>
    </tr>
    </tfoot>
</table>
