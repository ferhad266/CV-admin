@extends('layouts.front')

@section('title')
    Portfolio
@endsection

@section('css')
@endsection

@section('content')
    <section class="portfolio-section">
        <h2 class="section-title">PORTFOLIO</h2>

        @foreach($portfolio as $item)
            <div class="portfolio-wrapper">
                <figure class="portfolio-item hover-box">
                    <a href="{{route('portfolio.detail',['id' => $item->id])}}">
                        <img src="{{asset('storage/portfolio/'.$item->featuredImage->image)}}" alt="{{$item->title}}"
                             class="portfolio-item-img">
                    </a>
                    <figcaption class="portfolio-item-details overlay">
                        <h5 class="portfolio-item-title">{{$item->title}}</h5>
                        <p class="portfolio-item-description">{!! $item->about !!}</p>
                    </figcaption>
                </figure>
            </div>
        @endforeach

    </section>
@endsection

@section('js')
@endsection
