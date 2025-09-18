<table>
    <thead>
        <tr>
            <th colspan="2" rowspan="5"></th>
            <th colspan="5"></th>
            <th></th>
        </tr>
        <tr>
            <th colspan="5">Republic of the Philippines</th>
            <th></th>
        </tr>
        <tr>
            <th colspan="5"><strong>DEPARTMENT OF EDUCATION</strong></th>
            <th></th>
        </tr>
        <tr>
            <th colspan="5">Pasig City, Metro Manila</th>
            <th></th>
        </tr>
        <tr>
            <th colspan="5"></th>
        </tr>
        <tr>
            <td colspan="8"><strong>ARE No.: {{$header->are_no ?? ''}}</strong></td>
        </tr>

        <tr>
            <td colspan="8"><h2>Acknowledgement Receipt for Equipment</h2></td>
        </tr>
        <tr>
            <th>ITEM NO.</th>
            <th>UNIT</th>
            <th>ITEM/DESCRIPTION</th>
            <th>QTY.</th>
            <th>PROPERTY<br>NO.</th>
            <th>SERIAL<br>NO.</th>
            <th>ESTIMATED<br>UNIT COST</th>
            <th>ESTIMATED<br>TOTAL COST</th>
        </tr>
    </thead>
    <tbody>
    @php
        $grandtotal = 0;
    @endphp
    @forelse($details as $itemKey => $itemDetails)
            <tr>
                <td>
                    {{$itemDetails->id}}
                </td>
                <td>
                    {{$itemDetails->item_unit}}
                </td>
                <td>
                    {{$itemDetails->item}}
                    {{ strip_tags($itemDetails->details ?? '') }}
                    <br/>
                    <br/>
                    @if(!empty($itemDetails->brand))
                        Brand/Manufacturer: {{$itemDetails->brand }} <br/>
                    @endif
                    @if(!empty($itemDetails->model))
                        Model: {{$itemDetails->model }} <br/>
                    @endif
                    @if(!empty($itemDetails->year))
                        Year: {{$itemDetails->year }} <br/>
                    @endif
                    @if(!empty($itemDetails->part_no))
                        Part No.: {{$itemDetails->part_no }} <br/>
                    @endif
                    @if(!empty($itemDetails->cr_no))
                        CR No.: {{$itemDetails->cr_no }} <br/>
                    @endif
                    @if(!empty($itemDetails->chassis_no))
                        Chassis No.: {{$itemDetails->chassis_no }} <br/>
                    @endif
                    @if(!empty($itemDetails->engine_no))
                        Engine No.: {{$itemDetails->engine_no }} <br/>
                    @endif

{{--                    {{ $itemDetails->property_no ? 'Property No.: '.$itemDetails->property_no : '' }}--}}
{{--                    <br/>--}}
{{--                    {{ $itemDetails->serial_no ? 'Serial No.: '.$itemDetails->serial_no : '' }}--}}
{{--                    <br/>--}}
{{--                    {{ $itemDetails->brand ? 'Brand/Manufacturer: '.$itemDetails->brand : '' }}--}}
{{--                    <br/>--}}
{{--                    {{ $itemDetails->model ? 'Model: '.$itemDetails->model : '' }}--}}
{{--                    <br/>--}}
{{--                    {{ $itemDetails->year ? 'Year: '.$itemDetails->year : '' }}--}}
{{--                    <br/>--}}
{{--                    {{ $itemDetails->part_no ? 'Part No.: '.$itemDetails->part_no : '' }}--}}
{{--                    <br/>--}}
{{--                    {{ $itemDetails->cr_no ? 'CR No.: '.$itemDetails->cr_no : '' }}--}}
{{--                    <br/>--}}
{{--                    {{ $itemDetails->chassis_no ? 'Chassis No.: '.$itemDetails->chassis_no : '' }}--}}
{{--                    <br/>--}}
{{--                    {{ $itemDetails->engine_no ? 'Engine No.: '.$itemDetails->engine_no : '' }}--}}
{{--                    <br/>--}}

{{--                    {!! $itemDetails->property_no ? '<strong>Property No.: </strong>'.$itemDetails->property_no .'<br/>' : '' !!}--}}
{{--                    {!! $itemDetails->serial_no ? '<strong>Serial No.: </strong>'.$itemDetails->serial_no .'<br/>' : '' !!}--}}
{{--                    {!! $itemDetails->brand ? '<strong>Brand/Manufacturer: </strong>'.$itemDetails->brand .'<br/>' : '' !!}--}}
{{--                    {!! $itemDetails->model ? '<strong>Model: </strong>'.$itemDetails->model .'<br/>' : '' !!}--}}
{{--                    {!! $itemDetails->year ? '<strong>Year: </strong>'.$itemDetails->year .'<br/>' : '' !!}--}}
{{--                    {!! $itemDetails->part_no ? '<strong>Part No.: </strong>'.$itemDetails->part_no .'<br/>' : '' !!}--}}
{{--                    {!! $itemDetails->cr_no ? '<strong>CR No.: </strong>'.$itemDetails->cr_no .'<br/>' : '' !!}--}}
{{--                    {!! $itemDetails->chassis_no ? '<strong>Chassis No.: </strong>'.$itemDetails->chassis_no .'<br/>' : '' !!}--}}
{{--                    {!! $itemDetails->engine_no ? '<strong>Engine No.: </strong>'.$itemDetails->engine_no .'<br/>' : '' !!}--}}
                </td>
                <td>
                    {{ number_format( $itemDetails->item_total_qty ) }}
                </td>
                <td>
                    {{$itemDetails->property_no ?? '' }}
                </td>
                <td>
                    {{$itemDetails->serial_no ?? '' }}
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
        </tr>
    @endforelse
    <tr class="table-warning">
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
    </tr>
    <tr>
        <td></td>
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
        <td></td>
    </tr>
    <tr>
        <td></td>
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
        </tr>
        <tr>
            <td colspan="3">
                <strong>Received from:</strong>
            </td>
            <td colspan="5">
                <strong>Received by:</strong>
            </td>
        </tr>
        <tr>
            {{--<td colspan="3"><img src="storage/project_attachment/vzSAQuUcickSKcPkxdNmzBvm3p8sJuSnFK3wdy9E.png" alt=""></td>--}}
            {{--<td colspan="3"><img src="{{public_path('demo1/media/logos/DepEd-logo.png')}}" style="width: 250px !important; height: auto;" alt=""></td>--}}
            <td colspan="3"></td>
            <td colspan="5"></td>
        </tr>
        <tr>
            <td colspan="3"></td>
            <td colspan="5"></td>
        </tr>
        <tr>
            <td colspan="3">
                <strong>{{ strtoupper( $header->received_from_name ?? '' ) }}</strong>
            </td>
            <td colspan="5">
                <strong>{{ strtoupper( $header->received_by_name ?? '' ) }}</strong>
            </td>
        </tr>
        <tr>
            <td colspan="3">
                {{ $header->received_from_designation ?? '' }}
            </td>
            <td colspan="5">
                {{ $header->received_by_designation ?? '' }}
            </td>
        </tr>
        <tr>
            <td colspan="3">
                Date: ___________________________
            </td>
            <td colspan="5">
                Date: ___________________________
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <strong>Acknowledged/Noted by:</strong>
            </td>
            <td colspan="5">
                <strong>Acknowledged/Noted by:</strong>
            </td>
        </tr>
        <tr>
            <td colspan="3"></td>
            <td colspan="5"></td>
        </tr>
        <tr>
            <td colspan="3"></td>
            <td colspan="5"></td>
        </tr>
        <tr>
            <td colspan="3">
                <strong>{{ strtoupper( $header->acknowledged_from_name ?? '' ) }}</strong>
            </td>
            <td colspan="5">
                <strong>{{ strtoupper( $header->acknowledged_by_name ?? '' ) }}</strong>
            </td>
        </tr>
        <tr>
            <td colspan="3">
                {{ $header->acknowledged_from_office ?? '' }}
            </td>
            <td colspan="5">
                {{ $header->acknowledged_by_office ?? '' }}
            </td>
        </tr>
        <tr>
            <td colspan="3">
                {{ $header->acknowledged_from_designation ?? '' }}
            </td>
            <td colspan="5">
                {{ $header->acknowledged_by_designation ?? '' }}
            </td>
        </tr>
    </tfoot>

</table>

