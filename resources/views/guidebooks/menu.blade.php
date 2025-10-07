@extends('layouts.category')
@section('title', 'Путеводители')
@section('content')

	<div class="row">
		
                     @foreach ($guidebooks as $guidebook)
					<div class="col-sm-6 col-md-4">
						<article id="post-63989" class="grid post-63989 post type-post status-publish format-standard has-post-thumbnail hentry guidebook-putevoditeli">
							<figure class="effect-smart">
							 <a href="{{route('putevoditel.item',$guidebook->slug)}}">
							  <img
                            class="post-thumb lazyloaded"
                            src="{{ Storage:: url('/images/categoryMenu/putevoditeli/'.$guidebook->slug.'/'.$guidebook->imageName.'.'.$guidebook->imageExten) }}"
                              srcset="
   {{ Storage:: url('/images/categoryMenu/putevoditeli/'.$guidebook->slug.'/'.$guidebook->imageName.'_150x150.'.$guidebook->imageExten) }} 150w,
    {{ Storage:: url('/images/categoryMenu/putevoditeli/'.$guidebook->slug.'/'.$guidebook->imageName.'_200x200.'.$guidebook->imageExten) }} 200w,
   {{ Storage:: url('/images/categoryMenu/putevoditeli/'.$guidebook->slug.'/'.$guidebook->imageName.'_768x768.'.$guidebook->imageExten) }} 768w
  "
    sizes="(max-width: 576px) 100vw,   
         (max-width: 992px) 50vw,    
         (max-width: 1400px) 33vw,   
         25vw"      
                            data-ll-status="loaded"
                          />
							  <noscript><img class="post-thumb" src="https://greenvaliza.co.ua/wp-content/uploads/2025/05/riga40-768x768.jpg" alt="Рига. Путеводитель" /></noscript>
							</a>
							  <figcaption>
							  	<a href="{{route('putevoditel.item',$guidebook->slug)}}"></a>
							  	<h2 class="entry-title">
							  		<a href="{{route('putevoditel.item',$guidebook->slug)}}">

							  		</a>
							  		<a href="{{route('putevoditel.item',$guidebook->slug)}}" rel="bookmark">{{$guidebook->title}}</a>
							  	</h2>
							  	<p>{{$guidebook->description}}</p>
							  </figcaption>
						     </figure>
						</article>
					</div>
    @endforeach
               
 </div>
 @endsection
