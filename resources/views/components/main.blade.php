@extends('layout')

@section('main')
<main role="main" class="container">
      <div class="row">
        <div class="col-md-8 blog-main">
          <h3 class="pb-3 mb-4 font-italic border-bottom">
            From the Firehose
          </h3>
          @foreach($blog->data->data as $bg)
          <div class="blog-post">
            <h2 class="blog-post-title"><a href="{{ url('blog/' . $bg->id) }}">{{ $bg->title }}</a></h2>
            <p class="blog-post-meta">{{ date('M d Y', strtotime($bg->created_at)) }} 
            <p>{{ $bg->content }}</p>
            @foreach($bg->item_tag as $tag)
            <a href="{{ url('/tags?tags=' . $tag->tag->id) }}"><span class="badge badge-default">{{ $tag->tag->tags_name }}</span></a>
            @endforeach
          </div><!-- /.blog-post -->
          @endforeach
          

          <nav class="blog-pagination">
            <a class="btn btn-outline-primary" href="{{ url('/?url='.$blog->data->next_page_url) }}">Older</a>
            <a class="btn btn-outline-secondary" href="{{ url('/?url='.$blog->data->prev_page_url) }}">Newer</a>
          </nav>

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