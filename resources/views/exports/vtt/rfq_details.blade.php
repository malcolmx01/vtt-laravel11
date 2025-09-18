<table cellspacing="3" bgcolor="#000000" style="border: 1px solid #000;">
    <thead>
        <tr>
            <td colspan="5"><h1><strong>DEPARTMENT OF EDUCATION</strong></h1></td>
        </tr>
        <tr>
            <td colspan="5"><i>Pasig City, Metro Manila</i></td>
        </tr>
        <tr>
            <td colspan="5"></td>
        </tr>
        <tr>
            <td colspan="5"><h1><strong>REQUEST FOR QUOTATION (RFQ)</strong></h1></td>
        </tr>
        <tr>
            <td colspan="5"></td>
        </tr>
        <tr>
            <td colspan="5"></td>
        </tr>

        <tr>
            <td colspan="5">Dear Sir/Madam:</td>
        </tr>
        <tr>
            <td colspan="5"></td>
        </tr>

        <tr>
            <td colspan="5">May we request for the latest market price of the item/s described/listed below and submit</td>
        </tr>
        <tr>
            <td colspan="5">your quotation on or before {{ date('F d, Y', strtotime($RfqHeader->rfq_date))  }} at negor.bac@negor.gov.ph</td>
        </tr>

        <tr>
            <td colspan="5"></td>
        </tr>


        {{--<tr>
                    <td colspan="2">Dear Sir/Madam:</td>
                    <td colspan="5"><strong>{{$RfqHeader->office->dept_name ?? ''}}</strong> </td>
                </tr>

                {{--Dear Sir/Madam:
                May we request for the latest market price of the item/s described/listed below and submit
                your quotation on or before 13 June 2022 at negor.bac@negor.gov.ph

                Please find our quotations/prices in accordance with your requirements,
                Company Name
                Printed Name and Signature
                Tel. No.:
                Mobile No.:

                Thank you!
                JUAN DELA CRUZ
                BAC, SECRETARY--}}


        {{--<tr>
            <td colspan="1">F/P/P Code:</td>
            <td colspan="5"><strong>{{$RfqHeader->office_id ?? ''}}</strong> </td>
        </tr>--}}
        <tr>
            <td colspan="2">RFQ No.:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong> {{$RfqHeader->rfq_no ?? ''}}</strong></td>
        </tr>
        <tr>
            <td colspan="2">RFQ Date:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong> {{date('m/d/Y', strtotime($RfqHeader->rfq_date)) ?? ''}}</strong></td>
        </tr>

        <tr>
            <td colspan="12"></td>
        </tr>

        <tr class="fw-bolder fs-6 text-gray-900">
            <th>ITEM DESCRIPTION</th>
            <th>UNIT</th>
            <th>QTY.</th>
            <th>UNIT COST</th>
            <th>TOTAL COST</th>
        </tr>
    </thead>
    <tbody>
    @forelse($RfqDetailItems as $itemKey => $itemDetails)
        @php
            $total_per_category = 0;
        @endphp
        {{--<tr class="table-primary">
            <td colspan="5" class="text-center" style="background-color: #0b0e18 !important;">
                <strong style="text-transform: uppercase">{{ $itemKey }}</strong>
            </td>
        </tr>--}}
        @foreach($itemDetails as $key => $value)
            <tr>
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
                    {{--{{ number_format($value['unit_cost'], 2)  ?? '' }}--}}
                </td>
                <td>
                    {{--{{ $value['item_total_cost'] ? number_format($value['item_total_cost'], 2) : '' }}--}}
                </td>
            </tr>
        @endforeach
    @empty
        <tr>
            <td colspan="5" class="text-center"><p class="bg-lighten p-5"><strong>No item(s) selected</strong></p></td>
        </tr>
    @endforelse
    {{--<td colspan="1"><strong>{{ number_format($RfqHeader->pr_amount, 2)  }} </strong></td>--}}
    {{--@if(!empty($RfqHeader->pr_amount))--}}
        <tr class="table-warning">
            <td colspan="4"><strong>Grand Total</strong></td>
            <td></td>
        </tr>
    {{--@endif--}}
    </tbody>
    <tfoot>
    <tr>
        <td colspan="5"></td>
    </tr>
    <tr>
        <td colspan="5">Please find our quotations/prices in accordance with your requirements,</td>
    </tr>

    <tr>
        <td colspan="5"></td>
    </tr>
    <tr>
        <td colspan="5"></td>
    </tr>

    <tr>
        <td colspan="5">Company Name : _________________________________________________</td>
    </tr>
    <tr>
        <td colspan="5">Tel. No. : ________________________________________________________</td>
    </tr>
    <tr>
        <td colspan="5">Mobile No. : _____________________________________________________</td>
    </tr>
    <tr>
        <td colspan="5"></td>
    </tr>
    <tr>
        <td colspan="5"></td>
    </tr>


    <tr>
        <td colspan="5">Thank you!</td>
    </tr>

    <tr>
        <td colspan="5"><strong>{{ strtoupper($RfqHeader->prepared_by) }}</strong></td>
    </tr>
    <tr>
        <td colspan="5">{{ strtoupper($RfqHeader->designation_prepared) }}</td>
    </tr>
    </tfoot>
</table>
