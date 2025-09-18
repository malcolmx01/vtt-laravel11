<table cellspacing="3" bgcolor="#000000" style="border: 1px solid #000;">
    <thead>
    <tr>
        <th><strong>#</strong></th>
        <th nowrap><strong>ITEM CODE</strong></th>
        <th nowrap><strong>ITEM NAME</strong></th>
        <th><strong>DESCRIPTION</strong></th>
        <th nowrap><strong>CATEGORY</strong></th>
        <th nowrap><strong>CLASSIFICATION</strong></th>
        <th nowrap><strong>SUB CLASSIFICATION</strong></th>
        <th nowrap><strong>SIZE</strong></th>
        <th nowrap><strong>UNIT</strong></th>
        <th nowrap><strong>BEGINNING BALANCE</strong></th>
        <th nowrap><strong>IAR RECEIVED</strong></th>
        <th nowrap><strong>RIS RECEIVED</strong></th>
        <th nowrap><strong>ISSUED</strong></th>
        <th nowrap><strong>ENDING BALANCE</strong></th>
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
            <td nowrap>{{ $item->size ?? '' }}</td>
            <td nowrap>{{ $item->unit ?? '' }}</td>
            <td nowrap>{{ $item->bi_details_item_sum_on_hand_qty ?? '' }}</td>
            <td nowrap>{{ $item->iar_details_item_sum_quantity_approved ?? '' }}</td>
            <td nowrap>{{ $item->ris_details_item_sum_issued_quantity ?? '' }}</td>
            <td nowrap>{{ $item->bi_details_item_sum_issued_qty ?? '' }}</td>
            <td nowrap>{{ $item->bi_details_item_sum_on_hand_qty + $item->iar_details_item_sum_quantity_approved + $item->ris_details_item_sum_issued_quantity - $item->bi_details_item_sum_issued_qty ?? '' }}</td>
            
        </tr>
    @endforeach
    </tbody>
</table>