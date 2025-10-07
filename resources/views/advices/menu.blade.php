@extends('layouts.category')
@section('title', 'Советы и Полезности')
@section('content')

	<div class="row">
		
                     @foreach ($advices as $advice)
					<div class="col-sm-6 col-md-4">
						<article id="post-63989" class="grid post-63989 post type-post status-publish format-standard has-post-thumbnail hentry advice-putevoditeli">
							<figure class="effect-smart">
							 <a href="{{route('putevoditel.item',$advice->slug)}}">
							  <img
                            class="post-thumb lazyloaded"
                            src="{{ Storage:: url('/images/categoryMenu/sovety-i-poleznosti/'.$advice->slug.'/'.$advice->imageName.'.'.$advice->imageExten) }}"
                             srcset="
   {{ Storage:: url('/images/categoryMenu/sovety-i-poleznosti/'.$advice->slug.'/'.$advice->imageName.'_thumb.'.$advice->imageExten) }} 150w,
    {{ Storage:: url('/images/categoryMenu/sovety-i-poleznosti/'.$advice->slug.'/'.$advice->imageName.'_onesmall.'.$advice->imageExten) }} 200w,
    {{ Storage:: url('/images/categoryMenu/sovety-i-poleznosti/'.$advice->slug.'/'.$advice->imageName.'_smalll.'.$advice->imageExten) }} 400w,
    {{ Storage:: url('/images/categoryMenu/sovety-i-poleznosti/'.$advice->slug.'/'.$advice->imageName.'_medium.'.$advice->imageExten) }} 600w,
   {{ Storage:: url('/images/categoryMenu/sovety-i-poleznosti/'.$advice->slug.'/'.$advice->imageName.'_768x768.'.$advice->imageExten) }} 768w,
	{{ Storage:: url('/images/categoryMenu/sovety-i-poleznosti/'.$advice->slug.'/'.$advice->imageName.'_large.'.$advice->imageExten) }} 1200w,

  "
  sizes="(max-width: 576px) 150px, (max-width: 992px) 200px, 768px" 
                            data-ll-status="loaded"
                          />
							  <noscript><img class="post-thumb" src="https://greenvaliza.co.ua/wp-content/uploads/2025/05/riga40-768x768.jpg" alt="Рига. Путеводитель" /></noscript>
							</a>
							  <figcaption>
							  	<a href="{{route('putevoditel.item',$advice->slug)}}"></a>
							  	<h2 class="entry-title">
							  		<a href="{{route('putevoditel.item',$advice->slug)}}">

							  		</a>
							  		<a href="{{route('putevoditel.item',$advice->slug)}}" rel="bookmark">{{$advice->title}}</a>
							  	</h2>
							  	<p>{{$advice->description}}</p>
							  </figcaption>
						     </figure>
						</article>
					</div>
    @endforeach
               
 </div>
 @endsection
