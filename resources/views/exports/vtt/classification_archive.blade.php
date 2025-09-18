<table>
    <thead>
        <tr>
            <th><strong>#</strong></th>
            <th><strong>CODE</strong></th>
            <th><strong>CLASSIFICATION</strong></th>
            <th><strong>DESCRIPTION</strong></th>
            <th><strong>CATEGORY</strong></th>
            <th><strong>CATEGORY CODE</strong></th>
            <th><strong>CATEGORY ID</strong></th>

        </tr>
    </thead>
    <tbody>
    @foreach($classifications as $classification)
        <tr>
            <td>{{ $loop->index + 1 }}</td>
            <td nowrap>{{ $classification->code }}</td>
            <td nowrap>{{ $classification->classification }}</td>
            <td nowrap>{{ $classification->description }}</td>
            <td nowrap>{{ $classification->category->category ?? '' }}</td>
            <td nowrap>{{ $classification->category_code }}</td>
            <td nowrap>{{ $classification->category_id }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
