<table>
    <thead>
        <tr>
            <td colspan="6"></td>
        </tr>
        <tr>
            <th colspan="6"><strong>DEPARTMENT OF EDUCATION</strong></th>
        </tr>
        <tr>
            <th colspan="6">Pasig City, Metro Manila</th>
        </tr>
        <tr>
            <td colspan="6"></td>
        </tr>
        <tr>
            <th colspan="6"><strong>PURCHASE ORDER</strong></th>
        </tr>
        <tr>
            <td colspan="6"></td>
        </tr>
        <tr>
            <td>Supplier</td>
            <td colspan="2"><strong>: BLUE CHIP MARKETING</strong></td>
            <td>P.O. No.</td>
            <td>: 2020c-USEC1(004)-AC-NPSVP018P003</td>
        </tr>
        <tr>
            <th>STARTING<br/>DATE</th>
            <th>COMPLETION<br/>DATE</th>

            <th>PERSONAL<br/>SERVICES<br/>(PS)</th>
            <th>MAINTENANCE AND OTHER<br/>OPERATING EXPENSES<br/>(MOOE)</th>
            <th>CAPITAL<br/>OUTLAY<br/>(CO)</th>
            <th>TOTAL</th>

            <th>CLIMATE<br/>CHANGE<br/>ADAPTATION</th>
            <th>CLIMATE<br/>CHANGE<br/>MITIGATION</th>
        </tr>
    </thead>
    <tbody>
    @php
        $grand_total_ps = 0;
        $grand_total_mooe = 0;
        $grand_total_capital_outlay = 0;
        $grand_total_services = 0;
    @endphp
    @forelse($Projects as $itemKey => $itemDetails)
        <tr class="table-primary">
            <th colspan="14" class="text-center" style="background-color: #0b0e18 !important;"><strong style="text-transform: uppercase">{{ $itemKey ? $itemKey : 'NONE' }}</strong></th>
        </tr>
        @php
            $total_per_services = 0;
            $total_per_ps = 0;
            $total_per_mooe = 0;
            $total_per_capital_outlay = 0;
        @endphp
        @foreach($itemDetails as $key => $value)
            <tr>
                <td>
                    {{$value['aip_ref_no']}}
                </td>
                <td>
                    {{$value['project']}}
                </td>
                <td>
                    {{$value['implementing_agency']}}
                </td>
                <td>
                    {{ date('m/d/Y', strtotime($value['target_start_date'])) }}
                </td>
                <td>
                    {{ date('m/d/Y', strtotime($value['target_end_date'])) }}
                </td>
                <td>
                    {{$value['expected_output']}}
                </td>
                <td>
                    {{$value['fund_source']}}
                </td>
                <td>
                    {{number_format($value['ps'],2)}}
                </td>
                <td>
                    {{number_format($value['mooe'],2)}}
                </td>
                <td>
                    {{number_format($value['capital_outlay'],2)}}
                </td>
                <td>
                    {{number_format(($value['amount_total'] ?? 0), 2)}}
                </td>
                <td>
                    {{number_format($value['cc_adaptation'],2)}}
                </td>
                <td>
                    {{number_format($value['cc_mitigation'],2)}}
                </td>
                <td>
                    {{$value['cc_typology_code']}}
                </td>
            </tr>
            @php
                $total_per_ps += $value['ps'];
                $total_per_mooe += $value['mooe'];
                $total_per_capital_outlay += $value['capital_outlay'];
                $total_per_services += $value['amount_total'];

                $grand_total_ps += $value['ps'];
                $grand_total_mooe += $value['mooe'];
                $grand_total_capital_outlay += $value['capital_outlay'];
                $grand_total_services += $value['amount_total'];
            @endphp
        @endforeach
        <tr class="table-warning">
            <td colspan="7"><strong>Sub Total</strong></td>
            <td><strong>{{ number_format($total_per_ps ?? 0, 2)  }}</strong></td>
            <td><strong>{{ number_format($total_per_mooe ?? 0, 2)  }}</strong></td>
            <td><strong>{{ number_format($total_per_capital_outlay ?? 0, 2)  }}</strong></td>
            <td><strong>{{ number_format($total_per_services ?? 0, 2)  }} </strong></td>
            <td colspan="3"></td>
        </tr>

    @empty
        <tr>
            <td colspan="14" class="text-center"><p class="bg-lighten p-5"><strong>No item(s) selected</strong></p></td>
        </tr>
    @endforelse
    <tr class="table-warning">
        <td colspan="7"><strong>Grand Total</strong></td>
        <td><strong>{{ number_format($grand_total_ps, 2)  }} </strong></td>
        <td><strong>{{ number_format($grand_total_mooe, 2)  }} </strong></td>
        <td><strong>{{ number_format($grand_total_capital_outlay, 2)  }} </strong></td>
        <td><strong>{{ number_format($grand_total_services, 2)  }} </strong></td>
        <td colspan="3"></td>
    </tr>
    </tbody>
</table>
