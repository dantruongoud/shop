@extends('frontend.layouts.layout_blog')
@section('content')
<div class="blog-post-area">
    <h2 class="title text-center">Latest From our Blog</h2>
    <div class="single-blog-post">
        <h3>{{ $data->title }}</h3>
        <div class="post-meta">
            <ul>
                <li><i class="fa fa-user"></i> Mac Doe</li>
                <li><i class="fa fa-clock-o"></i> 1:33 pm</li>
                <li><i class="fa fa-calendar"></i> DEC 5, 2013</li>
            </ul>
            <!-- <span>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star-half-o"></i>
            </span> -->
        </div>
        <a>
            <img src="{{ asset('frontend/images/blog/' . $data->image ) }}" alt="">
        </a>

        {!! $data->content !!}

        {{-- <div class="pager-area">
            <ul class="pager pull-right">
                <li><a href="#">Pre</a></li>
                <li><a href="#">Next</a></li>
            </ul>
        </div> --}}
        <div class="pager-area">
            <ul class="pager pull-right">

                @if ($preBlog)
                <li><a href="{{ url('frontend/blog/blog-detail/'. $preBlog->id) }}">Pre</a></li>
                @endif

                @if ($nextBlog)
                <li><a href="{{ url('frontend/blog/blog-detail/'. $nextBlog->id) }}">Next</a></li>
                @endif
            </ul>
        </div>
    </div>
</div>
<!--/blog-post-area-->

<div class="rating-area">
    <ul class="ratings">
        <li class="rate-this">Rate this item:</li>
        <li>
            <div class="rate">
                <div class="vote">
                    <div class="star_1 ratings_stars @if($avg >= 1) ratings_over @endif"><input value="1" type="hidden">
                    </div>
                    <div class="star_2 ratings_stars @if($avg >= 2) ratings_over @endif"><input value="2" type="hidden">
                    </div>
                    <div class="star_3 ratings_stars @if($avg >= 3) ratings_over @endif"><input value="3" type="hidden">
                    </div>
                    <div class="star_4 ratings_stars @if($avg >= 4) ratings_over @endif"><input value="4" type="hidden">
                    </div>
                    <div class="star_5 ratings_stars @if($avg == 5) ratings_over @endif"><input value="5" type="hidden">
                    </div>
                    <span class="rate-np">{{ $avg }}</span>
                </div>
            </div>
        </li>
        <li class="color">({{ $sum_rate }} vote)</li>
    </ul>
    <ul class="tag">
        <li>TAG:</li>
        <li><a class="color" href="">Pink <span>/</span></a></li>
        <li><a class="color" href="">T-Shirt <span>/</span></a></li>
        <li><a class="color" href="">Girls</a></li>
    </ul>
</div>
<!--/rating-area-->

<div class="socials-share">
    <a href=""><img src="images/blog/socials.png" alt=""></a>
</div>
<!--/socials-share-->

<!--Comments-->
<div class="response-area">
    <h2>{{ count($data_cmt) }} RESPONSES</h2>
    <ul class="media-list">
        @foreach ($data_cmt as $cmt)
        
        @if ($cmt->level == 0)
        <li class="media">
            <a class="pull-left" href="#">
                <img class="media-object" src="{{ asset('frontend/images/user-avatr/' . $user_info['avatar']) }}"
                    alt="">
            </a>
            <div class="media-body">
                <ul class="sinlge-post-meta">
                    <li><i class="fa fa-user"></i>{{ $user_info['name'] }}</li>
                    <li><i class="fa fa-clock-o"></i> {{ $cmt['created_at']->format('g:i A') }} </li>
                    <li><i class="fa fa-calendar"></i> {{ $cmt['created_at']->format('M d, Y') }}</li>
                </ul>
                <p>{{ $cmt['comment'] }}</p>
                <a class="btn btn-primary reply-btn" data-level="{{ $cmt->id }}">
                    <i class="fa fa-reply"></i>Reply
                </a>
            </div>
        </li>
            
        @endif
        
        @foreach ($data_cmt as $reply)
        @if ($reply->level == $cmt->id)
            <li class="media second-media">
                <a class="pull-left" href="#">
                    <img class="media-object" src="{{ asset('frontend/images/user-avatr/' . $user_info['avatar']) }}" alt="">
                </a>
                <div class="media-body">
                    <ul class="sinlge-post-meta">
                        <li><i class="fa fa-user"></i>{{ $user_info['name'] }}</li>
                        <li><i class="fa fa-clock-o"></i> {{ $reply->created_at->format('g:i A') }} </li>
                        <li><i class="fa fa-calendar"></i> {{ $reply->created_at->format('M d, Y') }}</li>
                    </ul>
                    <p>{{ $reply->comment }}</p>
                    <a class="btn btn-primary"><i class="fa fa-reply"></i>Replay</a>
                </div>
            </li>
        @endif
        @endforeach
        
        @endforeach

    </ul>
</div>

<!--/Response-area-->
<div class="replay-box">
    <div class="row">
        <div class="col-sm-12">
            <h2 style="margin-bottom: 10px">Leave a replay</h2>
            <div class="text-area" style="margin-top: 10px">
                <div class="blank-arrow">
                    <label>Your Name</label>
                </div>
                <span>*</span>
                <input type="hidden" name="level">
                <textarea id="replyTextarea" style=" min-height: 10em" name="comment" class="textarea is-warning"
                placeholder="Enter anything do you want..."></textarea>

                <div style="height: 40px" class="reply-content">
                    <p>
                        {{ $cmt->content }}
                    </p>
                </div>

                <button id="post_cmt" name="submit" type="submit" class="btn btn-primary" href="">Post Comment</button>
            </div>
        </div>
    </div>
</div>
<!--/Repaly Box-->

<script>
    $(document).ready(function(){
        $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
        });
        

        if ($('input[name="level"]').val()) {
            $('.reply-content').show();
        } else {
            $('.reply-content').hide();
        }
                //vote
        $('.ratings_stars').hover(
            // Handles the mouseover
            function() {
                $(this).prevAll().andSelf().addClass('ratings_hover');
                // $(this).nextAll().removeClass('ratings_vote');
            },
            function() {
                $(this).prevAll().andSelf().removeClass('ratings_hover');
                // set_votes($(this).parent());
            }
        );

        $('.ratings_stars').click(function(){
            var checkLogin = "{{ Auth::check() }}";
            if (checkLogin) {
                var rate = $(this).find("input").val();

                if ($(this).hasClass('ratings_over')) {
                    $('.ratings_stars').removeClass('ratings_over');
                    $(this).prevAll().andSelf().addClass('ratings_over');
                } else {
                    $(this).prevAll().andSelf().addClass('ratings_over');
                }

                $.ajax({
                    method: "POST",
                    url: "{{ url('/frontend/blog/blog-detail/rate') }}",
                    data: {
                        rate: rate,
                        id_blog: "{{ $data->id }}",
                        id_user: "{{ Auth::id() }}"
                    },
                    success : function(res){
                        console.log(res);
                    }
                });
            } else {
                alert('Please login to website');
            }
        });

        var comment = $('textarea[name="comment"]');
        $('#post_cmt').click(function(){
            var checkLogin = "{{ Auth::check() }}";

            if (checkLogin) {
                var commentValue = comment.val();

                if (commentValue == "") {
                    alert('Please enter your comment');
                } else {

                    if ($('input[name="level"]').val()) {
                        var getValue = $('input[name="level"]').val().trim();
                        $.ajax({
                        method: "POST",
                        url: "{{ url('/frontend/blog/blog-detail/comment') }}",
                        data: {
                            comment: commentValue,
                            id_blog: "{{ $data->id }}",
                            id_user: "{{ Auth::id() }}",
                            level: getValue
                        },
                        success : function(res){
                            comment.val('');
                        }
                    });
                    } else {
                        $.ajax({
                            method: "POST",
                            url: "{{ url('/frontend/blog/blog-detail/comment') }}",
                            data: {
                                comment: commentValue,
                                id_blog: "{{ $data->id }}",
                                id_user: "{{ Auth::id() }}",
                                level: 0
                            },
                            success : function(res){
                                comment.val('');
                            }
                        });
                    }
                }
            } else {
                alert('Please login to website');
            }
        });

        $('.reply-btn').click(function(){
            var replyContent = $(this).closest('.media-body').find('p').text();
            var level = $(this).data('level');

            // Hiển thị nội dung đang reply trong textarea
            $('div.reply-content > p').text(replyContent);

            // Lưu level và id của comment đang reply vào hidden input
            $('input[name="level"]').val(level);

            $('.reply-content').show();

            // Cuộn xuống textarea
            $('html, body').animate({
                scrollTop: $('#replyTextarea').offset().top
            }, 900);

            
            // var comment = $('textarea[name="comment"]');
            // var commentValue = comment.val();

            // $.ajax({
            //     method: "POST",
            //     url: "{{ url('/frontend/blog/blog-detail/reply') }}",
            //     data: {
            //         comment: commentValue,
            //         id_blog: "{{ $data->id }}",
            //         id_user: "{{ Auth::id() }}",
            //         level: level,
            //     },
            //     success : function(res){
            //         comment.val(res);
            //     }
            // });
        });
    });
</script>

@endsection
