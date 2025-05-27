<x-filament-panels::page>
    <div>
        <div id="editor-front" style="height: 600px; width: 800px"></div>
        <input type="hidden" id="{{ $targetInputId }}" name="{{ $targetInputId }}" x-model="data">
    </div>

    @once
    @push('scripts')
    <script src="{{ asset('path/to/tui-image-editor.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('path/to/tui-image-editor.css') }}">
    @endpush
    @endonce

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.getElementById('editor-front');
            const background = "{{ $background }}";
            const logo = "{{ $logo }}";
            const targetInputId = "{{ $targetInputId }}";

            const editor = new tui.ImageEditor(container, {
                includeUI: {
                    loadImage: {
                        path: background
                        , name: 'background'
                    , }
                    , theme: {
                        'common.bi.image': ''
                        , 'common.bisize.width': '0px'
                        , 'common.backgroundImage': 'none'
                    , }
                    , menu: ['shape', 'filter']
                    , initMenu: 'filter'
                    , uiSize: {
                        width: '800px'
                        , height: '600px'
                    }
                }
                , cssMaxWidth: 800
                , cssMaxHeight: 600
            });

            // إضافة الشعار كطبقة قابلة للتعديل
            editor.addImageObject(logo).then(objectProps => {
                editor.setActiveObject(objectProps.id);
            });

            // حفظ التصميم عند التحديث
            editor.on('objectActivated', () => {
                const dataURL = editor.toDataURL();
                document.getElementById(targetInputId).value = dataURL;
            });
        });

    </script>
</x-filament-panels::page>
