@extends('layouts.category')
@section('title', 'Наши  путешествия')
@section('content')

	<div class="row">  
		
	
                     @foreach ($travels as $travel)
					<div class="col-sm-6 col-md-4">
						<article id="post-63989" class="grid post-63989 post type-post status-publish format-standard has-post-thumbnail hentry travel-nashi-puteshestviya">
							<figure class="effect-smart">
							 <a href="{{route('putevoditel.item',$travel->slug)}}">
							  <img
                            class="post-thumb lazyloaded"
                            src="{{ Storage:: url('/images/categoryMenu/nashi-puteshestviya/'.$travel->slug.'/'.$travel->imageName.'.'.$travel->imageExten) }}"
                              srcset="
   {{ Storage:: url('/images/categoryMenu/nashi-puteshestviya/'.$travel->slug.'/'.$travel->imageName.'_thumb.'.$travel->imageExten) }} 150w,
    {{ Storage:: url('/images/categoryMenu/nashi-puteshestviya/'.$travel->slug.'/'.$travel->imageName.'_onesmall.'.$travel->imageExten) }} 200w,
    {{ Storage:: url('/images/categoryMenu/nashi-puteshestviya/'.$travel->slug.'/'.$travel->imageName.'_smalll.'.$travel->imageExten) }} 400w,
    {{ Storage:: url('/images/categoryMenu/nashi-puteshestviya/'.$travel->slug.'/'.$travel->imageName.'_medium.'.$travel->imageExten) }} 600w,
   {{ Storage:: url('/images/categoryMenu/nashi-puteshestviya/'.$travel->slug.'/'.$travel->imageName.'_768x768.'.$travel->imageExten) }} 768w,
	{{ Storage:: url('/images/categoryMenu/nashi-puteshestviya/'.$travel->slug.'/'.$travel->imageName.'_large.'.$travel->imageExten) }} 1200w,

  "
   sizes="(max-width: 576px) 150px,
       (max-width: 768px) 200px,
       (max-width: 992px) 400px,
       (max-width: 1200px) 600px,
       (max-width: 1400px) 768px,
       1200px"
                            data-ll-status="loaded"
                          />
							  <noscript><img class="post-thumb" src="https://greenvaliza.co.ua/wp-content/uploads/2025/05/riga40-768x768.jpg" alt="Рига. Путеводитель" /></noscript>
							</a>
							  <figcaption>
							  	<a href="{{route('putevoditel.item',$travel->slug)}}"></a>
							  	<h2 class="entry-title">
							  		<a href="{{route('putevoditel.item',$travel->slug)}}">

							  		</a>
							  		<a href="{{route('putevoditel.item',$travel->slug)}}" rel="bookmark">{{$travel->title}}</a>
							  	</h2>
							  	<p>{{$travel->description}}</p>
							  </figcaption>
						     </figure>
						</article>
					</div>
    @endforeach
              
        </div>
   "@endsection"

