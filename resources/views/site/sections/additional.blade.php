  @if($settings::get('additional_1_section_is_visible') || $settings::get('additional_2_section_is_visible'))
  <section class="section-padding case-study-brief">
      @if($settings::get('additional_1_section_is_visible'))

      <div class="container" id="op-about">
          <div class="row align-items-xl-center">

              <div class="col-xl-5 col-lg-6 offset-xl-1 sal-animate" data-sal="slide-right" data-sal-duration="1000" data-sal-delay="200">
                  <div class="case-study-featured">
                      <div class="section-heading heading-right">
                          <h1 class="title" style="text-align: start !important;">
                              {{$settings::get('additional_1_section_title',
                             "من نحن ؟")}}
                          </h1>
                          <div style="text-align: start !important; font-size:21px;">
                                {!! $settings::get('additional_1_section_description',
                             "نحن فريق يمني شغوف بالتقنية وريادة الأعمال، أطلقنا منصة برنتاليا كحل مبتكر في مجال التجارة الالكترونية لصناعة براند خاص فيك بدون مخاطرة وراس مال . مهمتنا هي تمكين كل مبدع أو رائد أعمال طموح من دخول عالم التجارة الإلكترونية بوسائل ذكية وآمنة")!!} </div>
                      </div>
                  </div>
              </div>
              <div class="col-lg-6 sal-animate" data-sal="slide-right" data-sal-duration="1000">
                  <div class="case-study-featured-thumb">
                      <img class="paralax-image" style="max-height: 600px;" src="{{ asset('storage/app/public/' . $settings::get('additional_1_section_image', '/media/others/mockup.png')) }}" alt="تصميم المنتج" style="will-change: transform; transform: perspective(1000px) rotateX(0deg) rotateY(0deg);" />

                  </div>
              </div>
          </div>
      </div>
      @endif

      @if($settings::get('additional_2_section_is_visible'))

      <div class="container" id="op-vision">
          <div class="row align-items-xl-center">

              <div class="col-xl-5 col-lg-6 offset-xl-1 sal-animate" data-sal="slide-right" data-sal-duration="1000" data-sal-delay="200">
                  <div class="case-study-featured">
                      <div class="section-heading heading-right">
                          <h1 class="title" style="text-align: start !important;">
                              {{$settings::get('additional_2_section_title',
                             "
                             رؤيتنا
                             ")}}
                          </h1>
                          <div style="text-align: start !important; font-size:21px;">
                                {!! $settings::get('additional_2_section_description',
                             "أن نفتح آفاق التجارة الإلكترونية في اليمن، ونمكّن المبدعين من تحويل أفكارهم إلى علامات تجارية ناجحة بدون تعقيدات أو تكاليف عالية.")!!} </div>
                      </div>
                  </div>
              </div>
              <div class="col-lg-6 sal-animate" data-sal="slide-right" data-sal-duration="1000">
                  <div class="case-study-featured-thumb">
                      <img class="paralax-image" style="max-height: 600px;" src="{{ asset('storage/app/public/' . $settings::get('additional_2_section_image', '/media/others/mockup.png')) }}" alt="تصميم المنتج" style="will-change: transform; transform: perspective(1000px) rotateX(0deg) rotateY(0deg);" />
                  </div>
              </div>

          </div>
      </div>
      @endif

  </section>
  @endif

  {{-- <section class="section section-padding">
    <div class="container">

        <div class="row">
            <div class="col-lg-3 col-sm-6 sal-animate mx-auto" style="text-align: center !important;" data-sal="slide-up" data-sal-duration="800" data-sal-delay="100">
                <div class="counterup-progress counterup-style-2 active">
                    <div class="icon">
                        <img src="{{ asset('assets') }}/media/icon/icon-10.png" alt="Apple">
  </div>
  <div class="count-number h2">
      <span class="number count odometer odometer-auto-theme" data-count="15">
          <div class="odometer-inside"><span class="odometer-digit"><span class="odometer-digit-spacer">8</span><span class="odometer-digit-inner"><span class="odometer-ribbon"><span class="odometer-ribbon-inner"><span class="odometer-value">1</span></span></span></span></span><span class="odometer-digit"><span class="odometer-digit-spacer">8</span><span class="odometer-digit-inner"><span class="odometer-ribbon"><span class="odometer-ribbon-inner"><span class="odometer-value">5</span></span></span></span></span></div>
      </span>
      <span class="symbol">+</span>
  </div>
  <h6 class="title">Years of operation</h6>
  </div>
  </div>
  <div class="col-lg-3 col-sm-6  sal-animate" data-sal="slide-up" data-sal-duration="800" data-sal-delay="200">
      <div class="counterup-progress counterup-style-2">
          <div class="icon">
              <img src="{{ asset('assets') }}/media/icon/icon-11.png" alt="Apple">
          </div>
          <div class="count-number h2">
              <span class="number count odometer odometer-auto-theme" data-count="360">
                  <div class="odometer-inside"><span class="odometer-digit"><span class="odometer-digit-spacer">8</span><span class="odometer-digit-inner"><span class="odometer-ribbon"><span class="odometer-ribbon-inner"><span class="odometer-value">3</span></span></span></span></span><span class="odometer-digit"><span class="odometer-digit-spacer">8</span><span class="odometer-digit-inner"><span class="odometer-ribbon"><span class="odometer-ribbon-inner"><span class="odometer-value">6</span></span></span></span></span><span class="odometer-digit"><span class="odometer-digit-spacer">8</span><span class="odometer-digit-inner"><span class="odometer-ribbon"><span class="odometer-ribbon-inner"><span class="odometer-value">0</span></span></span></span></span></div>
              </span>
              <span class="symbol">+</span>
          </div>
          <h6 class="title">Projects deliverd</h6>
      </div>
  </div>
  <div class="col-lg-3 col-sm-6 sal-animate" data-sal="slide-up" data-sal-duration="800" data-sal-delay="300">
      <div class="counterup-progress counterup-style-2">
          <div class="icon">
              <img src="{{ asset('assets') }}/media/icon/icon-12.png" alt="Apple">
          </div>
          <div class="count-number h2">
              <span class="number count odometer odometer-auto-theme" data-count="600">
                  <div class="odometer-inside"><span class="odometer-digit"><span class="odometer-digit-spacer">8</span><span class="odometer-digit-inner"><span class="odometer-ribbon"><span class="odometer-ribbon-inner"><span class="odometer-value">6</span></span></span></span></span><span class="odometer-digit"><span class="odometer-digit-spacer">8</span><span class="odometer-digit-inner"><span class="odometer-ribbon"><span class="odometer-ribbon-inner"><span class="odometer-value">0</span></span></span></span></span><span class="odometer-digit"><span class="odometer-digit-spacer">8</span><span class="odometer-digit-inner"><span class="odometer-ribbon"><span class="odometer-ribbon-inner"><span class="odometer-value">0</span></span></span></span></span></div>
              </span>
              <span class="symbol">+</span>
          </div>
          <h6 class="title">Specialist</h6>
      </div>
  </div>
  <div class="col-lg-3 col-sm-6  sal-animate" data-sal="slide-up" data-sal-duration="800" data-sal-delay="400">
      <div class="counterup-progress counterup-style-2">
          <div class="icon">
              <img src="{{ asset('assets') }}/media/icon/apple-black.png" alt="Apple">
          </div>
          <div class="count-number h2">
              <span class="number count odometer odometer-auto-theme" data-count="64">
                  <div class="odometer-inside"><span class="odometer-digit"><span class="odometer-digit-spacer">8</span><span class="odometer-digit-inner"><span class="odometer-ribbon"><span class="odometer-ribbon-inner"><span class="odometer-value">6</span></span></span></span></span><span class="odometer-digit"><span class="odometer-digit-spacer">8</span><span class="odometer-digit-inner"><span class="odometer-ribbon"><span class="odometer-ribbon-inner"><span class="odometer-value">4</span></span></span></span></span></div>
              </span>
              <span class="symbol">+</span>
          </div>
          <h6 class="title">Years of operation</h6>
      </div>
  </div>
  </div>
  </div>
  </section> --}}
