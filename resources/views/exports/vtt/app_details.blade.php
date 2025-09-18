<table cellspacing="3" bgcolor="#000000" style="border: 1px solid #000;">
    <thead>
    <tr>
        <td colspan="19"><h1><strong>DEPARTMENT OF EDUCATION</strong></h1></td>
    </tr>
    <tr>
        <td colspan="19"><i>Pasig City, Metro Manila</i></td>
    </tr>
    <tr>
        <td colspan="19"></td>
    </tr>
    <tr>
        <td colspan="19"><h1><strong>ANNUAL PROCUREMENT PLAN (APP) {{$appheader->app_year}}</strong></h1></td>
    </tr>
    <tr>
        <td colspan="19"></td>
    </tr>
    <tr>
        <td colspan="1">END-USER/UNIT:</td>
        <td colspan="18"><strong>{{$appheader->office->dept_name ?? ''}}</strong> </td>
    </tr>
    <tr>
        <td colspan="1">F/P/P Code:</td>
        <td colspan="18"><strong>{{$appheader->office_id ?? ''}}</strong> </td>
    </tr>
    <tr>
        <td colspan="1">Control No.:</td>
        <td colspan="18"><strong>{{$appheader->plan_control_no ?? ''}}</strong> </td>
    </tr>
    <tr>
        <td colspan="19">Projects, Programs and Activities (PAPs)</td>
    </tr>
    <tr class="fw-bolder fs-6 text-gray-900">
        <th rowspan="4">CODE</th>
        <th rowspan="4">GENERAL DESCRIPTION</th>
        <th rowspan="4">UNIT</th>
        <th rowspan="4">TOTAL QTY.</th>
        <th rowspan="4">UNIT COST</th>
        <th rowspan="4">ESTIMATED BUDGET</th>
        <th rowspan="4">PROC. METHOD</th>
        <th colspan="32">SCHEDULE/MILESTONE OF ACTIVITIES</th>
        <th colspan="2" rowspan="3">GRAND TOTAL</th>
    </tr>
    <tr>
        <th colspan="8">1ST QTR</th>
        <th colspan="8">2ND QTR</th>
        <th colspan="8">3RD QTR</th>
        <th colspan="8">4TH QTR</th>
    </tr>
    <tr>
        <th colspan="2">JAN</th>
        <th colspan="2">FEB</th>
        <th colspan="2">MAR</th>
        <th colspan="2">1ST QTR TOTAL</th>
        <th colspan="2">APR</th>
        <th colspan="2">MAY</th>
        <th colspan="2">JUN</th>
        <th colspan="2">2ND QTR TOTAL</th>
        <th colspan="2">JUL</th>
        <th colspan="2">AUG</th>
        <th colspan="2">SEP</th>
        <th colspan="2">3RD QTR TOTAL</th>
        <th colspan="2">OCT</th>
        <th colspan="2">NOV</th>
        <th colspan="2">DEC</th>
        <th colspan="2">4TH QTR TOTAL</th>
    </tr>
    <tr>
        <th>Qty</th>
        <th>Amt</th>
        <th>Qty</th>
        <th>Amt</th>
        <th>Qty</th>
        <th>Amt</th>
        <th>Qty</th>
        <th>Amt</th>
        <th>Qty</th>
        <th>Amt</th>
        <th>Qty</th>
        <th>Amt</th>
        <th>Qty</th>
        <th>Amt</th>
        <th>Qty</th>
        <th>Amt</th>
        <th>Qty</th>
        <th>Amt</th>
        <th>Qty</th>
        <th>Amt</th>
        <th>Qty</th>
        <th>Amt</th>
        <th>Qty</th>
        <th>Amt</th>
        <th>Qty</th>
        <th>Amt</th>
        <th>Qty</th>
        <th>Amt</th>
        <th>Qty</th>
        <th>Amt</th>
        <th>Qty</th>
        <th>Amt</th>
        <th>Qty</th>
        <th>Amt</th>
    </tr>
    </thead>
    <tbody>
    @php
        $total_amt = 0;
        $total_class_qty = 0;
        $total_jan_amt = 0;
        $total_feb_amt = 0;
        $total_mar_amt = 0;
        $total_apr_amt = 0;
        $total_may_amt = 0;
        $total_jun_amt = 0;
        $total_jul_amt = 0;
        $total_aug_amt = 0;
        $total_sep_amt = 0;
        $total_oct_amt = 0;
        $total_nov_amt = 0;
        $total_dec_amt = 0;
        $grand_total_per_classification = 0;
        $grand_total_class_qty= 0;

        $grand_ttl_item_amt_1st = 0;
        $grand_ttl_item_amt_2nd = 0;
        $grand_ttl_item_amt_3rd = 0;
        $grand_ttl_item_amt_4th = 0;

        $grand_total_item_jan_qty = 0;
        $grand_total_item_feb_qty = 0;
        $grand_total_item_mar_qty = 0;
        $grand_total_item_apr_qty = 0;
        $grand_total_item_may_qty = 0;
        $grand_total_item_jun_qty = 0;
        $grand_total_item_jul_qty = 0;
        $grand_total_item_aug_qty = 0;
        $grand_total_item_sep_qty = 0;
        $grand_total_item_oct_qty = 0;
        $grand_total_item_nov_qty = 0;
        $grand_total_item_dec_qty = 0;
        $grand_total_item_qty = 0;

        $grand_ttl_item_qty_1st = 0;
        $grand_ttl_item_qty_2nd = 0;
        $grand_ttl_item_qty_3rd = 0;
        $grand_ttl_item_qty_4th = 0;

        $total_per_item_amt = 0;
        $grand_total_item_amt = 0;


    @endphp

    @forelse($AppDetailItems as $itemKey => $itemDetails)
        <tr class="table-primary">
            <th colspan="41" class="text-center" style="background-color: #0b0e18 !important;"><strong style="text-transform: uppercase">{{ $itemKey }}</strong></th>
        </tr>
        @php
            $total_per_classification = 0;
            $total_class_qty= 0;

            $total_jan_class_amt = 0;
            $total_feb_class_amt = 0;
            $total_mar_class_amt = 0;
            $total_apr_class_amt = 0;
            $total_may_class_amt = 0;
            $total_jun_class_amt = 0;
            $total_jul_class_amt = 0;
            $total_aug_class_amt = 0;
            $total_sep_class_amt = 0;
            $total_oct_class_amt = 0;
            $total_nov_class_amt = 0;
            $total_dec_class_amt = 0;

            $total_per_item_jan_qty = 0;
            $total_per_item_feb_qty = 0;
            $total_per_item_mar_qty = 0;
            $total_per_item_apr_qty = 0;
            $total_per_item_may_qty = 0;
            $total_per_item_jun_qty = 0;
            $total_per_item_jul_qty = 0;
            $total_per_item_aug_qty = 0;
            $total_per_item_sep_qty = 0;
            $total_per_item_oct_qty = 0;
            $total_per_item_nov_qty = 0;
            $total_per_item_dec_qty = 0;
            $total_per_item_qty = 0;

            $sub_ttl_item_amt_1st = 0;
            $sub_ttl_item_amt_2nd = 0;
            $sub_ttl_item_amt_3rd = 0;
            $sub_ttl_item_amt_4th = 0;

            $sub_ttl_item_qty_1st = 0;
            $sub_ttl_item_qty_2nd = 0;
            $sub_ttl_item_qty_3rd = 0;
            $sub_ttl_item_qty_4th = 0;

        @endphp
        @foreach($itemDetails as $key => $value)
            <tr>
                <td>
                    {{$value['vehicles']['ngas_code'] ? $value['vehicles']['ngas_code'] : $value['vehicles']['id']}}
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
                    {{ $value['item_total_amt'] ? number_format($value['item_total_amt'], 2) : '' }}
                </td>
                <td>
                    {{ $value['procurement_mode_code'] }}
                </td>
                <td>{{ number_format( $value['item_jan_qty'], 2) }}</td>
                <td>{{ number_format( $value['item_jan_amt'], 2) }}</td>
                <td>{{ number_format( $value['item_feb_qty'], 2) }}</td>
                <td>{{ number_format( $value['item_feb_amt'], 2) }}</td>
                <td>{{ number_format( $value['item_mar_qty'], 2) }}</td>
                <td>{{ number_format( $value['item_mar_amt'], 2) }}</td>

                <td>{{ number_format( $value['item_ttl_qty_1st'], 2) }}</td>
                <td>{{ number_format( $value['item_ttl_amt_1st'], 2) }}</td>

                <td>{{ number_format( $value['item_apr_qty'], 2) }}</td>
                <td>{{ number_format( $value['item_apr_amt'], 2) }}</td>
                <td>{{ number_format( $value['item_may_qty'], 2) }}</td>
                <td>{{ number_format( $value['item_may_amt'], 2) }}</td>
                <td>{{ number_format( $value['item_jun_qty'], 2) }}</td>
                <td>{{ number_format( $value['item_jun_amt'], 2) }}</td>

                <td>{{ number_format( $value['item_ttl_qty_2nd'], 2) }}</td>
                <td>{{ number_format( $value['item_ttl_amt_2nd'], 2) }}</td>

                <td>{{ number_format( $value['item_jul_qty'], 2) }}</td>
                <td>{{ number_format( $value['item_jul_amt'], 2) }}</td>
                <td>{{ number_format( $value['item_aug_qty'], 2) }}</td>
                <td>{{ number_format( $value['item_aug_amt'], 2) }}</td>
                <td>{{ number_format( $value['item_sep_qty'], 2) }}</td>
                <td>{{ number_format( $value['item_sep_amt'], 2) }}</td>

                <td>{{ number_format( $value['item_ttl_qty_3rd'], 2) }}</td>
                <td>{{ number_format( $value['item_ttl_amt_3rd'], 2) }}</td>

                <td>{{ number_format( $value['item_oct_qty'], 2) }}</td>
                <td>{{ number_format( $value['item_oct_amt'], 2) }}</td>
                <td>{{ number_format( $value['item_nov_qty'], 2) }}</td>
                <td>{{ number_format( $value['item_nov_amt'], 2) }}</td>
                <td>{{ number_format( $value['item_dec_qty'], 2) }}</td>
                <td>{{ number_format( $value['item_dec_amt'], 2) }}</td>

                <td>{{ number_format( $value['item_ttl_qty_4th'], 2) }}</td>
                <td>{{ number_format( $value['item_ttl_amt_4th'], 2) }}</td>

                <td>{{ number_format( $value['item_total_qty'], 2) }}</td>
                <td>{{ number_format( $value['item_total_amt'], 2) }}</td>

            </tr>
            @php
                $grand_total_class_qty += $value['item_total_qty'];
                $grand_total_per_classification  += $value['item_total_amt'];

                $total_class_qty += $value['item_total_qty'];
                $total_per_classification += $value['item_total_amt'];

                $total_jan_class_amt += $value['item_jan_amt'];
                $total_feb_class_amt += $value['item_feb_amt'];
                $total_mar_class_amt += $value['item_mar_amt'];
                $total_apr_class_amt += $value['item_apr_amt'];
                $total_may_class_amt += $value['item_may_amt'];
                $total_jun_class_amt += $value['item_jun_amt'];
                $total_jul_class_amt += $value['item_jul_amt'];
                $total_aug_class_amt += $value['item_aug_amt'];
                $total_sep_class_amt += $value['item_sep_amt'];
                $total_oct_class_amt += $value['item_oct_amt'];
                $total_nov_class_amt += $value['item_nov_amt'];
                $total_dec_class_amt += $value['item_dec_amt'];

                $total_amt += $value['item_total_amt'];
                $total_jan_amt += $value['item_jan_amt'];
                $total_feb_amt += $value['item_feb_amt'];
                $total_mar_amt += $value['item_mar_amt'];
                $total_apr_amt += $value['item_apr_amt'];
                $total_may_amt += $value['item_may_amt'];
                $total_jun_amt += $value['item_jun_amt'];
                $total_jul_amt += $value['item_jul_amt'];
                $total_aug_amt += $value['item_aug_amt'];
                $total_sep_amt += $value['item_sep_amt'];
                $total_oct_amt += $value['item_oct_amt'];
                $total_nov_amt += $value['item_nov_amt'];
                $total_dec_amt += $value['item_dec_amt'];

                $total_per_item_jan_qty += $value['item_jan_qty'];
                $total_per_item_feb_qty += $value['item_feb_qty'];
                $total_per_item_mar_qty += $value['item_mar_qty'];
                $total_per_item_apr_qty += $value['item_apr_qty'];
                $total_per_item_may_qty += $value['item_may_qty'];
                $total_per_item_jun_qty += $value['item_jun_qty'];
                $total_per_item_jul_qty += $value['item_jul_qty'];
                $total_per_item_aug_qty += $value['item_aug_qty'];
                $total_per_item_sep_qty += $value['item_sep_qty'];
                $total_per_item_oct_qty += $value['item_oct_qty'];
                $total_per_item_nov_qty += $value['item_nov_qty'];
                $total_per_item_dec_qty += $value['item_dec_qty'];

                $total_per_item_qty += $value['item_total_qty'];
                $total_per_item_amt += $value['item_total_amt'];

                $grand_total_item_jan_qty += $value['item_jan_qty'];
                $grand_total_item_feb_qty += $value['item_feb_qty'];
                $grand_total_item_mar_qty += $value['item_mar_qty'];
                $grand_total_item_apr_qty += $value['item_apr_qty'];
                $grand_total_item_may_qty += $value['item_may_qty'];
                $grand_total_item_jun_qty += $value['item_jun_qty'];
                $grand_total_item_jul_qty += $value['item_jul_qty'];
                $grand_total_item_aug_qty += $value['item_aug_qty'];
                $grand_total_item_sep_qty += $value['item_sep_qty'];
                $grand_total_item_oct_qty += $value['item_oct_qty'];
                $grand_total_item_nov_qty += $value['item_nov_qty'];
                $grand_total_item_dec_qty += $value['item_dec_qty'];
                $grand_total_item_qty += $value['item_total_qty'];

                $grand_total_item_amt += $value['item_total_amt'];

                $grand_ttl_item_amt_1st += $value['item_ttl_amt_1st'];
                $grand_ttl_item_amt_2nd += $value['item_ttl_amt_2nd'];
                $grand_ttl_item_amt_3rd += $value['item_ttl_amt_3rd'];
                $grand_ttl_item_amt_4th += $value['item_ttl_amt_4th'];

                $grand_ttl_item_qty_1st += $value['item_ttl_qty_1st'];
                $grand_ttl_item_qty_2nd += $value['item_ttl_qty_2nd'];
                $grand_ttl_item_qty_3rd += $value['item_ttl_qty_3rd'];
                $grand_ttl_item_qty_4th += $value['item_ttl_qty_4th'];

                $sub_ttl_item_amt_1st += $value['item_ttl_amt_1st'];
                $sub_ttl_item_amt_2nd += $value['item_ttl_amt_2nd'];
                $sub_ttl_item_amt_3rd += $value['item_ttl_amt_3rd'];
                $sub_ttl_item_amt_4th += $value['item_ttl_amt_4th'];

                $sub_ttl_item_qty_1st += $value['item_ttl_qty_1st'];
                $sub_ttl_item_qty_2nd += $value['item_ttl_qty_2nd'];
                $sub_ttl_item_qty_3rd += $value['item_ttl_qty_3rd'];
                $sub_ttl_item_qty_4th += $value['item_ttl_qty_4th'];
            @endphp
        @endforeach
        {{--@if( !empty($total_per_classification))--}}
        <tr class="table-active">
            <td colspan="3"><strong>Sub Total for {{$itemKey}}</strong></td>
            <td colspan="1"><strong>{{ $total_class_qty ? number_format( array_sum((array) $total_class_qty ?? 0), 2) : '' }} </strong></td>
            <td colspan="1"></td>
            <td colspan="1"><strong>{{ $total_per_classification ? number_format( array_sum((array) $total_per_classification ?? 0), 2) : '' }} </strong></td>
            <td colspan="1"></td>
            <td colspan="1"><strong>{{ $total_per_item_jan_qty ? number_format( array_sum((array) $total_per_item_jan_qty ?? 0), 2) : '' }} </strong></td>
            <td colspan="1"><strong>{{ $total_jan_class_amt ? number_format( array_sum((array) $total_jan_class_amt ?? 0), 2) : '' }} </strong></td>

            <td colspan="1"><strong>{{ $total_per_item_feb_qty ? number_format( array_sum((array) $total_per_item_feb_qty ?? 0), 2) : '' }} </strong></td>
            <td colspan="1"><strong>{{ $total_feb_class_amt ? number_format( array_sum((array) $total_feb_class_amt ?? 0), 2) : '' }} </strong></td>

            <td colspan="1"><strong>{{ $total_per_item_mar_qty  ? number_format( array_sum((array) $total_per_item_mar_qty  ?? 0), 2) : '' }} </strong></td>
            <td colspan="1"><strong>{{ $total_mar_class_amt ? number_format( array_sum((array) $total_mar_class_amt ?? 0), 2) : '' }} </strong></td>

            <td colspan="1"><strong>{{ $sub_ttl_item_qty_1st ? number_format( array_sum((array) $sub_ttl_item_qty_1st ?? 0), 2) : '' }} </strong></td>
            <td colspan="1"><strong>{{ $sub_ttl_item_amt_1st ? number_format( array_sum((array) $sub_ttl_item_amt_1st ?? 0), 2) : '' }} </strong></td>

            <td colspan="1"><strong>{{ $total_per_item_apr_qty ? number_format( array_sum((array) $total_per_item_apr_qty ?? 0), 2) : '' }} </strong></td>
            <td colspan="1"><strong>{{ $total_apr_class_amt ? number_format( array_sum((array) $total_apr_class_amt ?? 0), 2) : '' }} </strong></td>

            <td colspan="1"><strong>{{ $total_per_item_may_qty ? number_format( array_sum((array) $total_per_item_may_qty ?? 0), 2) : '' }} </strong></td>
            <td colspan="1"><strong>{{ $total_may_class_amt ? number_format( array_sum((array) $total_may_class_amt ?? 0), 2) : '' }} </strong></td>

            <td colspan="1"><strong>{{ $total_per_item_jun_qty ? number_format( array_sum((array) $total_per_item_jun_qty ?? 0), 2) : '' }} </strong></td>
            <td colspan="1"><strong>{{ $total_jun_class_amt ? number_format( array_sum((array) $total_jun_class_amt ?? 0), 2) : '' }} </strong></td>

            <td colspan="1"><strong>{{ $sub_ttl_item_qty_2nd ? number_format( array_sum((array) $sub_ttl_item_qty_2nd ?? 0), 2) : '' }} </strong></td>
            <td colspan="1"><strong>{{ $sub_ttl_item_amt_2nd ? number_format( array_sum((array) $sub_ttl_item_amt_2nd ?? 0), 2) : '' }} </strong></td>

            <td colspan="1"><strong>{{ $total_per_item_jul_qty ? number_format( array_sum((array) $total_per_item_jul_qty ?? 0), 2) : '' }} </strong></td>
            <td colspan="1"><strong>{{ $total_jul_class_amt ? number_format( array_sum((array) $total_jul_class_amt ?? 0), 2) : '' }} </strong></td>

            <td colspan="1"><strong>{{ $total_per_item_aug_qty ? number_format( array_sum((array) $total_per_item_aug_qty ?? 0), 2) : '' }} </strong></td>
            <td colspan="1"><strong>{{ $total_aug_class_amt ? number_format( array_sum((array) $total_aug_class_amt ?? 0), 2) : '' }} </strong></td>

            <td colspan="1"><strong>{{ $total_per_item_sep_qty  ? number_format( array_sum((array) $total_per_item_sep_qty  ?? 0), 2) : '' }} </strong></td>
            <td colspan="1"><strong>{{ $total_sep_class_amt ? number_format( array_sum((array) $total_sep_class_amt ?? 0), 2) : '' }} </strong></td>

            <td colspan="1"><strong>{{ $sub_ttl_item_qty_3rd ? number_format( array_sum((array) $sub_ttl_item_qty_3rd ?? 0), 2) : '' }} </strong></td>
            <td colspan="1"><strong>{{ $sub_ttl_item_amt_3rd ? number_format( array_sum((array) $sub_ttl_item_amt_3rd ?? 0), 2) : '' }} </strong></td>

            <td colspan="1"><strong>{{ $total_per_item_oct_qty ? number_format( array_sum((array) $total_per_item_oct_qty ?? 0), 2) : '' }} </strong></td>
            <td colspan="1"><strong>{{ $total_oct_class_amt ? number_format( array_sum((array) $total_oct_class_amt ?? 0), 2) : '' }} </strong></td>

            <td colspan="1"><strong>{{ $total_per_item_nov_qty ? number_format( array_sum((array) $total_per_item_nov_qty ?? 0), 2) : '' }} </strong></td>
            <td colspan="1"><strong>{{ $total_nov_class_amt ? number_format( array_sum((array) $total_nov_class_amt ?? 0), 2) : '' }} </strong></td>

            <td colspan="1"><strong>{{ $total_per_item_dec_qty  ? number_format( array_sum((array) $total_per_item_dec_qty  ?? 0), 2) : '' }} </strong></td>
            <td colspan="1"><strong>{{ $total_dec_class_amt ? number_format( array_sum((array) $total_dec_class_amt ?? 0), 2) : '' }} </strong></td>

            <td colspan="1"><strong>{{ $sub_ttl_item_qty_4th ? number_format( array_sum((array) $sub_ttl_item_qty_4th ?? 0), 2) : '' }} </strong></td>
            <td colspan="1"><strong>{{ $sub_ttl_item_amt_4th ? number_format( array_sum((array) $sub_ttl_item_amt_4th ?? 0), 2) : '' }} </strong></td>

            <td colspan="1"><strong>{{ $total_per_item_qty ? number_format( array_sum((array) $total_per_item_qty ?? 0), 2) : '' }} </strong></td>
            <td colspan="1"><strong>{{ $total_per_item_amt ? number_format( array_sum((array) $total_per_item_amt ?? 0), 2) : '' }} </strong></td>
        </tr>
        {{--@endif--}}
    @empty
        <tr>
            <td colspan="39" class="text-center"><p class="bg-lighten p-5"><strong>No item(s) selected</strong></p></td>
        </tr>
    @endforelse
    @if(!empty($appheader->planned_amount))
        <tr class="table-warning">
            <td colspan="3"><strong>Grand Total</strong></td>
            <td colspan="1"><strong>{{ $grand_total_class_qty ? number_format( array_sum((array) $grand_total_class_qty ?? 0), 2) : '' }} </strong></td>
            <td colspan="1"></td>
            <td colspan="1"><strong>{{ $grand_total_per_classification ? number_format( array_sum((array) $grand_total_per_classification ?? 0), 2) : '' }} </strong></td>
            <td colspan="1"></td>
            <td></td>
            <td colspan="1"><strong>{{ $total_jan_amt ? number_format( array_sum((array) $total_jan_amt ?? 0), 2) : '' }} </strong></td>
            <td></td>
            <td colspan="1"><strong>{{ $total_feb_amt ? number_format( array_sum((array) $total_feb_amt ?? 0), 2) : '' }} </strong></td>
            <td></td>
            <td colspan="1"><strong>{{ $total_mar_amt ? number_format( array_sum((array) $total_mar_amt ?? 0), 2) : '' }} </strong></td>
            <td></td>
            <td colspan="1"><strong>{{ $grand_ttl_item_amt_1st ? number_format( array_sum((array) $grand_ttl_item_amt_1st ?? 0), 2) : '' }} </strong></td>
            <td></td>
            <td colspan="1"><strong>{{ $total_apr_amt ? number_format( array_sum((array) $total_apr_amt ?? 0), 2) : '' }} </strong></td>
            <td></td>
            <td colspan="1"><strong>{{ $total_may_amt ? number_format( array_sum((array) $total_may_amt ?? 0), 2) : '' }} </strong></td>
            <td></td>
            <td colspan="1"><strong>{{ $total_jun_amt ? number_format( array_sum((array) $total_jun_amt ?? 0), 2) : '' }} </strong></td>
            <td></td>
            <td colspan="1"><strong>{{ $grand_ttl_item_amt_2nd ? number_format( array_sum((array) $grand_ttl_item_amt_2nd ?? 0), 2) : '' }} </strong></td>
            <td></td>
            <td colspan="1"><strong>{{ $total_jul_amt ? number_format( array_sum((array) $total_jul_amt ?? 0), 2) : '' }} </strong></td>
            <td></td>
            <td colspan="1"><strong>{{ $total_aug_amt ? number_format( array_sum((array) $total_aug_amt ?? 0), 2) : '' }} </strong></td>
            <td></td>
            <td colspan="1"><strong>{{ $total_sep_amt ? number_format( array_sum((array) $total_sep_amt ?? 0), 2) : '' }} </strong></td>
            <td></td>
            <td colspan="1"><strong>{{ $grand_ttl_item_amt_3rd ? number_format( array_sum((array) $grand_ttl_item_amt_3rd ?? 0), 2) : '' }} </strong></td>
            <td></td>
            <td colspan="1"><strong>{{ $total_oct_amt ? number_format( array_sum((array) $total_oct_amt ?? 0), 2) : '' }} </strong></td>
            <td></td>
            <td colspan="1"><strong>{{ $total_nov_amt ? number_format( array_sum((array) $total_nov_amt ?? 0), 2) : '' }} </strong></td>
            <td></td>
            <td colspan="1"><strong>{{ $total_dec_amt ? number_format( array_sum((array) $total_dec_amt ?? 0), 2) : '' }} </strong></td>
            <td></td>
            <td colspan="1"><strong>{{ $grand_ttl_item_amt_4th ? number_format( array_sum((array) $grand_ttl_item_amt_4th ?? 0), 2) : '' }} </strong></td>

            <td colspan="1"><strong>{{ $grand_total_class_qty ? number_format( array_sum((array) $grand_total_class_qty ?? 0), 2) : '' }} </strong></td>
            <td colspan="1"><strong>{{ $grand_total_per_classification ? number_format( array_sum((array) $grand_total_per_classification ?? 0), 2) : '' }} </strong></td>

        </tr>
    @endif
    </tbody>
    <tfoot>
    <tr>
        <td colspan="41"></td>
    </tr>
    <tr>
        <td colspan="15">Prepared by:</td>
        <td colspan="2">Date Submitted: </td>
        <td colspan="24">{{$appheader->date_submitted}} </td>
    </tr>
    <tr>
        <td></td>
        <td colspan="40"><strong>{{ strtoupper($appheader->prepared_by) }}</strong></td>
    </tr>
    <tr>
        <td></td>
        <td colspan="40">{{ strtoupper($appheader->designation_prepared) }}</td>
    </tr>
    </tfoot>
</table>
