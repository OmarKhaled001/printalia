<x-filament::widget>
    <x-filament::card>

        <div class="flex flex-col items-center justify-center space-y-4 p-4">
            {{-- صورة المستخدم --}}
            <img src="{{ asset('assets/media/icon/icon-3.png') }}" alt="User Avatar" class="w-24 h-24 rounded-full border-4 border-primary-500 shadow-md dark:border-primary-700" />

            {{-- عنوان الودجت --}}
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                رابط الإحالة الخاص بك
            </h2>

            {{-- رسالة ترحيبية مع اسم المستخدم --}}
            <p class="text-gray-600 dark:text-gray-400 text-center">
                مرحباً، {{ $this->getUserName() }}! شارك رابط الإحالة الخاص بك لدعوة مصممين جدد وكسب المكافآت.
            </p>

            <div class="flex items-center w-full max-w-xl rounded-lg shadow-sm overflow-hidden dark:border-gray-600" x-data="{ copied: false }">
                {{-- حقل الرابط --}}
                <input type="text" id="referralLinkInput" value="{{ $this->getReferralLink() }}" readonly class="flex-grow px-4 py-2 text-sm text-center text-gray-900 bg-gray-100 dark:bg-gray-700 dark:text-white focus:outline-none" aria-label="رابط الإحالة" />

                {{-- زر النسخ --}}
                <button type="button" x-on:click="
                navigator.clipboard.writeText(document.getElementById('referralLinkInput').value);
                copied = true;
                setTimeout(() => copied = false, 2000);
            " class="flex items-center gap-1 px-4 py-2 text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 transition rounded-none h-full focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800" aria-live="polite">

                    <x-heroicon-o-clipboard class="w-5 h-5" />
                    <span x-text="copied ? 'تم!' : 'نسخ '"></span>
                </button>
            </div>

            @php

            $referralPercentage = \App\Models\Setting::where('key', 'present_earn')->value('value');
            @endphp

            <p class="text-sm text-gray-600 dark:text-gray-400 text-center leading-relaxed space-y-2">
                <span class="font-semibold block mb-2">كيف تستفيد من نظام الإحالة؟</span>
                <ul class="list-disc list-inside text-right space-y-1 rtl:text-right ltr:text-left">
                    <li>انسخ رابط الإحالة وشاركه مع الآخرين.</li>
                    <li>كل من يسجل ويشترك يُحتسب كإحالة لك.</li>
                    <li>تحصل على <span class="font-bold text-primary-600">{{ $referralPercentage }}%</span> من أول اشتراك له.</li>
                </ul>
                <span class="block mt-3 text-xs text-gray-500 dark:text-gray-400">
                    <strong>ملاحظة:</strong> النسبة قابلة للتعديل من إعدادات النظام.
                </span>
            </p>


            <div class="grid grid-cols-1 md:grid-cols-3 gap-3 text-center mt-4">
                <div class="bg-gray-100 dark:bg-gray-800 p-4 rounded-lg shadow ">
                    <h2 class="text-lg font-semibold text-gray-700 dark:text-white">👥 عدد الإحالات</h2>
                    <p class="text-xl font-bold text-primary-600">{{ $this->getReferralCount() }}</p>
                </div>

                <div class="bg-gray-100 dark:bg-gray-800 p-4 rounded-lg shadow">
                    <h2 class="text-lg font-semibold text-gray-700 dark:text-white">💰 إجمالي الأرباح </h2>
                    <p class="text-xl font-bold text-green-600">{{ number_format($this->getFinishedReferralEarnings(), 2) }} {{ config('app.currency', 'ر.س') }}</p>
                </div>

                <div class="bg-gray-100 dark:bg-gray-800 p-4 rounded-lg shadow">
                    <h2 class="text-lg font-semibold text-gray-700 dark:text-white">⏳ الأرباح المعلقة</h2>
                    <p class="text-xl font-bold text-yellow-500">{{ number_format($this->getPendingReferralEarnings(), 2) }} {{ config('app.currency', 'ر.س') }}</p>
                </div>
            </div>
        </div>
    </x-filament::card>
</x-filament::widget>
