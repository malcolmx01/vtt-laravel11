<div wire:ignore>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.min.css" />
    <input id="{{ $trixId }}" type="hidden" name="content" value="{{ $value }}">
    <trix-editor wire:ignore input="{{ $trixId }}" ></trix-editor>

    <style type="text/css">
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
        [data-trix-button-group="file-tools"] {
            display: none!important;
        }

    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.min.js"></script>
    <script>
        var trixEditor = document.getElementById("{{ $trixId }}");

        /*addEventListener("trix-blur", function(event) {
            @this.set('value', trixEditor.getAttribute('value'))
        });*/

        addEventListener("trix-change", function(event) {
            @this.set('value', trixEditor.getAttribute('value'))
        });

    </script>
</div>


