<table>
    <thead>
        <tr>
            <th></th>
            <th colspan="7"></th>
            <th></th>
        </tr>
        <tr>
            <th colspan="9">Republic of the Philippines</th>
        </tr>
        <tr>
            <th colspan="9"><strong>DEPARTMENT OF EDUCATION</strong></th>
        </tr>
        <tr>
            <th colspan="9">Pasig City, Metro Manila</th>
        </tr>
        <tr>
            <th colspan="9"></th>
        </tr>
        <tr>
            <th colspan="7"></th>
            <th colspan="2"></th>
        </tr>
        <tr>
            <td colspan="9"><h2>PROPERTY RETURN SLIP</h2></td>
        </tr>
        <tr>
            <td colspan="7"><strong>Purpose:</strong>
                @if($header->purpose == 'disposal')
                    (/) Disposal
                @elseif($header->purpose == 'repair')
                    (/) Repair
                @elseif($header->purpose == 'return')
                    (/) Return to Stock
                @elseif($header->purpose == 'other')
                    ( &nbsp; / &nbsp; ) Others : {{$header->other_purpose ?? ''}}
                @endif
                {{--({{($header->purpose == 'disposal') ? "&#10003;" : ""}})Disposal--}}
                {{--({{($header->purpose == 'repair') ? "&#10003;" : ""}})Repair--}}
                {{--({{($header->purpose == 'return') ? "&#10003;" : ""}})Return to Stock--}}
                {{--({{($header->purpose == 'other') ? "&#10003;" : ""}})Others {{$header->other_purpose ?? ''}}--}}
            </td>
            <td colspan="2">
                <strong>PRS No.: {{$header->prs_no ?? ''}}</strong>
            </td>
        </tr>
        <tr>
            <th>QTY</th>
            <th>UNIT</th>
            <th>DESCRIPTION</th>
            <th>PROPERTY<br/>NUMBER</th>
            <th>FPP/ACCT<br/>CODE</th>
            <th>DATE<br/>ACQUIRED</th>
            <th>NAME OF END-USER/<br/>OFFICE OF ORIGIN</th>
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
                    {{$itemDetails->quantity ?? ''}}
                </td>
                <td>
                    {{$itemDetails->unit_description ?? ''}}
                </td>
                <td>
                    <p>{{$itemDetails->item}}</p><br/>
                    {!! $itemDetails->details !!}
                    <br/><br/>
                </td>
                <td>
                    {{$itemDetails->property_no ?? ''}}
                </td>
                <td>
                    {{$itemDetails->acct_code ?? ''}}
                </td>
                <td>
                    @if(!empty($itemDetails->acquired))
                        {{ \Carbon\Carbon::parse($itemDetails->acquired)->format('M d, Y')  }}
                    @endif
                </td>
                <td>
                    {{$itemDetails->end_user_name ?? ''}} / {{$itemDetails->officeuser->dept_name ?? ''}}
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
            <td></td>
            <td>No item(s)</td>
            <td></td>
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
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="4">I HEREBY CERTIFY that I have this ______________</td>
            <td colspan="5">I HEREBY CERTIFY that I have this ______________</td>
        </tr>
        <tr>
            <td colspan="4">
                RETURNED to ____________________________________________
            </td>
            <td colspan="5">
                RECEIVED from ____________________________________________
            </td>
        </tr>
        <tr>
            <td colspan="4">
                the Items/articles described above.
            </td>
            <td colspan="5">
                the Items/articles described above.
            </td>
        </tr>
        <tr>
            <td colspan="4"></td>
            <td colspan="5"></td>
        </tr>
        <tr>
            <td colspan="4"></td>
            <td colspan="5"></td>
        </tr>

        <tr>
            <td colspan="4">
                <strong>{{ strtoupper( $header->returned_name ?? '' ) }}</strong>
            </td>
            <td colspan="5">
                <strong>{{ strtoupper( $header->received_name ?? '' ) }}</strong>
            </td>
        </tr>
        <tr>
            <td colspan="4">
                {{ $header->returned_office ?? '' }}
            </td>
            <td colspan="5">
                {{ $header->received_office ?? '' }}
            </td>
        </tr>
        <tr>
            <td colspan="4"></td>
            <td colspan="5"></td>
        </tr>
    </tfoot>

</table>
