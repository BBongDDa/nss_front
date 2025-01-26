{{ XeFrontend::css('plugins/board/assets/css/widget.gallery.css')->load() }}


<div class="xf-main-article-widget xf-widget-main-board-article-wrap xf-widget-section {{ $sectionIdentifier ?? '' }} @if (isset($sectionIdentifier) && isset($sectionId)) {{ $sectionIdentifier.'-'.$sectionId }} @endif" style="padding-top: 0">
    <div class="gallery-widget">
        {{-- <h3 class="title">{{$title}}</h3> --}}
        
        @if($more)
        <a href="{{instance_route('index', [], $menuItem->id)}}" class="more">더보기<i class="xi-angle-right"></i></a>
        @endif

        <div class="article-list">
            @foreach ($list as $item)
                <a href="{{$urlHandler->getShow($item)}}">
                    <div class="article-title" >{!! $item->title !!}</div>
                    <span class="article-date" >{{$item->created_at->format('Y-m-d')}}</span>
                </a>
            @endforeach
        </div>

        <div class="article-tab-btn-wrap">
            <button class="btn-tab-left"> <i class="xi-angle-left-thin"></i></button>
            <button class="btn-tab-right"> <i class="xi-angle-right-thin"></i></button>
        </div>
    </div>
</div>

<style>
    .xf-main-article-widget{
        padding-bottom: 24px;
    }

    .xf-main-article-widget .article-tab-btn-wrap > button{
        border: 1px solid #555555;
        background-color: white;
        height: 32px;
        width: 32px
    }

    .xf-main-article-widget .article-tab-btn-wrap > button:disabled {
        color: #B7B7B7;
        border-color: #B7B7B7;
    }


    .xf-main-article-widget .article-title {
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        font-weight: 500;
        -webkit-box-orient: vertical;
        font-size: 16px;
        color: #555;
        margin-bottom: 20px;
    }

    .xf-main-article-widget .article-date {
        font-weight: 500;
        font-size: 13px;
        color: #B7B7B7;
    }
    .xf-main-article-widget .title {
        font-weight: 700;
        line-height: 33.89px;
        letter-spacing: -0.0092em;
        font-size: 28px;
        margin-bottom: 28px;
        color: #1F1F1F;
    }

    .xf-main-article-widget .more {
        right: 10px;
        top: 30px;
        position: absolute;
        font-style: normal;
        font-weight: 500;
        font-size: 16px;
        line-height: 22px;
        color: #B7B7B7;
        text-transform: uppercase;
    }
    .xf-main-article-widget .article-list {
        display: flex;
        overflow-x: auto;
        gap: 25px;
        padding-bottom: 10px;
    }

    .xf-main-article-widget .article-list > * {
        flex: 1;
        min-width: 154px;
        width: 154px;
    }

    .xf-main-article-widget .article-tab-btn-wrap {
        display: none;
        justify-content: flex-end;
        margin-top: 30px;
    }

    @media screen and (min-width: 768px) {
        .xf-main-article-widget .article-list {
            display: grid;
            position: relative;
            overflow-x: initial;
            row-gap: 41px;
            column-gap: 35px;
            grid-template-rows: repeat(2, minmax(0, 1fr));
            grid-template-columns: repeat(3, minmax(0, 1fr));
            padding-bottom: 0px;
        }

        .xf-main-article-widget .article-list::before {
            position: absolute;
            content: '';
            z-index: 1;
            top: 100px;
            width: 100%;
            height: 1px;
            background:  #EFEFEF;
        }


        
    }

    @media screen and (min-width: 992px) {
        .xf-main-article-widget{padding-bottom: 50px;}
        .xf-main-article-widget .title {
            line-height: 45.99px;
            font-size: 38px;
            margin-bottom: 20px;
        }
        .xf-main-article-widget .more { top: 60px; }

        .xf-main-article-widget .article-list {
            gap: 35px;
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }
        
        .xf-main-article-widget .article-tab-btn-wrap {
            display: flex;
        }
    }

    
    .xf-main-article-widget * {font-family: 'Inter'}
</style>

<script>
    (function () {
        var wrap = $(".{{ $sectionIdentifier.'-'.$sectionId }}");
        if(wrap.length === 0)return;

        var nowTab = 0;

        var list = wrap.find('.article-list').children();

        var leftBtn = wrap.find('.btn-tab-left');
        var rightBtn = wrap.find('.btn-tab-right');
        
        if(list.length > 6) {
            rightBtn.addClass('active');
        }

        function changeTab(start) {
            list.each(function (idx, el) {
                (start <= idx && idx < (start + 6)) 
                ? $(el).show()
                : $(el).hide();
            });

            if(start === 0) leftBtn.attr('disabled', true);
            else leftBtn.attr('disabled', false);
            
            if(start+6 >= list.length) rightBtn.attr('disabled', true);
            else rightBtn.attr('disabled', false);

            nowTab = start;
        }
        
        leftBtn.on('click', function () {
            changeTab(nowTab-6);
        });

        rightBtn.on('click', function () {
            changeTab(nowTab+6);
        });

        changeTab(nowTab);

    })();
    
</script>