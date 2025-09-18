<table>
    <thead>
        <tr>
            <th><strong>#</strong></th>
            <th><strong>CODE</strong></th>
            <th><strong>SUB CLASSIFICATION</strong></th>
            <th><strong>DESCRIPTION</strong></th>
            <th><strong>CLASSIFICATION</strong></th>
            <th><strong>CLASSIFICATION CODE</strong></th>
            <th><strong>CLASSIFICATION ID</strong></th>
            <th><strong>CATEGORY</strong></th>
            <th><strong>CATEGORY CODE</strong></th>
            <th><strong>CATEGORY ID</strong></th>
            <th><strong>REMARKS</strong></th>
            <th><strong>STATUS</strong></th>

        </tr>
    </thead>
    <tbody>
    @foreach($subclassifications as $subclassification)
        <tr>
            <td>{{ $loop->index + 1 }}</td>
            <td nowrap>{{ $subclassification->code }}</td>
            <td nowrap>{{ $subclassification->sub_classification }}</td>
            <td nowrap>{{ $subclassification->description }}</td>
            <td nowrap>{{ $subclassification->classification->classification ?? '' }}</td>
            <td nowrap>{{ $subclassification->classification_code }}</td>
            <td nowrap>{{ $subclassification->classification_id }}</td>
            <td nowrap>{{ $subclassification->category->category ?? '' }}</td>
            <td nowrap>{{ $subclassification->category_code }}</td>
            <td nowrap>{{ $subclassification->category_id }}</td>
            <td nowrap>{{ $subclassification->remarks }}</td>
            <td nowrap>{{ $subclassification->status }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
