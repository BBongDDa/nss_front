<?php
namespace XEHub\XePlugin\CustomPlugin\Skins\NssBoardPubliSkin;

use Xpressengine\Permission\Instance;
use Xpressengine\Plugins\Board\BoardPermissionHandler;
use Xpressengine\Plugins\Board\GenericBoardSkin;

class NssBoardPubliSkin extends GenericBoardSkin
{
    protected static $path = 'custom_plugin/src/Skins/NssBoardPubliSkin';

    public function render()
    {
        $this->data['isManager'] = $this->isManager();

//        \XeFrontend::css(self::asset('css/board-style.css'))->load();

        return parent::render();
    }

    /**
     * @return bool
     */
    protected function isManager()
    {
        $boardPermission = app('xe.board.permission');
        return isset($this->data['instanceId']) && \Gate::allows(
                BoardPermissionHandler::ACTION_MANAGE,
                new Instance($boardPermission->name($this->data['instanceId']))
            );
    }
}

