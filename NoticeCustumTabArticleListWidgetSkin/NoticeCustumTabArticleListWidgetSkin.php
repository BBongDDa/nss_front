<?php

namespace XEHub\XePlugin\CustomPlugin\Skins\NoticeCustumTabArticleListWidgetSkin;

use Illuminate\Support\Arr;
use XEHub\XePlugin\CustomPlugin\Components\Skins\CustomTab\BasicCustomTab\BasicCustomTabSkin;
use Xpressengine\Media\Repositories\ImageRepository;
use Xpressengine\Plugins\Board\Models\Board;
use Xpressengine\Plugins\Board\Models\BoardGalleryThumb;
use Xpressengine\Plugins\Board\Components\Modules\BoardModule;
use Xpressengine\Skin\GenericSkin;
use View;

class NoticeCustumTabArticleListWidgetSkin extends GenericSkin
{
    /**
     * @var string
     */
    protected static $path = 'custom_plugin/src/Skins/NoticeCustumTabArticleListWidgetSkin';

    public function render()
    {
        $data = $this->data;
        $list = array_get($data, 'list');
        foreach ($list as $item) {
            $thumbItem = BoardGalleryThumb::find($item->id);
            if ($thumbItem !== null) {
                $item->board_thumbnail_file_id = $thumbItem->board_thumbnail_file_id;
                $item->board_thumbnail_external_path = $thumbItem->board_thumbnail_external_path;
                $item->board_thumbnail_path = $thumbItem->board_thumbnail_path;
            }
        }
        $this->attachThumbnail($list);

        // 커스텀 탭 설정
        if ($widgetConfig = Arr::get($this->data, 'widgetConfig')) {
            $tabId = ($tabId = Arr::get($widgetConfig, 'tab_id')) !== '' ? $tabId : null;
            $sectionId = $tabId && ($sectionId = Arr::get($widgetConfig, 'section_id')) !== '' ? $sectionId : null;

            if ($tabId !== null) {
                $this->data['sectionIdentifier'] = BasicCustomTabSkin::getSectionIdentifier($tabId);
                $this->data['sectionId'] = $sectionId;
            }
        }

        return parent::render();
    }

    /**
     * attach thumbnail for list
     *
     * @param array $list list of board model
     * @return void
     */
    public function attachThumbnail($list)
    {
        foreach ($list as $item) {
            $this->bindGalleryThumb($item);
        }
    }

    /**
     * bind gallery thumbnail
     *
     * @param Board $item board model
     * @return void
     */
    protected function bindGalleryThumb(Board $item)
    {
        /** @var \Xpressengine\Media\MediaManager $mediaManager */
        $mediaManager = app('xe.media');

        // board gallery thumbnails 에 항목이 없는 경우
        if ($item->board_thumbnail_file_id === null && $item->board_thumbnail_path === null) {
            // find file by document id
            $files = \XeStorage::fetchByFileable($item->id);
            $fileId = '';
            $externalPath = '';
            $thumbnailPath = '';

            if (count($files) == 0) {
                // find file by contents link or path
                $externalPath = $this->getImagePathFromContent($item->content);

                // make thumbnail
                $thumbnailPath = $externalPath;
            } else {
                foreach ($files as $file) {
                    if ($mediaManager->is($file) !== true) {
                        continue;
                    }

                    /**
                     * set thumbnail size
                     */
                    $dimension = 'L';

                    $imageRepository = new ImageRepository();
                    $media = $imageRepository->getThumbnail(
                        $mediaManager->make($file),
                        BoardModule::THUMBNAIL_TYPE,
                        $dimension
                    );

                    if ($media === null) {
                        continue;
                    }

                    $fileId = $file->id;
                    $thumbnailPath = $media->url();
                    break;
                }
            }

            $item->board_thumbnail_file_id = $fileId;
            $item->board_thumbnail_external_path = $externalPath;
            $item->board_thumbnail_path = $thumbnailPath;
        }

        // 없을 경우 출력될 디폴트 이미지 (스킨의 설정으로 뺄 수 있을것 같음)
        if ($item->board_thumbnail_path == '') {
            $item->board_thumbnail_path = asset('assets/core/common/img/default_image_1200x800.jpg');
        }
    }

    /**
     * get path from content image tag source
     *
     * @param string $content document content
     * @return string
     */
    protected function getImagePathFromContent($content)
    {
        $path = '';

        $pattern = '/<img[^>]*src="([^"]+)"[^>][^>]*>/';
        $matches = [];

        preg_match_all($pattern, $content, $matches);
        if (isset($matches[1][0])) {
            $path= $matches[1][0];
        }

        return $path;
    }
}
