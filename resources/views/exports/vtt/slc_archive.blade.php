<table cellspacing="3" bgcolor="#000000" style="border: 1px solid #000;">
    <thead>
    <tr>
        <th><strong>#</strong></th>
        <th nowrap><strong>ITEM CODE (NO NEED TO EDIT)</strong></th>
        <th nowrap><strong>ITEM NAME</strong></th>
        <th><strong>DESCRIPTION</strong></th>
        <th nowrap><strong>CATEGORY</strong></th>
        <th nowrap><strong>CLASSIFICATION</strong></th>
        <th nowrap><strong>SUB CLASSIFICATION</strong></th>

        <th nowrap><strong>DISCRIPTIVE CODE</strong></th>
        <th nowrap><strong>SIZE</strong></th>

        <th nowrap><strong>COLOR</strong></th>
        <th nowrap><strong>TYPE</strong></th>
        <th nowrap><strong>BRAND</strong></th>
        <th nowrap><strong>MODEL</strong></th>

        <th nowrap><strong>UNIT</strong></th>
        <th nowrap><strong>QTY PER UNIT</strong></th>
        <th nowrap><strong>UNIT COST</strong></th>

        <th nowrap><strong>RE-ORDER POINT</strong></th>
        <th nowrap><strong>LEAD TIME</strong></th>

        <th nowrap><strong>NGAS CODE</strong></th>

        <th nowrap><strong>PROPRIETARY</strong></th>
        <th nowrap><strong>SOURCE OF ORIGIN</strong></th>
        <th nowrap><strong>PART NUMBER</strong></th>

        <th nowrap><strong>YEAR</strong></th>
        <th nowrap><strong>CHASSIS NO</strong></th>
        <th nowrap><strong>CERT OF REG. NO</strong></th>
        <th nowrap><strong>OCT TCT CCT</strong></th>
        <th nowrap><strong>TAX DEC</strong></th>
    </tr>
    </thead>
    <tbody>
    @foreach($items as $item)
        <tr>
            <td>{{ $loop->index + 1 }}</td>
            <td nowrap>{{ $item->item_code }}</td>
            <td nowrap>{{ $item->item }}</td>
            <td nowrap>{{ $item->description }}</td>
            <td nowrap>{{ $item->category->category ?? '' }}</td>
            <td nowrap>{{ $item->classification->classification ?? '' }}</td>
            <td nowrap>{{ $item->sub_classification->sub_classification ?? '' }}</td>

            <td nowrap>{{ $item->other_info ?? '' }}</td>
            <td nowrap>{{ $item->size ?? '' }}</td>

            <td nowrap>{{ $item->color ?? '' }}</td>
            <td nowrap>{{ $item->type ?? '' }}</td>
            <td nowrap>{{ $item->brand ?? '' }}</td>
            <td nowrap>{{ $item->model ?? '' }}</td>

            <td nowrap>{{ $item->unit ?? '' }}</td>
            <td nowrap>{{ $item->qty_per_unit ?? '' }}</td>
            <td nowrap>{{ $item->unit_cost ?? '' }}</td>

            <td nowrap>{{ $item->reorder_point ?? '' }}</td>
            <td nowrap>{{ $item->lead_time ?? '' }}</td>

            <td nowrap>{{ $item->ngas_code ?? '' }}</td>

            <td nowrap>{{ $item->proprietary ?? '' }}</td>
            <td nowrap>{{ $item->source_of_origin ?? '' }}</td>
            <td nowrap>{{ $item->part_no ?? '' }}</td>

            <td nowrap>{{ $item->year ?? '' }}</td>
            <td nowrap>{{ $item->chassis_no ?? '' }}</td>
            <td nowrap>{{ $item->cr_no ?? '' }}</td>

            <td nowrap>{{ $item->oct_tct_cct ?? '' }}</td>
            <td nowrap>{{ $item->tax_dec ?? '' }}</td>
        </tr>
    @endforeach
    </tbody>
</table>