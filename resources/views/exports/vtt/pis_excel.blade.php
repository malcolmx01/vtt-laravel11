<table>
    <thead>
        <tr>
            <th></th>
            <th colspan="5"></th>
            <th></th>
        </tr>
        <tr>
            <th colspan="7">Republic of the Philippines</th>
        </tr>
        <tr>
            <th colspan="7"><strong>DEPARTMENT OF EDUCATION</strong></th>
        </tr>
        <tr>
            <th colspan="7">Pasig City, Metro Manila</th>
        </tr>
        <tr>
            <th colspan="7"></th>
        </tr>
        <tr>
            <td colspan="7"><strong>{{$header->office->dept_name ?? ''}}</strong></td>
        </tr>
        <tr>
            <td colspan="7"><strong>PIS No.: {{$header->pis_no ?? ''}}</strong></td>
        </tr>
        <tr>
            <td colspan="7"><h2>PROPERTY ISSUE SLIP</h2></td>
        </tr>
        <tr>
            <th>QTY</th>
            <th>DESCRIPTION</th>
            <th>DATE OF<br/>PURCHASE</th>
            <th>PROPERTY<br/>NUMBER</th>
            <th>CLASSIFICATION<br/>NUMBER</th>
            <th>UNIT VALUE</th>
            <th>TOTAL VALUE</th>
        </tr>
    </thead>
    <tbody>
    @php
        $grandtotal = 0;
    @endphp
    @forelse($details as $itemKey => $itemDetails)
            <tr>
                <td>
                    {{$itemDetails->quantity}}
                </td>
                <td>
                    <p>{{$itemDetails->item}}</p><br/>
                    {!! $itemDetails->details !!}
                    <br/><br/>
                </td>
                <td>
                    @if(!empty($itemDetails->po_date))
                        {{ \Carbon\Carbon::parse($itemDetails->po_date)->format('M d, Y')  }}
                    @endif
                </td>
                <td>
                    {{$itemDetails->property_no}}
                </td>
                <td>
                    {{$itemDetails->classification_no}}
                </td>
                <td>
                    {{ number_format($itemDetails->item_unit_cost, 2)  ?? '' }}
                </td>
                <td>
                    {{ $itemDetails->item_total_cost ? number_format($itemDetails->item_total_cost, 2) : '' }}
                </td>
            </tr>
        @php
            $grandtotal += $itemDetails->item_total_cost;
        @endphp
    @empty
        <tr>
            <td></td>
            <td>No item(s)</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    @endforelse
    <tr class="table-warning">
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td><strong>GRAND TOTAL</strong></td>
        <td><strong>{{ number_format($grandtotal ?? 0, 2)  }} </strong></td>
    </tr>
    <tr>
        <td></td>
        <td></td>
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
        <td></td>
    </tr>
    <tr>
        <td></td>
        <td><strong>NOTE:</strong></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td></td>
        <td>
            {!! $header->remarks ?? '' !!}
        </td>
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
        <td></td>
        <td></td>
    </tr>
    </tbody>
    <tfoot>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="3">
                <strong>Transferor</strong>
            </td>
            <td colspan="4">
                <strong>Transferee</strong>
            </td>
        </tr>
        <tr>
            <td colspan="3"></td>
            <td colspan="4"></td>
        </tr>
        <tr>
            <td colspan="3">I HEREBY CERTIFY that I have this _______ day of _______________</td>
            <td colspan="4">I HEREBY CERTIFY that I have this _______ day of _______________</td>
        </tr>
        <tr>
            <td colspan="3"></td>
            <td colspan="4"></td>
        </tr>
        <tr>
            <td colspan="3"></td>
            <td colspan="4"></td>
        </tr>

        <tr>
            <td colspan="3">
                <strong>{{ strtoupper( $header->transferor_name  ?? '' ) }} </strong>
            </td>
            <td colspan="4">
                {{--<strong>{{ strtoupper( $header->received_by_name ?? '' ) }}</strong>--}}
                <strong>{{ strtoupper( $header->transferee_name  ?? '' ) }} </strong>
            </td>
        </tr>
        <tr>
            <td colspan="3">(Name &amp; Designation)</td>
            <td colspan="4">(Name &amp; Designation)</td>
        </tr>
        <tr>
            <td colspan="3">
                {{ $header->transferor_office ?? '' }}
            </td>
            <td colspan="4">
                {{ $header->transferee_office ?? '' }}
            </td>
        </tr>
        <tr>
            <td colspan="3">(Office/Department/Agency)</td>
            <td colspan="4">(Office/Department/Agency)</td>
        </tr>
        <tr>
            <td colspan="3">the Items/articles described above.</td>
            <td colspan="4">The above-listed articles for the use Provincewide,</td>
        </tr>
        <tr>
            <td colspan="3"></td>
            <td colspan="4"></td>
        </tr>
    </tfoot>

</table>
