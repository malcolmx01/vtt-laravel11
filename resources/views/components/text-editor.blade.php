@props(['id'=>Str::random(5),'editorheight'=>null])
<div x-data="{textEditor:@entangle($attributes->wire('model')).defer}"
     x-init="()=>{setEditor{{$id}}Value(textEditor)}"
     @reseteditor{{$id}}.window="setEditorValue('');"
     wire:ignore>
    <input x-ref="editor{{$id}}"
           id="editor-x{{$id}}"
           type="hidden"
           name="content">
    <trix-editor id="editor{{$id}}"  input="editor-x{{$id}}"
                 x-on:trix-change="textEditor=$refs.editor{{$id}}.value;"
    ></trix-editor>
</div>

@once
@push('scripts')
    {{--<script type="text/javascript" src="/js/trix.js"></script>--}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.min.js"></script>
@endpush
@endonce


@push('scripts')
    <script>
        function setEditor{{$id}}Value(value) {
            let element{{$id}}= document.getElementById("editor{{$id}}");
            let input = document.getElementById("editor-x{{$id}}");
            if(value=='') {
                input.value = "";
                element.innerHTML = "";
            }
            else {
                element{{$id}}.editor.insertHTML(value);
            }
        }
    </script>
@endpush

@push('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.min.css" />
    {{--<link rel="stylesheet" type="text/css" href="/css/trix.css">--}}
    <style>
        trix-editor{
            font-family: Poppins, Arial, sans-serif;
            font-weight: 500;
            background-color: #F5F8FA;
            border-color: #F5F8FA;
            border: transparent !important;
            padding: 12px 15px !important;
            color: #5E6278;
        }
        trix-editor:focus{
            background-color: #eef3f7 !important;
            border-color: #eef3f7 !important;
            color: #5E6278 !important;
        }

    </style>
@endpush
