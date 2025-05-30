<x-filament-panels::page>
    <x-filament::page>
        <h2 class="text-xl font-bold mb-4">تصميم موكب مع لوجو</h2>

        <input type="file" id="logoInput" class="mb-4" />
        <canvas id="mockupCanvas" width="800" height="600" class="border"></canvas>

        <button onclick="saveMockup()" class="mt-4 bg-blue-500 text-white px-4 py-2 rounded">
            احفظ التصميم
        </button>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/5.2.4/fabric.min.js"></script>
        <script>
            const canvas = new fabric.Canvas('mockupCanvas');

            // تحميل صورة الموكب
            fabric.Image.fromURL('/mockups/tshirt.png', function(img) {
                img.selectable = false;
                canvas.setBackgroundImage(img, canvas.renderAll.bind(canvas));
            });

            // رفع اللوجو
            document.getElementById('logoInput').addEventListener('change', function(e) {
                const reader = new FileReader();
                reader.onload = function(f) {
                    fabric.Image.fromURL(f.target.result, function(img) {
                        img.scale(0.3);
                        img.set({
                            left: 100
                            , top: 100
                        });
                        canvas.add(img).setActiveObject(img);
                    });
                };
                reader.readAsDataURL(e.target.files[0]);
            });

            function saveMockup() {
                const data = canvas.toJSON();

                fetch('{{ route("mockup.generate") }}', {
                        method: 'POST'
                        , headers: {
                            'Content-Type': 'application/json'
                            , 'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                        , body: JSON.stringify({
                            canvas: data
                        })
                    })
                    .then(res => res.blob())
                    .then(blob => {
                        const url = window.URL.createObjectURL(blob);
                        const a = document.createElement('a');
                        a.href = url;
                        a.download = 'mockup.png';
                        a.click();
                    });
            }

        </script>
    </x-filament::page>


</x-filament-panels::page>
