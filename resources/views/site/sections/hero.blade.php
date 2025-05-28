   <section class="banner banner-style-1" id="op-home">
       <div class="container">
           <div class="row align-items-end align-items-xl-start">
               <div class="col-lg-6">
                   <div class="banner-content" data-sal="slide-up" data-sal-duration="1000" data-sal-delay="100">
                       <h1 class="title">{{ $settings::get('hero_section_title','ابدأ مشروعك في الطباعة حسب الطلب بسهولة')}}</h1>
                       <span class="subtitle">
                           {{$settings::get('hero_section_description',
                           "صمّم منتجك، ضعه على موكاب جاهز، واربطه مباشرة مع المصنع وابدأ
                           البيع من دون رأس مال")}}
                       </span>
                       <a href="#op-pricing" class="axil-btn btn-fill-primary btn-large">ابدأ الآن</a>
                   </div>
               </div>
               <div class="col-lg-6">
                   <div class="banner-thumbnail">
                       <div class="large-thumb" data-sal="zoom-in" data-sal-duration="800" data-sal-delay="300">
                           <img src="{{ asset('assets') }}/media/banner/window.png" alt="تصميم المنتج" />
                       </div>
                       <div class="large-thumb-2" data-sal="slide-left" data-sal-duration="800" data-sal-delay="800">
                           <img src="{{ asset('storage/' . $settings::get('hero_section_image', '/media/banner/laptop-poses.png')) }}" alt="تصميم المنتج" />
                       </div>
                       <ul class="list-unstyled shape-group">
                           <li class="shape shape-1" data-sal="slide-left" data-sal-duration="500" data-sal-delay="800">
                               <img src="{{ asset('assets') }}/media/banner/chat-group.png" alt="تواصل" />
                           </li>
                       </ul>
                   </div>
               </div>
           </div>
       </div>
       <ul class="list-unstyled shape-group-21">
           <li class="shape shape-1" data-sal="slide-down" data-sal-duration="500" data-sal-delay="100">
               <img src="{{ asset('assets') }}/media/others/bubble-39.png" alt="Bubble" />
           </li>
           <li class="shape shape-2" data-sal="zoom-in" data-sal-duration="800" data-sal-delay="500">
               <img src="{{ asset('assets') }}/media/others/bubble-38.png" alt="Bubble" />
           </li>
           <li class="shape shape-3" data-sal="slide-left" data-sal-duration="500" data-sal-delay="700">
               <img src="{{ asset('assets') }}/media/others/bubble-14.png" alt="Bubble" />
           </li>
           <li class="shape shape-4" data-sal="slide-left" data-sal-duration="500" data-sal-delay="700">
               <img src="{{ asset('assets') }}/media/others/bubble-14.png" alt="Bubble" />
           </li>
           <li class="shape shape-5" data-sal="slide-left" data-sal-duration="500" data-sal-delay="700">
               <img src="{{ asset('assets') }}/media/others/bubble-14.png" alt="Bubble" />
           </li>
           <li class="shape shape-7" data-sal="slide-left" data-sal-duration="500" data-sal-delay="700">
               <img src="{{ asset('assets') }}/media/others/bubble-41.png" alt="Bubble" />
           </li>
       </ul>
   </section>
