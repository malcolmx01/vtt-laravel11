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
            <td colspan="3"><h2>PURCHASE REQUEST</h2></td>
            <td colspan="3">
                Annex G-5
                <br>
                COA Circular No. 2001-04, S. 2001
            </td>
        </tr>

        <tr>
            <td colspan="3" rowspan="3">
                <p>REQUISITIONING OFFICE:</p>
                <p style="text-align: center">{{$prHeader->office->dept_name ?? ''}}</p>
            </td>
            <td colspan="2">P.R. No.: {{$prHeader->pr_no ?? ''}}</td>
            <td>Date: {{ date('m/d/Y', strtotime($prHeader->pr_date)) }}</td>
        </tr>
        <tr>
            {{--<td colspan="2">SAI No.:_____________________</td>--}}
            <td colspan="2">SAI No.:</td>
            {{--<td>Date: _____________</td>--}}
            <td>Date: </td>
        </tr>
        <tr>
            {{--<td colspan="2">ALOBS No.:__________________</td>--}}
            <td colspan="2">ALOBS No.:</td>
            <td>Date: </td>
            {{--<td>Date: _____________</td>--}}
        </tr>
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
    @forelse($prDetailItems as $itemKey => $itemDetails)
        @php
            $total_per_category = 0;
        @endphp
        <tr class="table-primary">
            <td></td>
            <td></td>
            <td><strong style="text-transform: uppercase">{{ $itemKey }}</strong></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        @foreach($itemDetails as $key => $value)
            <tr>
                <td>
                    {{$value['items']['ngas_code'] ? $value['items']['ngas_code'] : $value['items']['id']}}
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
                $total_per_category += $value['item_total_cost'];
            @endphp
        @endforeach
        @if( !empty($total_per_category))
            <tr class="table-active">
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td><strong>Sub Total</strong></td>
                <td><strong>{{ $total_per_category ? number_format((int) array_sum((array) $total_per_category ?? 0), 2) : '' }} </strong></td>
            </tr>
        @endif
    @empty
        <tr>
            <td colspan="6" class="text-center"><p class="bg-lighten p-5"><strong>No item(s) selected</strong></p></td>
        </tr>
    @endforelse
    <tr class="table-warning">
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td><strong>Grand Total</strong></td>
        <td><strong>{{ number_format($prHeader->pr_amount, 2)  }} </strong></td>
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
        <td><strong>CERTIFICATION:</strong></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td>
            <p>
                This is to certify that the herein requisitioned<br/>
                items are included in the approved APP
            </p>

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
    <tr>
        <td></td>
        <td></td>
        <td><u><strong>MARIA CLARA DELA CRUZ</strong></u></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td>Head Procurement</td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    {{--@endif--}}
    </tbody>
    <tfoot>
        <tr>
            <td colspan="2"><strong>Purpose: </strong></td>
            <td colspan="4" rowspan="2">
                <p>{{ $prHeader->purpose ?? '' }}</p>
            </td>
        </tr>
        <tr>
            <td colspan="2"></td>
        </tr>
        <tr>
            <td colspan="2"></td>
            <td>
                <strong>RECOMMENDING APPROVAL:</strong>
            </td>
            <td colspan="3">
                <strong>APPROVED BY:</strong>
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
                <strong>{{ strtoupper( $prHeader->prepared_name ?? '' ) }}</strong>
            </td>
            <td colspan="3">
                <strong>{{ strtoupper( $prHeader->approved_name ?? '' ) }}</strong>
            </td>
        </tr>
        <tr>
            <td colspan="2"><strong>Designation</strong></td>
            <td>
                {{ $prHeader->prepared_designation ?? '' }}
            </td>
            <td colspan="3">
                {{ $prHeader->approved_designation ?? '' }}
            </td>
        </tr>
    </tfoot>

</table>
