{{ XeFrontend::css(['plugins/board/assets/css/xe-board-common.css','plugins/custom_plugin/src/Skins/NssBoardPubliSkin/assets/css/skin.css','plugins/xehub_ui/assets/css/dist.css',]
)->load() }}

{{-- 위젯박스 --}}
{{-- <div>
    {{ uio('widgetbox',['id' => "scics_community_index_top", 'link'=> xe_trans('xe::edit')]) }}
</div> --}}

<div class="xf-board-body">
    <div class="xe-flex xe-flex-col xe-gap-y-[6px] md:xe-gap-y-[20px] xe-items-center">
        {{-- <span class="xe-text-[16px]  xe-text-[#5386DA] xe-font-[400] xe-tracking-[-0.0174em]">
            KICS Prep School Academy
        </span> --}}
        <span class="xe-text-[24px] md:xe-text-[38px] xe-text-[#141414] xe-font-[700] xe-tracking-[-0.04em]">
            Admission FAQ
        </span>
    </div>
    <div class="faq-notice-fix-list-area faq-list-border xe-pt-[55px] xe-border-b-[1.5px] xe-border-[#141414]">
        <h2 class="xe-pb-[24px] xe-text-[#5386DA] xe-text-[22px] xe-font-[700] xe-tracking-[-1.2px] md:xe-text-[24px]">
            Admission FAQ
        </h2>
    </div>
    <ul class="xf-faq-list-top-10 base-list">
        @foreach ($paginate as $key => $item)
            <li class="xf-faq-item xe-border-b xe-border-[#ececec] xe-relative">
                <div class="xf-question-item xe-py-[14px]">
                    <div class="xf-question-item-text ellipsis1 flex flex-align-center"><span class="xf-faq-number xe-mr-[15px] sm:xe-mx-[15px] xe-italic xe-font-[800]">{{$key+1}} </span><span class="xe-mr-[15px]">{{ $item->title }}</span></div>
                    <div class="xf-question-item-arrow xf-question-arrow"></div>
                </div>
                <div class="xf-answer-item xe-py-[30px] xe-px-[50px] xe-bg-[#F7F7F8]">
                    {!! $item->content !!}
                    @if($isManager === true || $item->user_id === Auth::user()->getId() || $item->user_type === $item::USER_TYPE_GUEST)
                        <br><br>
                        <form action="{{ $urlHandler->get('destroy', array_merge(Request::all(), ['id' => $item->id])) }}" method="POST">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}

                            <div class="xf-edit-btn-box">
                                <span class="xe-list-board-body__edit-item xe-list-board-body__edit">
                                    <a href="{{ $urlHandler->get('edit', array_merge(Request::all(), ['id' => $item->id])) }}" class="xe-list-board-body__link">{{ xe_trans('xe::update') }}</a>
                                </span>
                                <span class="xe-list-board-body__edit-item xe-list-board-body__delete">
                                    <button type="submit" href="#" class="xe-list-board-body__link">{{ xe_trans('xe::delete') }}</button>
                                </span>
                            </div>
                        </form>
                    @endif
                </div>
            </li>
        @endforeach

        @if ($paginate->total() === 0)
            <li>
                <div class="xe-list-webzine-board__no-result">
                    <span class="xe-list-webzine-board__text">등록된 게시물이 없습니다.</span>
                </div>
            </li>
        @endif

    </ul>

    {{-- @section('content')
        {!! isset($content) ? $content : '' !!}
    @show --}}
    <div class="xf-board-pagination-box xf-mt32 xf-mb40">
        {!! $paginate->render($_skin::view('default-pagination')) !!}
    </div>
    @if (request()->segment(2) === null)
    <div class="xf-board-footer">
        <div class="xf-footer-board-btn-box flex gap-10">
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
    </div>
@endif
</div>
<script>
    $(document).ready(function () {
        $(".xf-answer-item").hide();
        $('.xf-question-item').on('click', function () {
            var element = $(this).closest('li');
            if (element.hasClass('open')) {
                element.removeClass('open');
                $('.xf-question-item-arrow').removeClass('xf-question-active');
                $('.xf-question-item-arrow').addClass('xf-question-arrow');
                element.find('li').removeClass('open');
                element.find('.xf-answer-item').slideUp();
            } else {
                element.addClass('open');
                element.find('.xf-answer-item').slideDown();
                element.siblings('li').children('.xf-answer-item').slideUp();
                element.siblings('li').removeClass('open');
                $('.xf-question-item-arrow').removeClass('xf-question-arrow');
                $('.xf-question-item-arrow').addClass('xf-question-arrow-active');
            }
        });
    });
</script>
