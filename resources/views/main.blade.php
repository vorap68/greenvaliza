@extends('layouts.category')

@section('content')
 
                <div class="row">
                  @foreach ($categories as $category)

                  <!-- Блок 1 -->
                  <div class="col-sm-6 col-md-4">
                    <article class="grid hentry">
                      <figure class="effect-smart">
                        <a href="{{ route($category->slug)}}" rel="bookmark">
                          <img
                            class="post-thumb lazyloaded"
                            src="{{ Storage:: url('images/categories/'.$category->slug.'/'.$category->imageName.'.'.$category->imageExten) }}"
                              srcset="
    {{ Storage::url('images/categories/'.$category->slug.'/'.$category->imageName.'_thumb.'.$category->imageExten) }} 150w,
    {{ Storage::url('images/categories/'.$category->slug.'/'.$category->imageName.'_onesmall.'.$category->imageExten) }} 200w,
    {{ Storage::url('images/categories/'.$category->slug.'/'.$category->imageName.'_smalll.'.$category->imageExten) }} 400w,
    {{ Storage::url('images/categories/'.$category->slug.'/'.$category->imageName.'_medium.'.$category->imageExten) }} 600w,
    {{ Storage::url('images/categories/'.$category->slug.'/'.$category->imageName.'_768x768.'.$category->imageExten) }} 768w,
    {{ Storage::url('images/categories/'.$category->slug.'/'.$category->imageName.'_large.'.$category->imageExten) }} 1200w,
  "
 
  sizes="(max-width: 576px) 150px, (max-width: 992px) 200px, 768px" 
  
                            data-ll-status="loaded"
                          />
                          <noscript>
                            <img
                              class="post-thumb"
                              src="{{ Storage:: url('images/categories/'.$category->slug.'/'.$category->imageName.'.'.$category->imageExten) }}"
                            />
                          </noscript>
                        </a>
                        <figcaption>
                          <h2 class="entry-title">
                            <a href="{{ route($category->slug)}}" rel="bookmark">
                              {{$category->title}}
                            </a>
                          </h2>
                          <p>
                            {{$category->description  }}
                          </p>
                        </figcaption>
                      </figure>
                    </article>
                  </div>
@endforeach

                </div>
               
@endsection
