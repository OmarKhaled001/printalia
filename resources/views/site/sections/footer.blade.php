<footer class="footer-area">
    <div class="container">
   <div class="footer-top">
     <div class="footer-copyright">
                   
                </div>

        <div class="footer-bottom" data-sal="slide-up" data-sal-duration="500" data-sal-delay="100">
            <div class="row">
                <div class="col-md-4">
                    <div class="footer-copyright">
                        <span class="copyright-text">© 2025. All rights reserved by
                            <a href="#">Printalia</a>.</span>
                    </div>
                </div>
                 <div class="footer-social-link">
                      <ul class="list-unstyled">
                        @if($settings::get('facebook_link'))
                            <li>
                                <a href="{{ $settings::get('facebook_link') }}" target="_blank" data-sal="slide-up" data-sal-duration="500" data-sal-delay="100">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                            </li>
                        @endif

                        @if($settings::get('instagram_link'))
                            <li>
                                <a href="{{ $settings::get('instagram_link') }}" target="_blank" data-sal="slide-up" data-sal-duration="500" data-sal-delay="200">
                                    <i class="fab fa-instagram"></i>
                                </a>
                            </li>
                        @endif

                        @if($settings::get('contact_phone'))
                            <li>
                                <a href="https://wa.me/{{ $settings::get('contact_phone') }}" target="_blank" data-sal="slide-up" data-sal-duration="500" data-sal-delay="300">
                                    <i class="fab fa-whatsapp"></i>
                                </a>
                            </li>
                        @endif

                        @if($settings::get('contact_email'))
                            <li>
                                <a href="mailto:{{ $settings::get('contact_email') }}" target="_blank" data-sal="slide-up" data-sal-duration="500" data-sal-delay="400">
                                    <i class="fas fa-envelope"></i>
                                </a>
                            </li>
                        @endif
                    </ul>

                    </div>
                <div class="col-md-4">
                    <div class="copyright-text ">
                        {{$settings::get('contact_phone',
                             "01068778340")}}
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="copyright-text">
                        {{$settings::get('contact_email',
                             "printalia@info.com")}}
                    </div>
                </div>
            </div>

        </div>
    </div>
</footer>
