@extends('layouts.category')
@section('title', 'Наши  путешествия')
@section('content')

	<div class="row">  
		
	
                     @foreach ($myBooks as $myBook)
					<div class="col-sm-6 col-md-4">
						<article id="post-63989" class="grid post-63989 post type-post status-publish format-standard has-post-thumbnail hentry myBook-ya-i-moi-knigi">
							<figure class="effect-smart">
							 <a href="{{route('putevoditel.item',$myBook->slug)}}">
							  <img
                            class="post-thumb lazyloaded"
                            src="{{ Storage:: url('/images/categoryMenu/ya-i-moi-knigi/'.$myBook->slug.'/'.$myBook->imageName.'.'.$myBook->imageExten) }}"
                              srcset="
   {{ Storage:: url('/images/categoryMenu/ya-i-moi-knigi/'.$myBook->slug.'/'.$myBook->imageName.'_thumb.'.$myBook->imageExten) }} 150w,
    {{ Storage:: url('/images/categoryMenu/ya-i-moi-knigi/'.$myBook->slug.'/'.$myBook->imageName.'_onesmall.'.$myBook->imageExten) }} 200w,
    {{ Storage:: url('/images/categoryMenu/ya-i-moi-knigi/'.$myBook->slug.'/'.$myBook->imageName.'_smalll.'.$myBook->imageExten) }} 400w,
    {{ Storage:: url('/images/categoryMenu/ya-i-moi-knigi/'.$myBook->slug.'/'.$myBook->imageName.'_medium.'.$myBook->imageExten) }} 600w,
   {{ Storage:: url('/images/categoryMenu/ya-i-moi-knigi/'.$myBook->slug.'/'.$myBook->imageName.'_768x768.'.$myBook->imageExten) }} 768w,
	{{ Storage:: url('/images/categoryMenu/ya-i-moi-knigi/'.$myBook->slug.'/'.$myBook->imageName.'_large.'.$myBook->imageExten) }} 1200w,

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
							  	<a href="{{route('putevoditel.item',$myBook->slug)}}"></a>
							  	<h2 class="entry-title">
							  		<a href="{{route('putevoditel.item',$myBook->slug)}}">

							  		</a>
							  		<a href="{{route('putevoditel.item',$myBook->slug)}}" rel="bookmark">{{$myBook->title}}</a>
							  	</h2>
							  	<p>{{$myBook->description}}</p>
							  </figcaption>
						     </figure>
						</article>
					</div>
    @endforeach
              
        </div>
   @endsection

