 <header class="header axil-header header-style-1">
     <div id="axil-sticky-placeholder"></div>
     <div class="axil-mainmenu">
         <div class="container">
             <div class="header-navbar">
                 <div class="header-logo">
                     <a href="{{ route('home') }}"><img class="light-version-logo" src="{{$settings::get('icon') ? asset('storage/app/public/' .$settings::get('logo')) : asset('assets/media/logo.png') }}" width="160px" alt="logo" /></a>
                     <a href="{{ route('home') }}"><img class="dark-version-logo" src="{{$settings::get('icon') ? asset('storage/app/public/' .$settings::get('logo')) : asset('assets/media/logo.png') }}" width="160px" alt="logo" /></a>
                     <a href="{{ route('home') }}"><img class="sticky-logo" src="{{$settings::get('icon') ? asset('storage/app/public/' .$settings::get('logo')) : asset('assets/media/logo.png') }}" width="160px" alt="logo" /></a>
                 </div>
                 <div class="header-main-nav">
                     <!-- Start Mainmanu Nav -->
                     <nav class="mainmenu-nav" id="mobilemenu-popup">
                         <div class="d-block d-lg-none">
                             <div class="mobile-nav-header">
                                 <div class="mobile-nav-logo">
                                     <a href="{{ route('home') }}">
                                         <img class="light-mode" src="{{$settings::get('icon') ? asset('storage/app/public/' .$settings::get('logo')) : asset('assets/media/logo.png') }}" width="160px" alt="Site Logo" />
                                         <img class="dark-mode" src="{{$settings::get('icon') ? asset('storage/app/public/' .$settings::get('logo')) : asset('assets/media/logo.png') }}" width="160px" alt="Site Logo" />
                                     </a>
                                 </div>
                                 <button class="mobile-menu-close" data-bs-dismiss="offcanvas">
                                     <i class="fas fa-times"></i>
                                 </button>
                             </div>
                         </div>
                         <ul class="mainmenu" id="onepagenav">
                             <li>
                                 <a href="#op-home">الرئيسية</a>
                             </li>
                             <li>
                                 <a href="#op-about">من نحن</a>
                             </li>
                             <li>
                                 <a href="#op-vision">رؤيتنا</a>
                             </li>
                             <li>
                                 <a href="#op-pricing">الاشتركات</a>
                             </li>
                             @if (Auth::guard('designer')->check())
                             <li class="header-btn">
                                 <a href="{{ route('filament.designer.auth.login') }}" class="axil-btn btn-fill-primary">لوحة التحكم</a>
                             </li>
                             @else
                             <li class="header-btn">
                                 <a href="{{ route('filament.designer.auth.login') }}" class="axil-btn btn-fill-primary">سجل الآن</a>
                             </li>
                             @endif

                     </nav>
                     <!-- End Mainmanu Nav -->
                 </div>
                 <div class="header-action">
                     <ul class="list-unstyled">
                         <li class="mobile-menu-btn sidemenu-btn d-lg-none d-block">
                             <button class="btn-wrap" data-bs-toggle="offcanvas" data-bs-target="#mobilemenu-popup">
                                 <span></span>
                                 <span></span>
                                 <span></span>
                             </button>
                         </li>
                         <li class="my_switcher d-block d-lg-none mx-2">
                             <ul>
                                 <li title="Light Mode">
                                     <a href="javascript:void(0)" class="setColor light" data-theme="light">
                                         <i class="fal fa-lightbulb-on"></i>
                                     </a>
                                 </li>
                                 <li title="Dark Mode">
                                     <a href="javascript:void(0)" class="setColor dark" data-theme="dark">
                                         <i class="fas fa-moon"></i>
                                     </a>
                                 </li>
                             </ul>
                         </li>
                     </ul>
                 </div>
             </div>
         </div>
     </div>
 </header>
