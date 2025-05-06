<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>AutoServe - Automobile Management System</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <!--style.css-->
  <link rel="stylesheet" href="{{ asset('assets/css/auto.serve.styles.css') }}">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
</head>
<body>
  <!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-white shadow-sm fixed-top py-2 border-bottom animate__animated animate__fadeInDown" style="background:rgba(255,255,255,0.98)!important;">
  <div class="container">
    <a class="navbar-brand d-flex align-items-center fw-bold text-primary fs-3" href="#">
      <i class="bi bi-gear-fill me-2 text-warning fs-2"></i>AutoServe
    </a>
    <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto align-items-lg-center">
        <li class="nav-item mx-2">
          <a class="nav-link fw-semibold text-dark" href="#featuresCarousel"><i class="bi bi-stars me-1"></i>Features</a>
        </li>
        <li class="nav-item mx-2">
          <a class="nav-link fw-semibold text-dark" href="#about"><i class="bi bi-info-circle me-1"></i>About</a>
        </li>
        <li class="nav-item mx-2">
          <a class="nav-link fw-semibold text-dark" href="#" data-bs-toggle="modal" data-bs-target="#registerModal"><i class="bi bi-person-plus me-1"></i>Register</a>
        </li>
        <li class="nav-item mx-2">
          <a class="nav-link fw-semibold text-dark" href="#contact"><i class="bi bi-envelope me-1"></i>Contact</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

  <!-- Hero Section -->
<section class="hero d-flex align-items-center justify-content-center text-center position-relative" style="padding-top: 100px; min-height: 80vh; overflow: hidden;">
  <!-- Decorative Shape -->
  <div style="position:absolute;top:-80px;left:-80px;width:260px;height:260px;background:rgba(255,193,7,0.12);border-radius:50%;z-index:0;"></div>
  <div class="container position-relative z-1">
    <h1 class="display-3 fw-bold mb-3 animate__animated animate__fadeInDown">
      Welcome to <span class="text-warning">AutoServe</span>
    </h1>
    <p class="lead mb-4 animate__animated animate__fadeInUp animate__delay-1s">
      <span class="bg-white bg-opacity-75 px-2 py-1 rounded shadow-sm">Empowering <span class="fw-bold text-primary">Automobile Businesses</span> with Smart Management</span>
    </p>
    <button class="btn btn-lg btn-warning text-dark fw-semibold shadow animate__animated animate__pulse animate__infinite" data-bs-toggle="modal" data-bs-target="#registerModal">
      <i class="bi bi-rocket-takeoff me-2"></i>Get Started
    </button>
    <div class="mt-5 animate__animated animate__fadeInUp animate__delay-2s">
      <a href="#featuresCarousel" class="text-white-50 text-decoration-none">
        <div class="d-flex flex-column align-items-center">
          <span class="mb-1">Scroll Down</span>
          <i class="bi bi-chevron-double-down fs-2"></i>
        </div>
      </a>
    </div>
  </div>
  <!-- Decorative Shape Bottom Right -->
  <div style="position:absolute;bottom:-80px;right:-80px;width:200px;height:200px;background:rgba(13,110,253,0.10);border-radius:50%;z-index:0;"></div>
</section>

  <!-- Features Carousel -->
  <section class="features-carousel py-5 position-relative" style="background: linear-gradient(90deg, #f8f9fa 60%, #e9ecef 100%); overflow: hidden;">
  <div class="container position-relative">
    <div id="featuresCarousel" class="carousel slide animate__animated animate__fadeInUp" data-bs-ride="carousel">
      <div class="carousel-inner">
        <div class="carousel-item active">
          <div class="row align-items-center">
            <div class="col-md-6 text-center animate__animated animate__fadeInLeft">
              <div class="card border-0 shadow-lg rounded-4 overflow-hidden feature-carousel-img-card animate__animated animate__zoomIn">
                <img src="assets/images/feature1.jpg" class="d-block w-100" alt="Customer Management">
              </div>
            </div>
            <div class="col-md-6 animate__animated animate__fadeInRight">
              <div class="card border-0 shadow-lg rounded-4 p-4">
                <h2 class="fw-bold text-primary mb-3"><i class="bi bi-people"></i> Comprehensive Customer & Vehicle Records</h2>
                <h4 class="text-muted">Maintain detailed records of customers, vehicles, and their complete repair history.</h4>
              </div>
            </div>
          </div>
        </div>
        <div class="carousel-item">
          <div class="row align-items-center">
            <div class="col-md-6 text-center animate__animated animate__fadeInLeft">
              <div class="card border-0 shadow-lg rounded-4 overflow-hidden feature-carousel-img-card animate__animated animate__zoomIn">
                <img src="assets/images/feature2.jpg" class="d-block w-100" alt="Service Reminders">
              </div>
            </div>
            <div class="col-md-6 animate__animated animate__fadeInRight">
              <div class="card border-0 shadow-lg rounded-4 p-4">
                <h2 class="fw-bold text-warning mb-3"><i class="bi bi-bell"></i> Automated Service Reminders</h2>
                <h4 class="text-muted">Send SMS and email reminders to customers for upcoming services and appointments.</h4>
              </div>
            </div>
          </div>
        </div>
        <div class="carousel-item">
          <div class="row align-items-center">
            <div class="col-md-6 text-center animate__animated animate__fadeInLeft">
              <div class="card border-0 shadow-lg rounded-4 overflow-hidden feature-carousel-img-card animate__animated animate__zoomIn">
                <img src="assets/images/feature3.jpg" class="d-block w-100" alt="Inventory & Invoicing">
              </div>
            </div>
            <div class="col-md-6 animate__animated animate__fadeInRight">
              <div class="card border-0 shadow-lg rounded-4 p-4">
                <h2 class="fw-bold text-secondary mb-3"><i class="bi bi-receipt"></i> Inventory & Invoice Management</h2>
                <h4 class="text-muted">Track inventory, generate invoices, receipts, and manage payroll and staff tasks efficiently.</h4>
              </div>
            </div>
          </div>
        </div>
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#featuresCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#featuresCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </div>
    <div style="position:absolute;bottom:-60px;left:-60px;width:180px;height:180px;background:rgba(13,110,253,0.08);border-radius:50%;z-index:0;"></div>
  </div>
</section>

  <!-- About Us Section -->
  <section id="about" class="about-us py-5 position-relative" style="background: linear-gradient(90deg, #e3f2fd 60%, #fff 100%); overflow: hidden;">
  <div class="container position-relative">
    <div class="row align-items-center">
      <div class="col-md-6 mb-4 mb-md-0">
        <div class="p-4 bg-white rounded shadow-lg animate__animated animate__fadeInLeft" style="border-left: 6px solid #0d6efd;">
          <h2 class="fw-bold mb-3 text-primary">Why Choose AutoServe?</h2>
          <div class="mb-3">
            <span class="badge bg-primary me-2 mb-2"><i class="bi bi-people"></i> Customer & Vehicle Management</span>
            <span class="badge bg-success me-2 mb-2"><i class="bi bi-clock-history"></i> Repair History Tracking</span>
            <span class="badge bg-warning text-dark me-2 mb-2"><i class="bi bi-bell"></i> Automated Reminders</span>
            <span class="badge bg-info text-dark me-2 mb-2"><i class="bi bi-box-seam"></i> Inventory</span>
            <span class="badge bg-secondary me-2 mb-2"><i class="bi bi-receipt"></i> Invoicing</span>
            <span class="badge bg-dark me-2 mb-2"><i class="bi bi-person-badge"></i> Staff & Payroll</span>
          </div>
          <div class="alert alert-primary mt-3 mb-3 fw-semibold animate__animated animate__pulse animate__delay-1s">
            "All-in-one platform to streamline your automobile business, boost customer satisfaction, and grow your revenue."
          </div>
          <ul class="list-unstyled">
            <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> Easy-to-use dashboard for all your business needs</li>
            <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> Real-time notifications and reminders</li>
            <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> Secure cloud-based data storage</li>
            <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> 24/7 customer support</li>
          </ul>
        </div>
      </div>
      <div class="col-md-6 text-center animate__animated animate__fadeInRight">
        <img src="assets/images/about.jpg" alt="About AutoServe" class="img-fluid rounded shadow-lg" style="max-width: 90%;">
      </div>
    </div>
    <!-- Decorative Shape -->
    <div style="position:absolute;top:-60px;right:-60px;width:180px;height:180px;background:rgba(13,110,253,0.08);border-radius:50%;z-index:0;"></div>
  </div>
</section>

  <!-- Features Section -->
  <section class="features py-5 bg-light position-relative" style="overflow: hidden;">
  <div class="container position-relative">
    <div class="row text-center">
      <div class="col-md-4 mb-4 animate__animated animate__fadeInUp animate__delay-1s">
        <div class="feature-box p-4 shadow-sm rounded bg-white h-100">
          <div class="mb-3"><span class="badge bg-primary"><i class="bi bi-people fs-2"></i></span></div>
          <h5 class="fw-bold">Customer Management</h5>
          <p>Centralized customer and vehicle data for quick access and updates.</p>
        </div>
      </div>
      <div class="col-md-4 mb-4 animate__animated animate__fadeInUp animate__delay-2s">
        <div class="feature-box p-4 shadow-sm rounded bg-white h-100">
          <div class="mb-3"><span class="badge bg-warning text-dark"><i class="bi bi-bell fs-2"></i></span></div>
          <h5 class="fw-bold">Service Reminders</h5>
          <p>Automated notifications to keep your customers coming back.</p>
        </div>
      </div>
      <div class="col-md-4 mb-4 animate__animated animate__fadeInUp animate__delay-3s">
        <div class="feature-box p-4 shadow-sm rounded bg-white h-100">
          <div class="mb-3"><span class="badge bg-secondary"><i class="bi bi-receipt fs-2"></i></span></div>
          <h5 class="fw-bold">Inventory & Billing</h5>
          <p>Manage stock, generate invoices, and track payments
        </div>
      </div>
    </div>
    <div style="position:absolute;top:-60px;right:-60px;width:180px;height:180px;background:rgba(255,193,7,0.08);border-radius:50%;z-index:0;"></div>
  </div>
</section>

  <!-- Customer Testimony Section -->
  <section class="testimonials py-5 position-relative" style="background: linear-gradient(90deg, #fff 60%, #e3f2fd 100%); overflow: hidden;">
  <div class="container position-relative">
    <h2 class="text-center mb-5 animate__animated animate__fadeInDown">What Our Customers Say</h2>
    <div class="row justify-content-center">
      <div class="col-md-4 animate__animated animate__fadeInLeft animate__delay-1s">
        <div class="testimonial p-4 shadow rounded mb-4 bg-white">
          <div class="mb-2"><i class="bi bi-chat-quote text-primary fs-2"></i></div>
          <p>"AutoServe has transformed our business. Managing customers and inventory has never been easier!"</p>
          <h6 class="mt-3">- Abdue A., Kojo Autos, Abuja</h6>
        </div>
      </div>
      <div class="col-md-4 animate__animated animate__fadeInUp animate__delay-2s">
        <div class="testimonial p-4 shadow rounded mb-4 bg-white">
          <div class="mb-2"><i class="bi bi-chat-quote text-warning fs-2"></i></div>
          <p>"The automated reminders keep our customers happy and coming back. Highly recommended!"</p>
          <h6 class="mt-3">- Edima K., Taharish Automobile, Abuja</h6>
        </div>
      </div>
      <div class="col-md-4 animate__animated animate__fadeInRight animate__delay-3s">
        <div class="testimonial p-4 shadow rounded mb-4 bg-white">
          <div class="mb-2"><i class="bi bi-chat-quote text-success fs-2"></i></div>
          <p>"Inventory and billing are now seamless. Our staff loves the new system!"</p>
          <h6 class="mt-3">- Juliana B., AutoWellness Center, Lagos</h6>
        </div>
      </div>
    </div>
    <div style="position:absolute;bottom:-60px;left:-60px;width:180px;height:180px;background:rgba(13,110,253,0.08);border-radius:50%;z-index:0;"></div>
  </div>
</section>

  <!-- Registration Modal -->
<div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false" style="background-color: rgba(0, 0, 0, 0.1);">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="registerModalLabel">Register an Account</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="{{ route('company.register') }}" method="POST" id="registrationForm" class="row g-4">
          @csrf
          <div id="formMessage"></div>
          @if(session('success'))
            <div class="alert alert-success">
              <strong>{{session('success')}}</strong>
            </div>
          @endif
          @if ($errors->any())
            <div class="alert alert-danger">
              <ul>
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif
          <div class="col-md-6">
            <label for="name" class="form-label">Full Name</label>
            <input type="text" name="name" value="{{old('name')}}" class="form-control" id="name" required autofocus>
          </div>
          <div class="col-md-6">
            <label for="email" class="form-label">Email Address</label>
            <input type="email" name="email" value="{{old('email')}}" class="form-control" id="email" required>
          </div>
          <div class="col-md-6">
            <label for="phone_number" class="form-label">Phone Number</label>
            <input type="text" name="phone_number" value="{{old('phone_number')}}" class="form-control" id="phone_number" required>
          </div>
          <div class="col-md-6">
            <label for="company_name" class="form-label">Company Name</label>
            <input type="text" name="company_name" value="{{old('company_name')}}" class="form-control" id="company_name" required>
          </div>
          <div class="col-md-6">
            <label for="address" class="form-label">Company Address</label>
            <textarea name="address" class="form-control" id="address" rows="3">{{old('address')}}</textarea>
          </div>
          <div class="col-md-6">
            <label for="deployment_type" class="form-label">Deployment Method</label>
            <select name="deployment_type" class="form-select" id="deployment_type" required>
              <option value="" disabled selected>Select Deployment Method</option>
              <option value="online">Online</option>
              <option value="on-premise">On-Premise</option>
              <option value="subscription">Subscription</option>
            </select>
          </div>
          <div class="col-12">
            <button type="submit" class="btn btn-primary w-100 mb-3">Register</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

  <!-- Contact Us Section -->
  <section id="contact" class="contact-us py-5 position-relative" style="background: url('assets/images/bg1.jpg') center/cover no-repeat; overflow: hidden;">
  <div class="container position-relative">
    <h2 class="text-center mb-4 animate__animated animate__fadeInDown text-warning">Contact Us</h2>
    <div class="row">
      <div class="col-md-6 mb-4 mb-md-0 animate__animated animate__fadeInLeft">
        <form id="contactForm" class="p-4 shadow rounded bg-white" action="{{ route('web.enquiry') }}" method="POST">
          @csrf

          @if(session('successful'))
            <div class="alert alert-success">
              <strong>{{session('successful')}}</strong>
            </div>
          @endif
          @if(session('errorful'))
            <div class="alert alert-danger">
              <strong>{{session('errorful')}}</strong>
            </div>
          @endif
          <div class="mb-3">
            <label for="contactName" class="form-label">Your Name</label>
            <input type="text" class="form-control form-control-sm" id="contactName" name="name" required>
          </div>
          <div class="mb-3">
            <label for="contactEmail" class="form-label">Email address</label>
            <input type="email" class="form-control form-control-sm" id="contactEmail" name="email" required>
          </div>
          <input type="hidden" name="subject" value="AutoServe | Web Enquiry">
          <div class="mb-3">
            <label for="contactMessage" class="form-label">Message</label>
            <textarea class="form-control form-control-sm" id="contactMessage" rows="4" name="message" required></textarea>
          </div>
          <button type="submit" class="btn btn-primary w-100">Send Message</button>
          <div id="contactFormMessage" class="mt-3"></div>
        </form>
      </div>
      <div class="col-md-6 d-flex flex-column justify-content-center animate__animated animate__fadeInRight">
        <div class="ps-md-4 bg-dark bg-opacity-75 p-4 rounded text-white">
          <div class="mb-3"><i class="bi bi-envelope-at text-primary fs-3 me-2"></i><a href="mailto:info@autoserve.com" class="text-white text-decoration-underline">info@autoserve.com.ng</a></div>
          <div class="mb-3"><i class="bi bi-telephone text-success fs-3 me-2"></i><a href="tel:+1234567890" class="text-white text-decoration-underline">+234 913 109 5135</a></div>
          <div class="mb-3"><i class="bi bi-geo-alt text-danger fs-3 me-2"></i>Peace Park Building, Utako, Abuja</div>
          <div class="alert alert-info mt-3">We respond within 24 hours. Your information is safe with us!</div>
        </div>
      </div>
    </div>
    <div style="position:absolute;top:-60px;right:-60px;width:180px;height:180px;background:rgba(13,110,253,0.08);border-radius:50%;z-index:0;"></div>
  </div>
</section>

  <!-- Footer Section -->
  <footer class="footer py-4 bg-dark text-white">
    <div class="container">
      <div class="row">
        <div class="col-md-6 mb-3 mb-md-0">
          <h5>AutoServe</h5>
          <p>Empowering Automobile Businesses</p>
        </div>
        <div class="col-md-6 text-md-end">
          <a href="#about" class="text-white me-3">About Us</a>
          <a href="#" class="text-white me-3" data-bs-toggle="modal" data-bs-target="#registerModal">Register</a>
          <a href="#contact" class="text-white">Contact</a>
        </div>
      </div>
      <div class="text-center mt-3">
        <small>&copy; {{date("Y")}} AutoServe. All rights reserved.</small>
      </div>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <!--Custom JS-->
  <script src="{{ asset('assets/js/auto.serve.scripts.js') }}"></script>
</body>
</html>
