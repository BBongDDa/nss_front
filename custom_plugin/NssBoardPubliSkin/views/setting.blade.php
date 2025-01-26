<div class="row">
    <div class="col-sm-12">
        <div class="panel">
            <div class="panel-heading">
                <h4 class="panel-title">목록 설정</h4>
            </div>

            <div class="panel-body">
                <div class="form-group">
                    <label>내가 쓴 글<small> 내가 쓴 글만 모아서 볼 수 있습니다.</small></label>
                    <select class="form-control" name="visibleIndexMyBoard">
                        <option value="show" @if (array_get($config, 'visibleIndexMyBoard', 'show') === 'show') selected @endif>표시</option>
                        <option value="hidden" @if (array_get($config, 'visibleIndexMyBoard', 'show') === 'hidden') selected @endif>표시안함</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>게시판 설명</label>
                    <input type="text" class="form-control" name="board-description" value="{{ array_get($config, 'board-description', '') }}">
                </div>

                <div class="form-group">
                    <label>내가 쓴 글<small> 내가 쓴 글만 모아서 볼 수 있습니다.</small></label>
                    <select class="form-control" name="visibleIndexMyBoard">
                        <option value="show" @if (array_get($config, 'visibleIndexMyBoard', 'show') === 'show') selected @endif>표시</option>
                        <option value="hidden" @if (array_get($config, 'visibleIndexMyBoard', 'show') === 'hidden') selected @endif>표시안함</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>글쓰기 버튼<small> 게시물을 작성할 수 있는 버튼입니다.</small></label>
                    <select class="form-control" name="visibleIndexWriteButton">
                        <option value="always" @if (array_get($config, 'visibleIndexWriteButton', 'always') === 'always') selected @endif>항상표시</option>
                        <option value="permission" @if (array_get($config, 'visibleIndexWriteButton', 'always') === 'permission') selected @endif>권한별로 표시</option>
                        <option value="hidden" @if (array_get($config, 'visibleIndexWriteButton', 'always') === 'hidden') selected @endif>표시안함</option>
                    </select>
                </div>
            </div>
        </div>

        @if (isset($config['categories']) === true)
            <div class="panel">
                <div class="panel-heading">
                    <h4 class="panel-title">카테고리 설정</h4>
                </div>

                <div class="panel-body">
                    <div class="form-group">
                        <label>카테고리 구분 전체 출력 여부</label>
                        <select name="visibleAllCategory" class="form-control">
                            <option value="visible" @if (array_get($config, 'visibleAllCategory', 'visible') === 'visible') selected @endif>출력</option>
                            <option value="hidden" @if (array_get($config, 'visibleAllCategory', 'visible') === 'hidden') selected @endif>숨김</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>카테고리별 출력 형식 설정</label>
                        @foreach ($config['categories'] as $categoryId => $categoryName)
                            <div>
                                <label>{{ $categoryName }}</label>
                                <select name="{{ 'index-type-' . $categoryId }}" class="form-control">
                                    <option value="default" @if (array_get($config, 'index-type-' . $categoryId, 'default') === 'default') selected @endif>기본</option>
                                    <option value="webzine" @if (array_get($config, 'index-type-' . $categoryId, 'default') === 'webzine') selected @endif>웹진형</option>
                                    <option value="gallery-3" @if (array_get($config, 'index-type-' . $categoryId, 'default') === 'gallery-3') selected @endif>3칸 갤러리</option>
                                    <option value="gallery-4" @if (array_get($config, 'index-type-' . $categoryId, 'default') === 'gallery-4') selected @endif>4칸 갤러리</option>
                                </select>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

<style>
    .panel { box-shadow: none; }
    .panel .panel-heading { padding: 0; }
    .row:first-child .panel .panel-body { padding: 0; }
    .checkbox { margin-bottom: 0; }
    .panel .panel-heading .panel-title { font-size: 18px; }

    @media (min-width: 768px) {
        .xe-modal-dialog {
            width: 760px;
        }
    }
</style>
