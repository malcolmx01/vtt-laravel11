<table>
    <thead>
        <tr>
            <th colspan="2" rowspan="5"></th>
            <th colspan="4"></th>
            <th></th>
        </tr>
        <tr>
            <th colspan="4">Republic of the Philippines</th>
            <th></th>
        </tr>
        <tr>
            <th colspan="4"><strong>DEPARTMENT OF EDUCATION</strong></th>
            <th></th>
        </tr>
        <tr>
            <th colspan="4">Pasig City, Metro Manila</th>
            <th></th>
        </tr>
        <tr>
            <th colspan="5"></th>
        </tr>
        <tr>
            <td colspan="7"></td>
        </tr>

        <tr>
            <td colspan="7"><h2>WASTE MATERIAL REPORT</h2></td>
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
            <th style="width: 10%;"><strong>ITEM</strong></th>
            <th style="width: 10%;"><strong>QTY.</strong></th>
            <th style="width: 10%;"><strong>UNIT</strong></th>
            <th style="width: 50%;" colspan="2" ><strong>DESCRIPTION</strong></th>
            <th style="width: 10%;"><strong>O.R. No.</strong></th>
            <th style="width: 10%;"><strong>AMOUNT</strong></th>
        </tr>
    </thead>
    <tbody>
    @forelse($details as $itemKey => $itemDetails)
        @php
            $grandtotal = 0;
        @endphp
            <tr>
                <td>
                    {{$itemDetails->id}}
                </td>
                <td>
                    {{ number_format( $itemDetails->item_total_qty, 2) }}
                </td>
                <td>
                    {{$itemDetails->item_unit}}
                </td>
                <td colspan="2" >
                    {{$itemDetails->item}}
                </td>
                <td>
                    {{$itemDetails->invoice_or_no}}
                </td>
                <td>
                    {{ number_format($itemDetails->item_unit_cost, 2)  ?? '' }}
                </td>
            </tr>
        @php
            $grandtotal += $itemDetails->item_total_cost;
        @endphp
    @empty
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td colspan="2" >No item(s)</td>
            <td></td>
            <td></td>
        </tr>
    @endforelse
    <tr class="table-warning">
        <td></td>
        <td></td>
        <td></td>
        <td colspan="2"></td>
        <td><strong>GRAND TOTAL</strong></td>
        <td><strong>{{ number_format($grandtotal ?? 0, 2)  }} </strong></td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="2" ></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="2" > x - x - x - x - x - x - x - x - x - x - x - x - x - x - x - x - x </td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="2" ></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="2" ><strong>NOTE:</strong></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="2" >
            {!! $header->remarks ?? '' !!}
        </td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="2" ></td>
        <td></td>
        <td></td>
    </tr>
    </tbody>
    <tfoot>
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="2" ></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td colspan="4"></td>
        <td colspan="3"></td>
    </tr>
    <tr>
        <td colspan="4">
            <strong>RETURNED BY:</strong><br/><br/>
        </td>
        <td colspan="3">
            <strong>RECEIVED BY:</strong><br/><br/>
        </td>
    </tr>
    <tr>
        <td colspan="4"></td>
        <td colspan="3"></td>
    </tr>
    <tr>
        <td colspan="4">
            <u>{{ strtoupper( $header->returned_name ?? 'NONE' ) }}</u>
        </td>
        <td colspan="3">
            <u>{{ strtoupper( $header->received_name ?? 'NONE' ) }}</u>
        </td>
    </tr>
    <tr>
        <td colspan="4">
            <span>{{ $header->returned_designation ?? '' }}&nbsp;</span>
        </td>
        <td colspan="3">
            <span>{{ $header->received_designation ?? '' }}&nbsp;</span>
        </td>
    </tr>
    <tr>
        <td colspan="4">
            <span>{{ $header->returned_office ?? '' }}&nbsp;</span>
        </td>
        <td colspan="3">
            <span>{{ $header->received_office ?? '' }}&nbsp;</span>
        </td>
    </tr>
    <tr>
        <td colspan="4"></td>
        <td colspan="3"></td>
    </tr>
    <tr>
        <td colspan="4"></td>
        <td colspan="3"></td>
    </tr>
    <tr>
        <td colspan="4">
            <strong>CERTIFIED CORRECT:</strong><br/><br/>
        </td>
        <td colspan="3">
            <strong>DISPOSAL APPROVED:</strong><br/><br/>
        </td>
    </tr>
    <tr>
        <td colspan="4"></td>
        <td colspan="3"></td>
    </tr>
    <tr>
        <td colspan="4" style="text-align: center"><u>{{ strtoupper( $header->certified_name ?? 'NONE' ) }}</u></td>
        <td colspan="3" style="text-align: center"><u>{{ strtoupper( $header->approved_name ?? 'NONE' ) }}</u></td>
    </tr>
    <tr>
        <td colspan="4" style="text-align: center"><span>{{ $header->certified_designation ?? '' }}&nbsp;</span></td>
        <td colspan="3" style="text-align: center"><span>{{ $header->approved_designation ?? '' }}&nbsp;</span></td>
    </tr>
    <tr>
        <td colspan="4" style="text-align: center"><span>{{ $header->certified_office ?? '' }}&nbsp;</span></td>
        <td colspan="3" style="text-align: center"><span>{{ $header->approved_office ?? '' }}&nbsp;</span></td>
    </tr>
    <tr>
        <td colspan="4"></td>
        <td colspan="3"></td>
    </tr>
    <tr>
        <th colspan="7" style="text-align: center;"><strong>CERTIFICATION OF INSPECTION</strong></th>
    </tr>
    <tr>
        <td colspan="7"></td>
    </tr>
    <tr>
        <td colspan="7">
            <p>I hereby certify that the properly enumarated above was disposed of as follows:</p>
        </td>
    </tr>
    <tr>
        <td colspan="7">
            <p>Item __{!! $header->disposed_by == 'destroyed' ? '<span class="check">&#10003;</span>' : '_' !!}__ Destroyed</p>
        </td>
    </tr>
    <tr>
        <td colspan="7">
            <p>Item __{!! $header->disposed_by == 'private_sale' ? '<span class="check">&#10003;</span>' : '_' !!}__ Sold at Private sale</p>
        </td>
    </tr>
    <tr>
        <td colspan="7">
            <p>Item __{!! $header->disposed_by == 'public_auction' ? '<span class="check">&#10003;</span>' : '_' !!}__ Sold at Public Auction</p>
        </td>
    </tr>
    <tr>
        <td colspan="7">
            <p>Item __{!! $header->disposed_by == 'transferred' ? '<span class="check">&#10003;</span>' : '_' !!}__ Transfered without cost to <u>{{$header->transferred_to}}</u></p>
        </td>
    </tr>
    <tr>
        <td colspan="7"></td>
    </tr>
    <tr>
        <td colspan="4"></td>
        <td colspan="3"></td>
    </tr>
    <tr>
        <td colspan="4">
            <strong>PROPERTY INSPECTOR: Name &amp; Signature:</strong>
        </td>
        <td colspan="3">
            <strong>WITNESS TO DIPOSITION: Name &amp; Signature:</strong>
        </td>
    </tr>
    <tr>
        <td colspan="4"></td>
        <td colspan="3"></td>
    </tr>
    <tr>
        <td colspan="4">
            <u>{{ strtoupper( $header->inspector_name ?? 'NONE' ) }}&nbsp;</u>
        </td>
        <td colspan="3">
            <u>{{ strtoupper( $header->witness_name ?? 'NONE' ) }}&nbsp;</u>
        </td>
    </tr>
    <tr>
        <td colspan="4">
            <span>(NAME &amp; SIGNATURE)</span>
        </td>
        <td colspan="3">
            <span>(NAME &amp; SIGNATURE)</span>
        </td>
    </tr>
    <tr>
        <td colspan="4"></td>
        <td colspan="3"></td>
    </tr>
    </tfoot>

</table>
