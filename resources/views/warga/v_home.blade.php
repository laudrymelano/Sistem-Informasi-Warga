@extends('warga.v_master')
@section('title', 'Beranda')

@section('content')

  <!-- ======= Hero Section ======= -->
  <section id="hero" class="d-flex align-items-center">
    <div class="container position-relative" data-aos="fade-up" data-aos-delay="100">
      <div class="row justify-content-center">
        <div class="col-xl-7 col-lg-9 text-center">
          <h1>SIAGA</h1>
          <h2>Sistem Informasi Warga RW 007</h2>
        </div>
      </div>
    </div>
  </section><!-- End Hero -->
<!-- ======= About News Section ======= -->
<section id="about-video" class="about-video">
    <div class="container" data-aos="fade-up">
        
      <div class="section-title">
          <h2>Berita Terbaru</h2>
        </div>
        
      <div class="row">
        @foreach ($berita_utama as $berita_utama)
            
        <div class="col-lg-6 video-box align-self-baseline" data-aos="fade-right" data-aos-delay="100">
          <img src="{{asset('storage/'. $berita_utama->thumbnail)}}" class="rounded img-fluid" alt="">
        </div>
        
        <div class="col-lg-6 pt-3 pt-lg-0 content" data-aos="fade-left" data-aos-delay="100">
          @if ( Str::length(Auth::guard('user_warga')->user())>0)
          <h3><a href="beranda/berita/detail/{{$berita_utama->id}}">{{$berita_utama->judul}}</a></h3>
          @else 
          <h3><a href="/berita/detail/{{$berita_utama->id}}">{{$berita_utama->judul}}</a></h3>
          @endif
          <p class="fst-italic">
           {{$berita_utama->created_at}}
          </p>
          <p>
            {!! Str::limit(strip_tags($berita_utama->content), 300, '...') !!}
          </p>
          @if ( Str::length(Auth::guard('user_warga')->user())>0)
          <p style="padding-top: 15px"><a style="text-decoration: underline" href="beranda/berita/detail/{{$berita_utama->id}}" class="bi">Lanjutkan Membaca</a> </p>
          @else
          <p style="padding-top: 15px"><a style="text-decoration: underline" href="/berita/detail/{{$berita_utama->id}}" class="bi">Lanjutkan Membaca</a> </p>
          @endif
        </div>
        @endforeach
      </div>
      
    </div>
  </section><!-- End About Video Section -->
  
  <!-- ======= Services Section ======= -->
  <section id="services" class="services section-bg">
  <div class="container" data-aos="fade-up">   
      <div class="section-title">
              <h2>Berita Lainnya</h2>
      </div>
      @csrf
  <div class="row">
   @foreach ($data_berita as $db)   
    <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4" data-aos="zoom-in" data-aos-delay="100">
      <div class="icon-box iconbox-yellow">
        <img src="{{asset('storage/'. $db->thumbnail)}}" class="rounded img-fluid" alt="">
        @if ( Str::length(Auth::guard('user_warga')->user())>0)
        <h4 ><a href="/beranda/berita/detail/{{$db->id}}">{{$db->judul}}</a></h4>
        @else
        <h4 ><a href="/berita/detail/{{$db->id}}">{{$db->judul}}</a></h4>
        @endif
        <i>{{$db->created_at}}</i>
        <p>
          {!! Str::limit(strip_tags($db->content), 200, '...') !!}
        </p>
        @if ( Str::length(Auth::guard('user_warga')->user())>0)
        <p style="padding-top: 15px;"><a style="text-decoration: underline" href="/beranda/berita/detail/{{$db->id}}" class="bi">Lanjutkan Membaca</a></p>
        @else
        <p style="padding-top: 15px;"><a style="text-decoration: underline" href="/berita/detail/{{$db->id}}" class="bi">Lanjutkan Membaca</a></p>
        @endif
      </div>
    </div>
    @endforeach
  </div>

      @if ( Str::length(Auth::guard('user_warga')->user())>0)
      <div class="row">
        <div class="col-md-12 text-center">
          <a href="{{url('/beranda/berita/list')}}" class="btn btn-icon btn-outline-primary rounded-pill btn-md " style="margin-top: 40px" type="submit">Lihat Semua</a>
        </div>
      </div>
      @else
      <div class="row">
        <div class="col-md-12 text-center">
          <a href="{{url('/berita/list')}}" class="btn btn-icon btn-outline-primary rounded-pill btn-md " style="margin-top: 40px" type="submit">Lihat Semua</a>
        </div>
      </div>

      @endif
      
    </div>
</section><!-- End Sevices Section -->

<!-- ======= Contact Section ======= -->
<section id="contact" class="contact">
    <div class="container" data-aos="fade-up">
        
      <div class="section-title">
        <h2>Hubungi Kami</h2>
        <p>Magnam dolores commodi suscipit. Necessitatibus eius consequatur ex aliquid fuga eum quidem. Sit sint consectetur velit. Quisquam quos quisquam cupiditate. Et nemo qui impedit suscipit alias ea. Quia fugiat sit in iste officiis commodi quidem hic quas.</p>
      </div>

      <div>
        <iframe style="border:0; width: 100%; height: 270px;" src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d12097.433213460943!2d-74.0062269!3d40.7101282!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xb89d1fe6bc499443!2sDowntown+Conference+Center!5e0!3m2!1smk!2sbg!4v1539943755621" frameborder="0" allowfullscreen></iframe>
      </div>

      <div class="row mt-4">    
        {{-- <div class="col-lg-4">
          <div class="info">
            <div class="address">
              <i class="bi bi-geo-alt"></i>
              <h4>Location:</h4>
              <p>A108 Adam Street, New York, NY 535022</p>
            </div>
          </div>
        </div> --}}
        
        <div class="col-lg-4">
          <div class="info">
            <div class="email">
              <i class="bi bi-geo-alt"></i>
              <h4>Location:</h4>
              <p>A108 Adam Street, New York, NY 535022</p>
            </div>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="info">
            <div class="email">
              <i class="bi bi-envelope"></i>
              <h4>Email:</h4>
              <p>info@example.com</p>
            </div>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="info">
            <div class="phone">
                <i class="bi bi-phone"></i>
                <h4>Call:</h4>
                <p>+1 5589 55488 55s</p>
            </div>
          </div>
        </div>
      </div>     
        

    {{-- <div class="col-lg-8 mt-5 mt-lg-0">
        
        <form action="forms/contact.php" method="post" role="form" class="php-email-form">
            <div class="row">
                <div class="col-md-6 form-group">
                    <input type="text" name="name" class="form-control" id="name" placeholder="Your Name" required>
                </div>
              <div class="col-md-6 form-group mt-3 mt-md-3">
                  <input type="email" class="form-control" name="email" id="email" placeholder="Your Email" required>
                </div>
            </div>
            <div class="form-group mt-3">
                <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject" required>
            </div>
            <div class="form-group mt-3">
                <textarea class="form-control" name="message" rows="5" placeholder="Message" required></textarea>
            </div>
            <div class="my-3">
                <div class="loading">Loading</div>
              <div class="error-message"></div>
              <div class="sent-message">Your message has been sent. Thank you!</div>
            </div>
            <div class="text-center"><button type="submit">Send Message</button></div>
        </form>
    </div> --}}
 

      
    </div>
</section><!-- End Contact Section -->
@endsection