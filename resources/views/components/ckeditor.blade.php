{{--@props([--}}
    {{--'text',--}}
{{--])--}}

{{--<button id="toggle-edit-modal">Fill New Data</button>--}}
<div wire:ignore>
    <textarea id="{{ $attributes['id'] }}" wire:model.defer="{{ $attributes['property'] }}"></textarea>
    {{--{{ $disabled ?? false ? ' disabled' :'enabled' }}--}}
    <script>
        document.addEventListener("livewire:load", () => {
            ClassicEditor
            .create(document.querySelector(`#{{ $attributes['id'] }}`))
            .then(editor => {
                {{--editor.setData(`{{ $attributes['data'] ?? '' }}`);--}}
                editor.setData('{!! $attributes['data'] ?? '' !!}')
                // editor.setData('<p>This is the new Data!</p>');
                editor.model.document.on('change:data', (e) => {
                    @this.set('{{ $attributes['property'] }}', editor.getData());
                });
                @if(!empty($attributes['editable']) && $attributes['editable'] == 'true' )
                    editor.isReadOnly = true;
                @else
                    editor.isReadOnly = false;
                @endif
                // console.log(editor.isReadOnly );
             })
            .catch(error => {
                console.error(error);
            });

        });
    </script>
</div>
