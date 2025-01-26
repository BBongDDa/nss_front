{{ XeFrontend::js('plugins/board/assets/js/board.js')->appendTo('body')->load() }}
{{ XeFrontend::js('assets/core/xe-ui-component/js/xe-page.js')->appendTo('body')->load() }}

{{ XeFrontend::css('plugins/board/assets/css/new-board-common.css')->load() }}
{{ XeFrontend::css('plugins/board/assets/css/new-board-header.css')->load() }}
{{ XeFrontend::css('plugins/board/assets/css/new-board-footer.css')->load() }}

{{ expose_trans('board::selectPost') }}
{{ expose_trans('board::selectBoard') }}
{{ expose_trans('board::msgDeleteConfirm') }}



<section class="xf-faq-board xf-board">
    @if (request()->segment(2) === null)
        <div class="xf-board-header xf-faq-flex-col">
            {{-- [D] todo 서브 타이틀 --}}
            <div class="xf-title-box border-b-pb-12">
                <h2 class="xf-title base-h2">
                    @if (xe_trans($config->get('boardName', '')) !== '')
                        {{ xe_trans($config->get('boardName')) }}
                    @else
                        {{ xe_trans(current_menu()['title']) }}
                    @endif
                    <span>오즈아레나 고객센터입니다</span>
                </h2>
                <div class="xf-sub-title">{{ array_get($skinConfig, 'board-description', '') }}</div>
                <div class="xf-search-box">
                    <form method="get" action="{{ $urlHandler->get('index') }}" class="xf-category-search-form __search-form">
                        <input type="hidden" name="category_item_id" value="{{ Request::get('category_item_id') }}">

                        {{-- <div class="xf-option xf-option-keyword">
                            <select name="search_target" class="xf-select xf-option-keyword-select __search-type">
                                <option value="title" @if (Request::get('search_target', 'title') === 'title') selected @endif>제목</option>
                                <option value="pure_content" @if (Request::get('search_target') === 'pure_content') selected @endif>내용</option>
                            </select>
                        </div> --}}
                        <div class="xf-input-box">
                            <input type="text"  class="xf-input __search-value" name="search_keyword" placeholder="궁금한 점이 있다면 도움말을 검색해 보세요" value="{{ Request::get('search_keyword', '') }}">
                            <button type="submit" class="xf-btn"></button>
                        </div>
                    </form>
                </div>
            </div>
            {{-- <a class="base-btn base-primary-btn xf-customer-btn" href="/customer_voice">
                고객의 소리
            </a> --}}
            <div class="swiper notice-swiper-container">
                <div class="swiper-wrapper">
                    <a href="#" class="swiper-slide faq-notice-list-wrap">
                        <label>공지사항</label>
                        <P>코로나19 사회적 거리두기 4단계 연장 안내</P>
                    </a>
                    <a href="#" class="swiper-slide faq-notice-list-wrap">
                        <label>공지사항</label>
                        <P>옵티멈존 PC카페 수유점 와이파이 제공 일시중단 안내</P>
                    </a>
                </div>
            </div>

            <script>
                const swiper = new Swiper('.notice-swiper-container', {
                    direction: 'vertical',
                    slidesPerView: 1,
                    debugger: true,
                    loop: true,
                    autoplay: {
                        delay: 2500,
                        disableOnInteraction: false,
                     },
                });
            </script>
        </div>
    @endif



    <div class="xf-board-header">
        {{-- [D] todo 서브 타이틀 --}}
        <div class="xf-title-box">
            <h2 class="xf-title base-h2">
                도움말
                <span>원하는 도움말 카테고리를 선택하세요</span>
            </h2>
            <div class="xf-sub-title">{{ array_get($skinConfig, 'board-description', '') }}</div>
            <a class="xf-more-tab-btn" href="#">
                더보기
            </a>
        </div>
        {{-- <a class="base-btn base-primary-btn xf-customer-btn" href="/customer_voice">
            고객의 소리
        </a> --}}
    </div>


    @if (request()->segment(2) === null)
        <div class="xf-board-footer">
            <div class="xf-footer-board-btn-box">
                @if ($isManager === true)
                    <div class="xf-board-left-btn-box">
                        <a href="{{ $urlHandler->managerUrl('config', ['boardId' => $instanceId]) }}"
                           class="xf-board-btn xf-board-btn__setting" target="_blank">Manage</a>
                    </div>
                @endif
                <div class="xf-board-right-btn-box">
                    @if (auth()->user()->isAdmin() === true)
                        <a href="{{ $urlHandler->get('create') }}" class="xf-board-btn xf-board-btn__write">Writing</a>
                    @endif
                </div>
            </div>

            {!! $paginate->render($_skin::view('default-pagination')) !!}
        </div>
    @endif
</section>
