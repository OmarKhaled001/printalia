@php
use App\Models\Plan;
$plans = Plan::where('is_active', true)->get();
@endphp
<section class="section  section-padding" id="op-pricing">
    <div class="container">
        <div class="section-heading mb-0 text-center">
            <h2 class="text-center">خطط الأسعار</h2>
            <h5>اختر الخطة المناسبة لك</h5>

        </div>

        <div class="row">
            @foreach($plans as $plan)
            <div class="col-lg-4" data-sal="slide-up" data-sal-duration="800" data-sal-delay="{{ $loop->index * 100 }}">
                <div class="pricing-table {{ $loop->first ? 'active' : '' }}">
                    <div class="pricing-header">
                        <h3 class="title">{{$plan->name}}</h3>
                        <div class="price-wrap">
                            <div class="monthly-pricing d-flex align-items-center gap-1 justify-content-center">
                                <span class="amount">{{ number_format($plan->price, 2) }}</span>
                                <img class="duration" src="{{ asset('assets/media/Saudi_Riyal_Symbol.svg') }}" alt="ريال سعودي" style="width: 30px;" />
                                <span class="duration">/شهرياً</span>
                            </div>
                        </div>
                        <div class="pricing-btn">
                            <a href="{{ route('designer.subscribe.form',  $plan->id) }}" class="axil-btn btn-large btn-borderd fw-bolder">ابدأ الآن</a>
                        </div>
                    </div>
                    <div class="pricing-body">
                        <ul class="list-unstyled">
                            <li>{{ $plan->design_count ?? 'بشكل غير محدود' }} تصميم على موك أب شهرياً</li>
                            <li>إرسال طلب تنفيذ للمصنع</li>
                            <li>تتبع حالة الطلب</li>
                            <li>دعم فني</li>
                        </ul>
                    </div>

                </div>
            </div>
            @endforeach
        </div>
    </div>

    <ul class="shape-group-3 list-unstyled">
        <li class="shape shape-1">
            <img src="assets/media/others/line-1.png" alt="شكل" />
        </li>
        <li class="shape shape-2">
            <img src="assets/media/others/bubble-4.png" alt="شكل" />
        </li>
    </ul>
</section>
