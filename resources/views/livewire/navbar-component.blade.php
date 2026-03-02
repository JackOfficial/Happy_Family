<div class="container-fluid fixed-top px-0">
            <div class="container px-0">
                <div class="topbar">
                    <div class="row align-items-center justify-content-center">
                        <div class="col-md-8">
                            <div class="topbar-info d-flex flex-wrap">
                                <a href="#" class="text-light me-4"><i class="fas fa-envelope text-white me-2"></i>{{ $organization->email }}</a>
                                <a href="tel:{{ $organization->phone }}" class="text-light"><i class="fas fa-phone-alt text-white me-2"></i>{{ $organization->phone }}</a>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="topbar-icon d-flex align-items-center justify-content-end">
                                <a href="https://twitter.com/HFRwOrg" target="__blank" class="btn-square text-white me-2"><i class="fab fa-twitter"></i></a>
                                <a href="https://www.instagram.com/hf.r.o?igsh=OXVjbnlmOXVzNjQy" target="__blank" class="btn-square text-white me-2"><i class="fab fa-instagram"></i></a>
                                <a href="https://www.youtube.com/channel/UCbWRXU7KOSRxNodro3H8mug" target="__blank" class="btn-square text-white me-2"><i class="fab fa-youtube"></i></a>
                                <a href="#" target="__blank" class="btn-square text-white me-2"><i class="fab fa-facebook"></i></a>
                                <a href="https://www.linkedin.com/company/happy-family-rwanda" target="__blank" class="btn-square text-white me-0"><i class="fab fa-linkedin-in"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <nav class="navbar navbar-light bg-light navbar-expand-xl">
                    <a href="/" class="navbar-brand ms-3">
                        <img src="{{ asset('storage/' . $organization->logo) }}" alt="{{ $organization->name }} logo" width="70px" height="auto" />
                    </a>
                    <button class="navbar-toggler py-2 px-3 me-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                        <span class="fa fa-bars text-primary"></span>
                    </button>
                    <div class="collapse navbar-collapse bg-light" id="navbarCollapse">
                        <div class="navbar-nav ms-auto">
                            <a href="/" class="nav-item nav-link active">Home</a>
                            <a href="/about" class="nav-item nav-link">About</a>
                            <a href="/causes" class="nav-item nav-link">Causes</a>
                            <a href="/projects" class="nav-item nav-link">Projects</a>
                            <a href="#" class="nav-item nav-link">Events</a>
                            <a href="#" class="nav-item nav-link">News</a>
                            <a href="#" class="nav-item nav-link">Contact</a>
                            <div class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">More</a>
                                <div class="dropdown-menu m-0 bg-secondary rounded-0">
                                    <a href="#" class="dropdown-item">Volunteers</a>
                                    <a href="#" class="dropdown-item">Career</a>
                                    <a href="#" class="nav-item nav-link">Gallery</a>
                                    <a href="#" class="dropdown-item">Donation</a>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center flex-nowrap pt-xl-0" style="margin-left: 15px;">
                            <a href="#" class="btn-hover-bg btn btn-primary text-white py-2 px-4 me-3">Donate Now</a>
                        </div>
                    </div>
                </nav>
            </div>
        </div>