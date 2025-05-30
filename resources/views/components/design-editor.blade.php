<style>
    .design-logo {
        position: absolute;
        width: 30%;
        height: auto;
        cursor: move;
        resize: both;
        overflow: hidden;
        border: 2px dashed #3b82f6;
        background-color: rgba(255, 255, 255, 0.6);
    }

    .design-logo img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        pointer-events: none;
    }

</style>

<div class="design-editor-container relative w-full bg-gray-100 rounded-lg overflow-hidden" style="padding-bottom: 100%;">
    <div id="{{ $canvasId }}-container" class="absolute inset-0">
        @if($background)
        <img src="{{ $background }}" id="{{ $canvasId }}-background" class="absolute inset-0 w-full h-full object-contain" alt="Background">
        @endif

        <div id="{{ $canvasId }}-logos-layer" class="absolute inset-0 z-10"></div>
    </div>

    <div class="mt-3 text-end">
        <input type="file" id="{{ $canvasId }}-file-input" accept="image/png, image/jpeg" hidden>
        <button type="button" onclick="document.getElementById('{{ $canvasId }}-file-input').click()" class="bg-primary-600 hover:bg-primary-700 text-white text-sm px-4 py-2 rounded shadow transition">
            + إضافة شعار
        </button>
    </div>

    <input type="hidden" id="{{ $targetInputId }}" name="{{ $targetInputId }}">
    <input type="hidden" id="{{ $targetInputId }}_logos" name="{{ $targetInputId == 'data.image_front' ? 'logo_front' : 'logo_back' }}">
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const canvasId = '{{ $canvasId }}';
        const container = document.getElementById(`${canvasId}-container`);
        const background = document.getElementById(`${canvasId}-background`);
        const logosLayer = document.getElementById(`${canvasId}-logos-layer`);
        const fileInput = document.getElementById(`${canvasId}-file-input`);
        const hiddenImageInput = document.getElementById('{{ $targetInputId }}');
        const hiddenLogosInput = document.getElementById('{{ $targetInputId }}_logos');

        const usedLogos = [];

        fileInput.addEventListener('change', (e) => {
            [...e.target.files].forEach(file => {
                const reader = new FileReader();
                reader.onload = (event) => {
                    addLogo(event.target.result, file.name);
                };
                reader.readAsDataURL(file);
            });
            fileInput.value = '';
        });

        function addLogo(src, filename) {
            const logoDiv = document.createElement('div');
            logoDiv.className = 'design-logo';
            logoDiv.style.left = '35%';
            logoDiv.style.top = '35%';
            logoDiv.setAttribute('data-filename', filename);

            const img = document.createElement('img');
            img.src = src;

            logoDiv.appendChild(img);
            logosLayer.appendChild(logoDiv);
            usedLogos.push(filename);

            enableDrag(logoDiv);
            setTimeout(saveDesign, 500);
        }

        function enableDrag(el) {
            let offsetX, offsetY;

            el.onmousedown = function(e) {
                if (e.target.tagName === 'IMG') return;

                offsetX = e.clientX - el.offsetLeft;
                offsetY = e.clientY - el.offsetTop;

                document.onmousemove = function(e) {
                    el.style.left = (e.clientX - offsetX) + 'px';
                    el.style.top = (e.clientY - offsetY) + 'px';
                };

                document.onmouseup = function() {
                    document.onmousemove = null;
                    document.onmouseup = null;
                    saveDesign();
                };
            };
        }

        function saveDesign() {
            if (!background) return;

            const canvas = document.createElement('canvas');
            canvas.width = container.offsetWidth;
            canvas.height = container.offsetHeight;

            const ctx = canvas.getContext('2d');

            const bgImg = new Image();
            bgImg.crossOrigin = 'anonymous';
            bgImg.src = background.src;

            bgImg.onload = () => {
                ctx.drawImage(bgImg, 0, 0, canvas.width, canvas.height);

                const logos = logosLayer.querySelectorAll('.design-logo');
                let count = 0;

                logos.forEach(logo => {
                    const img = logo.querySelector('img');
                    const x = logo.offsetLeft;
                    const y = logo.offsetTop;
                    const w = logo.offsetWidth;
                    const h = logo.offsetHeight;

                    const logoImg = new Image();
                    logoImg.src = img.src;
                    logoImg.onload = () => {
                        ctx.drawImage(logoImg, x, y, w, h);
                        count++;

                        if (count === logos.length) {
                            hiddenImageInput.value = canvas.toDataURL('image/png', 0.9);
                            hiddenImageInput.dispatchEvent(new Event('change'));
                            hiddenLogosInput.value = JSON.stringify(usedLogos);
                        }
                    };
                });
            };
        }
    });

</script>
@endpush
