@extends('layout')

@section('main')
<main role="main" class="container">
      <div class="row">
        <div class="col-md-8 blog-main">
          <h3 class="pb-3 mb-4 font-italic border-bottom">
            From the Firehose
          </h3>
          <div class="blog-post">
            <h2 class="blog-post-title">{{ $blog->data->title }}</h2>
            <p class="blog-post-meta">{{ date('M d Y', strtotime($blog->data->created_at)) }} 
            <p>{{ $blog->data->content }}</p>
            @foreach($blog->data->item_tag as $tag)
            <a href="{{ url('/tags?tags=' . $tag->tag->id) }}"><span class="badge badge-default">{{ $tag->tag->tags_name }}</span></a>
            @endforeach
          </div><!-- /.blog-post -->

        </div><!-- /.blog-main -->

        <aside class="col-md-4 blog-sidebar">
          <div class="p-3 mb-3 bg-light rounded">
            <h4 class="font-italic">About</h4>
            <p class="mb-0">Etiam porta <em>sem malesuada magna</em> mollis euismod. Cras mattis consectetur purus sit amet fermentum. Aenean lacinia bibendum nulla sed consectetur.</p>
          </div>

          <div class="p-3">
            <h4 class="font-italic">Archives</h4>
            <ol class="list-unstyled mb-0">
              @foreach($archive->data as $arc)
                <li><a href="{{ url('/archive/' . $arc->monthInt .'-'. $arc->year )}}">{{ $arc->month }} {{ $arc->year }}</a></li>              
              @endforeach
            </ol>
          </div>

          <div class="p-3">
            <h4 class="font-italic">Elsewhere</h4>
            <ol class="list-unstyled">
              <li><a href="#">GitHub</a></li>
              <li><a href="#">Twitter</a></li>
              <li><a href="#">Facebook</a></li>
            </ol>
          </div>
        </aside><!-- /.blog-sidebar -->

      </div><!-- /.row -->

    </main>
@endsection