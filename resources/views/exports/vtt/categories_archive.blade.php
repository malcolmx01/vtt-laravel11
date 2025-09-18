<table>
    <thead>
        <tr>
            <th><strong>#</strong></th>
            <th><strong>CODE</strong></th>
            <th><strong>CATEGORY</strong></th>
            <th><strong>DESCRIPTION</strong></th>
            <th><strong>DETAILS</strong></th>
            <th><strong>ACCESS ROLES</strong></th>
            <th><strong>GROUP</strong></th>
            <th><strong>STATUS</strong></th>
        </tr>
    </thead>
    <tbody>
    @foreach($categories as $category)
        <tr>
            <td>{{ $loop->index + 1 }}</td>
            <td nowrap>{{ $category->code }}</td>
            <td nowrap>{{ $category->category }}</td>
            <td nowrap>{{ $category->description }}</td>
            <td nowrap>{{ $category->details }}</td>
            <td nowrap>{{ $category->access_role }}</td>
            <td nowrap>{{ $category->group }}</td>
            <td nowrap>{{ $category->status }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
