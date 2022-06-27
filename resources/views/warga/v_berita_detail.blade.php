@extends('warga.v_master')
@section('title', 'Berita')
@section('content')
<main id="main">
    @foreach($detail_berita as $db)

    <!-- ======= Breadcrumbs ======= -->
    <section class="breadcrumbs">
      <div class="container">
        <div class="d-flex justify-content-between align-items-center">
          <h1>{{$db->judul}}</h1>
        </div>
        <p>{{$db->created_at}}</p>
      </div>
    </section><!-- End Breadcrumbs -->

    <section class="inner-page">
      <div class="container">
        <section id="thumbnail" style="padding-top: 0px;">
            <img class="rounded card-img  img-fluid" src="{{asset('storage/'. $db->thumbnail)}}">
            <p>
              {!!$db->content!!}
            </p>
            <hr style="height:2px; margin-top: 30px;">
            @if($db->gambar1 || $db->gambar != null)
            <h3>Foto Lainnya</h3>
            <div class="row">
              <div class="col-md-4">
                <img class="rounded card-img" style="height: 300px" src="{{asset('storage/'. $db->gambar1)}}"> 
              </div>
              <div class="col-md-4">
              <img class="rounded card-img" style="height: 300px" src="{{asset('storage/'. $db->gambar2)}}">
              </div>
            </div>
            @endif
            @if($db->attachment != null)
            <hr style="height:2px; margin-top: 30px;">
            <h3>File Pendukung</h3>
            <a class="btn btn-primary btn-md" href="{{ asset('storage/'.$db->attachment)}}" target="_blank"><i class="fa fa-file"></i></a>
            @endif
            @if ( Str::length(Auth::guard('user_warga')->user())>0)
            <div class="row float-end">
              <div class="col-md-4 ">
                <a href="{{url('/beranda')}}" class="btn btn-icon btn-secondary rounded-pill btn-sm" style="margin-top: 40px" type="submit">Kembali</a>
            </div>
            @else
            <div class="row float-end">
              <div class="col-md-4">
                <a href="{{url('/')}}" class="btn btn-icon btn-secondary rounded-pill btn-sm" style="margin-top: 40px" type="submit">Kembali</a>
            </div>
          </div>
          @endif
        </section>
      </div>
    </section>
    @endforeach
  </main><!-- End #main -->
    
@endsection