@props([
'background' => '',
'logo' => '',
'targetInputId' => '',
'canvasId' => 'design-canvas',
])
<div>
    <strong>رابط الخلفية:</strong>
    <a href="{{ $background }}" target="_blank" class="text-blue-600 underline">{{ $background }}</a>
</div>

<div>
    <strong>رابط الشعار:</strong>
    <a href="{{ $logo }}" target="_blank" class="text-blue-600 underline">{{ $logo }}</a>
</div>
<div x-data="designEditor('{{ $canvasId }}', '{{ $targetInputId }}', @js($background), @js($logo))" x-init="initCanvas()" wire:ignore class="p-4 border rounded-lg shadow-sm">

    <div class="flex flex-col gap-4">
        <canvas id="{{ $canvasId }}" class="border border-gray-300 w-full" style="max-width: 800px; height: 600px;"></canvas>

        <div class="flex justify-end gap-2">
            <button type="button" class="filament-button filament-button-size-md inline-flex items-center justify-center py-1 gap-1 font-medium rounded-lg border transition-colors focus:outline-none focus:ring-offset-2 focus:ring-2 focus:ring-inset min-h-[2.25rem] px-4 text-sm text-gray-800 bg-white border-gray-300 hover:bg-gray-50 focus:ring-primary-600 focus:text-primary-600 focus:bg-primary-50 focus:border-primary-600 dark:bg-gray-800 dark:hover:bg-gray-700 dark:border-gray-600 dark:hover:border-gray-500 dark:text-gray-200 dark:focus:text-primary-400 dark:focus:border-primary-400 dark:focus:bg-gray-800" @click="resetCanvas">
                إعادة تعيين
            </button>
            <button type="button" class="filament-button filament-button-size-md inline-flex items-center justify-center py-1 gap-1 font-medium rounded-lg border transition-colors focus:outline-none focus:ring-offset-2 focus:ring-2 focus:ring-inset min-h-[2.25rem] px-4 text-sm text-white shadow focus:ring-white border-transparent bg-primary-600 hover:bg-primary-500 focus:bg-primary-700 focus:ring-offset-primary-700" @click="saveDesign">
                حفظ هذا التصميم
            </button>
        </div>
        <p class="text-xs text-gray-500">
            قم بتحريك وتغيير حجم الشعار حسب الحاجة. سيتم حفظ التصميم عند الضغط على الزر.
        </p>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/5.3.1/fabric.min.js" defer></script>

    <script>
        // Define only once globally
        if (!window.designEditorComponentRegistered) {
            function designEditor(canvasId, targetInputId, backgroundUrl, logoUrl) {
                return {
                    canvas: null
                    , canvasId: canvasId
                    , targetInputId: targetInputId
                    , backgroundUrl: backgroundUrl
                    , logoUrl: logoUrl
                    , isLoading: true,

                    initCanvas() {
                        console.log(`Initializing canvas: ${this.canvasId}`);
                        const canvasElement = document.getElementById(this.canvasId);

                        if (!canvasElement) {
                            console.error(`Canvas element #${this.canvasId} not found.`);
                            return;
                        }

                        // Dispose existing canvas if exists
                        if (this.canvas && typeof this.canvas.dispose === 'function') {
                            this.canvas.dispose();
                        }

                        // Initialize new canvas
                        this.canvas = new fabric.Canvas(canvasElement, {
                            width: 800
                            , height: 600
                            , backgroundColor: '#f0f0f0'
                        });

                        this.loadImages();
                    },

                    loadImages() {
                        if (!this.canvas) {
                            console.error('Canvas not initialized');
                            return;
                        }
                        // In your loadImages function:
                        if (this.logoUrl) {
                            fabric.Image.fromURL(this.logoUrl, (logoImg) => {
                                if (!logoImg) {
                                    console.warn('Logo image failed to load');
                                    logoLoaded = true;
                                    checkLoadingComplete();
                                    return;
                                }
                                // Rest of your code...
                            }).catch(err => {
                                console.error('Logo load error:', err);
                                logoLoaded = true;
                                checkLoadingComplete();
                            });
                        }
                        this.isLoading = true;
                        let bgLoaded = !this.backgroundUrl;
                        let logoLoaded = !this.logoUrl;

                        const handleError = (err) => {
                            console.error('Image load error:', err);
                            this.isLoading = false;
                        };

                        const checkLoadingComplete = () => {
                            if (bgLoaded && logoLoaded) {
                                this.isLoading = false;
                                this.canvas.renderAll();
                                console.log('Canvas ready.');
                                this.saveDesign(); // Initial save
                            }
                        };

                        // Background image
                        if (this.backgroundUrl) {
                            fabric.Image.fromURL(this.backgroundUrl, (bgImg) => {
                                if (!bgImg) {
                                    bgLoaded = true;
                                    checkLoadingComplete();
                                    return;
                                }
                                const canvasWidth = this.canvas.getWidth();
                                const canvasHeight = this.canvas.getHeight();
                                const scale = Math.min(
                                    canvasWidth / bgImg.width
                                    , canvasHeight / bgImg.height
                                );
                                bgImg.set({
                                    scaleX: scale
                                    , scaleY: scale
                                    , selectable: false
                                    , evented: false
                                    , originX: 'center'
                                    , originY: 'center'
                                    , left: canvasWidth / 2
                                    , top: canvasHeight / 2
                                });
                                this.canvas.setBackgroundImage(bgImg, () => {
                                    bgLoaded = true;
                                    checkLoadingComplete();
                                });
                            }, {
                                crossOrigin: 'anonymous'
                            }).catch(handleError);
                        } else {
                            bgLoaded = true;
                            checkLoadingComplete();
                        }

                        // Logo image
                        if (this.logoUrl) {
                            fabric.Image.fromURL(this.logoUrl, (logoImg) => {
                                if (!logoImg) {
                                    logoLoaded = true;
                                    checkLoadingComplete();
                                    return;
                                }
                                logoImg.scaleToWidth(200);
                                logoImg.set({
                                    left: (this.canvas.getWidth() - logoImg.getScaledWidth()) / 2
                                    , top: (this.canvas.getHeight() - logoImg.getScaledHeight()) / 2
                                    , cornerColor: 'blue'
                                    , cornerStrokeColor: 'white'
                                    , borderColor: 'blue'
                                    , cornerSize: 12
                                    , transparentCorners: false
                                    , hasRotatingPoint: true
                                });
                                this.canvas.add(logoImg);
                                this.canvas.setActiveObject(logoImg);
                                logoLoaded = true;
                                checkLoadingComplete();
                            }, {
                                crossOrigin: 'anonymous'
                            }).catch(handleError);
                        } else {
                            logoLoaded = true;
                            checkLoadingComplete();
                        }
                    },

                    saveDesign() {
                        if (!this.canvas) {
                            console.error('Canvas not initialized');
                            return;
                        }

                        try {
                            const dataUrl = this.canvas.toDataURL({
                                format: 'png'
                                , quality: 0.9
                            });

                            // Method 1: Livewire direct state update
                            if (typeof @this !== 'undefined') {
                                try {
                                    @this.set(this.targetInputId, dataUrl);
                                    console.log(`Livewire state updated: ${this.targetInputId}`);
                                } catch (e) {
                                    console.error('Livewire set error:', e);
                                }
                            }

                            // Method 2: Update hidden input
                            const safeId = this.targetInputId.replace(/\./g, '\\.');
                            const input = document.getElementById(safeId);

                            if (input) {
                                input.value = dataUrl;
                                input.dispatchEvent(new Event('input', {
                                    bubbles: true
                                }));
                                console.log(`Input updated: #${safeId}`);
                            } else {
                                console.warn(`Input not found: #${safeId}`);
                            }
                        } catch (error) {
                            console.error('Canvas save error:', error);
                        }
                    },

                    resetCanvas() {
                        if (this.canvas) {
                            this.canvas.clear();
                            this.canvas.setBackgroundImage(null, this.canvas.renderAll.bind(this.canvas));
                            this.loadImages();
                        }
                    }
                };
            }

            // Register once with Alpine
            document.addEventListener('alpine:init', () => {
                if (!Alpine.$data.designEditor) {
                    Alpine.data('designEditor', designEditor);
                }
            });

            window.designEditorComponentRegistered = true;
        }

    </script>
</div>
