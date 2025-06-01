{{-- resources/views/components/design-editor.blade.php --}}
@props([
'background' => null,
'initialLogos' => [],
'targetInputId',
'canvasId',
])

<style>
    .design-editor-wrapper {
        position: relative;
    }

    .design-editor-container {
        position: relative;
        width: 100%;
        overflow: hidden;
        border: 1px dashed #d1d5db;
        border-radius: 0.375rem;
        background-color: transparent;
    }

    .design-logo {
        position: absolute;
        width: 15%;
        height: auto;
        cursor: grab;
        resize: both;
        overflow: hidden;
        border: 2px dashed #3b82f6;
        background-color: rgba(255, 255, 255, 0.5);
        box-sizing: border-box;
        touch-action: none;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .design-logo img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
        pointer-events: none;
    }

    .design-logo.selected {
        border: 2px solid #ef4444;
        z-index: 20;
    }

    .delete-logo-button {
        position: absolute;
        top: -10px;
        right: -10px;
        background-color: #ef4444;
        color: white;
        border-radius: 50%;
        width: 24px;
        height: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        cursor: pointer;
        z-index: 30;
        border: 1px solid white;
    }

</style>

<div x-data="designEditor({
    canvasId: '{{ $canvasId }}',
    background: '{{ $background }}',
    initialLogos: @json($initialLogos),
    targetInputId: '{{ $targetInputId }}'
})" x-init="setTimeout(() => init(), 0)" wire:key="{{ $canvasId }}">

    <div class="design-editor-wrapper bg-transparent rounded-lg p-4">

        {{-- Controls --}}
        <div class="mb-3 flex justify-between items-center">
            <div class="space-x-2 rtl:space-x-reverse">
                <button type="button" @click="$refs.fileInput.click()" class="bg-blue-600 hover:bg-blue-700 text-white text-sm px-4 py-2 rounded shadow transition">
                    + إضافة شعار
                </button>
                <button type="button" @click="deleteSelectedLogo()" x-show="selectedLogo !== null" class="bg-red-600 hover:bg-red-700 text-white text-sm px-4 py-2 rounded shadow transition">
                    حذف المحدد
                </button>
                <button type="button" @click="resetCanvas()" class="bg-gray-600 hover:bg-gray-700 text-white text-sm px-4 py-2 rounded shadow transition">
                    إعادة تعيين
                </button>
                <button type="button" @click="saveDesignState()" class="bg-green-600 hover:bg-green-700 text-white text-sm px-4 py-2 rounded shadow transition">
                    حفظ التصميم
                </button>
            </div>
            <input type="file" x-ref="fileInput" :id="`${canvasId}-file-input`" accept="image/png, image/jpeg, image/svg+xml" hidden multiple>
        </div>

        {{-- Canvas --}}
        <div class="design-editor-container relative w-full overflow-hidden border border-gray-300 rounded-md" style="padding-bottom: 75%;">
            <div :id="`${canvasId}-container`" class="absolute inset-0">
                @if($background)
                <img src="{{ $background }}" :id="`${canvasId}-background`" class="absolute inset-0 w-full h-full object-contain" alt="Background">
                @else
                <div class="absolute inset-0 bg-transparent flex items-center justify-center text-gray-500">
                    لا توجد خلفية
                </div>
                @endif

                <div :id="`${canvasId}-logos-layer`" class="absolute inset-0 z-10"></div>
            </div>
        </div>

        <input type="hidden" :id="targetInputId" :name="targetInputId.replace('-', '.')" x-model="hiddenImageValue">
        <input type="hidden" :id="`${targetInputId}_logos`" :name="targetInputId.replace('-', '.') + '_logos'" x-model="hiddenLogosValue">
    </div>

</div>

@push('scripts')
<script>
    function designEditor(config) {
        return {
            canvasId: config.canvasId
            , background: config.background
            , initialLogos: config.initialLogos
            , targetInputId: config.targetInputId,

            editorContainer: null
            , backgroundEl: null
            , logosLayer: null
            , fileInput: null
            , hiddenImageInput: null
            , hiddenLogosInput: null,

            selectedLogo: null
            , currentLogosState: [],

            hiddenImageValue: ''
            , hiddenLogosValue: '[]',

            init() {
                this.editorContainer = this.$el.querySelector(`#${this.canvasId}-container`);
                this.backgroundEl = this.$el.querySelector(`#${this.canvasId}-background`);
                this.logosLayer = this.$el.querySelector(`#${this.canvasId}-logos-layer`);
                this.fileInput = this.$refs.fileInput;
                this.hiddenImageInput = this.$el.querySelector(`#${this.targetInputId}`);
                this.hiddenLogosInput = this.$el.querySelector(`#${this.targetInputId}_logos`);

                if (!this.editorContainer || !this.logosLayer || !this.fileInput || !this.hiddenImageInput || !this.hiddenLogosInput) {
                    alert('حدث خطأ أثناء تهيئة محرر التصميم. يرجى تحديث الصفحة وحاول مرة أخرى.');
                    return;
                }

                this.fileInput.addEventListener('change', (e) => {
                    [...e.target.files].forEach(file => {
                        const reader = new FileReader();
                        reader.onload = (event) => {
                            this.addLogoToCanvas({
                                src: event.target.result
                                , filename: file.name
                                , left: null
                                , top: null
                                , width: null
                                , height: null
                            });
                        };
                        reader.readAsDataURL(file);
                    });
                    this.fileInput.value = '';
                });

                this.editorContainer.addEventListener('click', (e) => {
                    if (!e.target.closest('.design-logo') && this.selectedLogo) {
                        this.selectedLogo.classList.remove('selected');
                        this.selectedLogo = null;
                    }
                });

                if (this.initialLogos ? .length > 0) {
                    this.initialLogos.forEach(logo => {
                        const fullSrc = logo.src.startsWith('data:image/') ?
                            logo.src :
                            @json(asset('storage')) + '/' + logo.src;
                        this.addLogoToCanvas({
                            ...logo
                            , src: fullSrc
                        });
                    });
                }
            },

            addLogoToCanvas(logoData) {
                const logoDiv = document.createElement('div');
                logoDiv.className = 'design-logo';
                logoDiv.setAttribute('data-filename', logoData.filename);

                const img = document.createElement('img');
                img.src = logoData.src;

                img.onload = () => {
                    if (logoData.left !== null) {
                        logoDiv.style.left = `${logoData.left * this.editorContainer.offsetWidth}px`;
                        logoDiv.style.top = `${logoData.top * this.editorContainer.offsetHeight}px`;
                        logoDiv.style.width = `${logoData.width * this.editorContainer.offsetWidth}px`;
                        logoDiv.style.height = `${logoData.height * this.editorContainer.offsetHeight}px`;
                    } else {
                        const defaultWidth = this.editorContainer.offsetWidth * 0.15;
                        logoDiv.style.width = `${defaultWidth}px`;
                        logoDiv.style.left = `${(this.editorContainer.offsetWidth - defaultWidth) / 2}px`;
                        logoDiv.style.top = `${(this.editorContainer.offsetHeight - defaultWidth) / 2}px`;
                    }
                    this.saveDesignState();
                };

                logoDiv.appendChild(img);

                const deleteButton = document.createElement('button');
                deleteButton.className = 'delete-logo-button';
                deleteButton.innerHTML = '×';
                deleteButton.type = 'button';
                deleteButton.addEventListener('click', (e) => {
                    e.stopPropagation();
                    this.logosLayer.removeChild(logoDiv);
                    this.currentLogosState = this.currentLogosState.filter(item => item.element !== logoDiv);
                    if (this.selectedLogo === logoDiv) this.selectedLogo = null;
                    this.saveDesignState();
                });
                logoDiv.appendChild(deleteButton);

                this.logosLayer.appendChild(logoDiv);
                this.currentLogosState.push({
                    ...logoData
                    , element: logoDiv
                });
                this.enableLogoInteractions(logoDiv);
            },

            enableLogoInteractions(el) {
                let isDragging = false;
                let startX, startY, initialLeft, initialTop;

                el.addEventListener('mousedown', (e) => {
                    if (this.selectedLogo && this.selectedLogo !== el)
                        this.selectedLogo.classList.remove('selected');
                    el.classList.add('selected');
                    this.selectedLogo = el;

                    startX = e.clientX;
                    startY = e.clientY;
                    initialLeft = el.offsetLeft;
                    initialTop = el.offsetTop;
                    el.style.cursor = 'grabbing';
                    isDragging = true;

                    const onMove = (e) => {
                        if (!isDragging) return;
                        const dx = e.clientX - startX;
                        const dy = e.clientY - startY;
                        el.style.left = `${Math.max(0, initialLeft + dx)}px`;
                        el.style.top = `${Math.max(0, initialTop + dy)}px`;
                    };

                    const onUp = () => {
                        isDragging = false;
                        el.style.cursor = 'grab';
                        document.removeEventListener('mousemove', onMove);
                        document.removeEventListener('mouseup', onUp);
                        this.saveDesignState();
                    };

                    document.addEventListener('mousemove', onMove);
                    document.addEventListener('mouseup', onUp);
                });
            },

            deleteSelectedLogo() {
                if (this.selectedLogo) {
                    this.logosLayer.removeChild(this.selectedLogo);
                    this.currentLogosState = this.currentLogosState.filter(logo => logo.element !== this.selectedLogo);
                    this.selectedLogo = null;
                    this.saveDesignState();
                }
            },

            resetCanvas() {
                this.logosLayer.innerHTML = '';
                this.currentLogosState = [];
                this.selectedLogo = null;
                this.saveDesignState();
            },

            saveDesignState() {
                const width = this.editorContainer.offsetWidth;
                const height = this.editorContainer.offsetHeight;
                const canvas = document.createElement('canvas');
                canvas.width = width;
                canvas.height = height;
                const ctx = canvas.getContext('2d');

                if (this.backgroundEl && this.backgroundEl.src) {
                    const bgImg = new Image();
                    bgImg.crossOrigin = 'anonymous';
                    bgImg.src = this.backgroundEl.src;
                    bgImg.onload = () => {
                        ctx.drawImage(bgImg, 0, 0, width, height);
                        this.drawLogos(ctx, canvas);
                    };
                    bgImg.onerror = () => this.drawLogos(ctx, canvas);
                } else {
                    this.drawLogos(ctx, canvas);
                }
            },

            drawLogos(ctx, canvas) {
                const width = canvas.width;
                const height = canvas.height;

                this.currentLogosState.forEach(logo => {
                    const el = logo.element;
                    const img = el.querySelector('img');
                    if (img.complete) {
                        ctx.drawImage(img, el.offsetLeft, el.offsetTop, el.offsetWidth, el.offsetHeight);
                    }
                });

                this.hiddenImageValue = canvas.toDataURL('image/png', 0.9);
                this.hiddenLogosValue = JSON.stringify(this.currentLogosState.map(logo => ({
                    src: logo.src
                    , filename: logo.filename
                    , left: logo.element.offsetLeft / width
                    , top: logo.element.offsetTop / height
                    , width: logo.element.offsetWidth / width
                    , height: logo.element.offsetHeight / height
                , })));

                this.hiddenImageInput.dispatchEvent(new Event('input', {
                    bubbles: true
                }));
                this.hiddenLogosInput.dispatchEvent(new Event('input', {
                    bubbles: true
                }));
            }
        };
    }

</script>
@endpush
