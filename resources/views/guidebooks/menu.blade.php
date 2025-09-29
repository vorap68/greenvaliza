@extends('layouts.category')
@section('title', 'Путеводители')
@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12">

			<div class="welcome-section sub-header">
				<h1 class="page-title">Путеводители</h1>
			</div>
		</div>
		<div class="col-md-12">
			<div id="primary" class="content-area">
				<main id="main" class="site-main row" role="main">
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
  sizes="(max-width: 576px) 150px, (max-width: 992px) 200px, 768px" 
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
                </main>
             </div>
        </div>
     </div>
 </div>
