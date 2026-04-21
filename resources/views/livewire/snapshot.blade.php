<div class="footer-item">
                    <h4 class="footer-title mb-4">Impact Gallery</h4>
                    <div class="row g-2">
                        @foreach(range(1, 6) as $i)
                        <div class="col-4">
                            <div class="footer-gallery-thumb">
                                <a href="{{ asset('frontend/img/gallery-footer-'.$i.'.jpg') }}" data-lightbox="footer-gallery">
                                    <div class="gallery-overlay">
                                        <i class="fas fa-expand-alt text-white"></i>
                                    </div>
                                    <img src="{{ asset('frontend/img/gallery-footer-'.$i.'.jpg') }}" 
                                         class="img-fluid rounded-3" 
                                         alt="Impact Story {{ $i }}">
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
 </div>