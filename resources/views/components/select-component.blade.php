<div>
    <div wire:ignore.self x-data="{ }" x-init="() => {
	$('.select2').select2();
	$('.select2').on('change', function(e) {
alert('hi hello Jesus');
	let elementName = $(this).attr('id');
	@this.set(elementName, e.target.value);
		Livewire.hook('message.processed', (m, component) => {
			$('.select2').select2();
		})
	})
}">
        <select class="select2" {{$attributes}} style="width: 100%;">
            <option value="">--- Select Category ---</option>
            @foreach ($options as $option)
                <option value="{{$option->id}}">{{$option->category}}</option>
            @endforeach
        </select>
    </div>
</div>
