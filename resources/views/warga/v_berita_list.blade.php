@extends('warga.v_master')
@section('title', 'Berita')
@section('content')

<section id="services" class="services section-bg">
    <div class="container" data-aos="fade-up">
        
    <div class="section-title" style="margin-top: 50px">
            <h2>Semua Berita</h2>
    </div>
    
    <div class="row">
  @foreach ($list_berita as $lb)   
  <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4" data-aos="zoom-in" data-aos-delay="100">
    <div class="icon-box iconbox-yellow">
      <img src="{{asset('storage/'. $lb->thumbnail)}}" class="rounded img-fluid" alt="">
      @if ( Str::length(Auth::guard('user_warga')->user())>0)
      <h4 ><a href="/beranda/berita/list/detail/{{$lb->id}}">{{$lb->judul}}</a></h4>
      @else
      <h4 ><a href="/berita/list/detail/{{$lb->id}}">{{$lb->judul}}</a></h4>
      @endif
      <i>{{$lb->created_at}}</i>
      <p>
        {!! Str::limit(strip_tags($lb->content), 200, '...') !!}
      </p>
      @if ( Str::length(Auth::guard('user_warga')->user())>0)
      <p style="padding-top: 15px;"><a style="text-decoration: underline" href="/beranda/berita/list/detail/{{$lb->id}}" class="bi">Lanjutkan Membaca</a></p>
      @else
      <p style="padding-top: 15px;"><a style="text-decoration: underline" href="/berita/list/detail/{{$lb->id}}" class="bi">Lanjutkan Membaca</a></p>
      @endif
    </div>
  </div>
  @endforeach

  @if ( Str::length(Auth::guard('user_warga')->user())>0)
  <div class="row">
    <div class="col-md-4 col-md-12 text-center">
      <a href="{{url('/beranda')}}" class="btn btn-icon btn-outline-primary rounded-pill btn-md" style="margin-top: 40px" type="submit">Kembali</a>
  </div>
  @else
  <div class="row">
    <div class="col-md-4 col-md-12 text-center">
      <a href="{{url('/')}}" class="btn btn-icon btn-outline-primary rounded-pill btn-md" style="margin-top: 40px" type="submit">Kembali</a>
  </div>
</div>
  </div>
@endif
    
  </div>
</section><!-- End Sevices Section -->

@endsection