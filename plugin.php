<?php

namespace XEHub\XePlugin\CustomPlugin;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Route;
use Xpressengine\Editor\EditorHandler;
use Xpressengine\Plugin\AbstractPlugin;
use Xpressengine\Translation\Translator;
use XEHub\XePlugin\CustomPlugin\Bootstrappers\Bootstrapper;

/**
 * Class Plugin
 *
 * 커스텀 플러그인
 *
 * @package XEHub\XePlugin\CustomPlugin
 */
class Plugin extends AbstractPlugin
{
    /**
     * @var Migrations\MigrationResource
     */
    protected $migrationResource;

    /**
     * @var Translator
     */
    protected $translator;

    /**
     * @var array
     */
    protected $bootstrappers = [
        Bootstrappers\ConfigurationBootstrapper::class,
        Bootstrappers\CommandBootstrapper::class
    ];

    /**
     * @return void
     */
    public function __construct()
    {
        $this->migrationResource = app(Migrations\MigrationResource::class);
        $this->translator = app(Translator::class);
        $this->bootstrappers = collect($this->bootstrappers);

        parent::__construct();
    }

    /**
     * @return void
     */
    public function boot()
    {
        $this->registerRoutes();
        $this->bootBootstrappers();
        $this->registerBackofficeSettingMenus();
        $this->registerPluginBootedEvents();
    }

    /**
     * @return void
     */
    public function install()
    {
        // put langs
        $this->translator->putFromLangDataSource(
            static::getId(),
            static::path('langs/lang.php')
        );

        if ($this->migrationResource->checkInstalled() === false) {
            $this->migrationResource->install();
        }

        parent::install();
    }

    /**
     * @return bool
     */
    public function checkInstalled()
    {
        if ($this->migrationResource->checkInstalled() === false) {
            return false;
        }

        return parent::checkInstalled();
    }

    /**
     * @return void
     */
    public function update()
    {
        if ($this->migrationResource->checkUpdated() === false) {
            $this->migrationResource->update();
        }

        // put langs
        $this->translator->putFromLangDataSource(
            static::getId(),
            static::path('langs/lang.php')
        );

        parent::update();
    }

    /**
     * @return bool
     */
    public function checkUpdated()
    {
        return parent::checkUpdated();
    }

    /**
     * @return void
     */
    protected function registerRoutes()
    {
        Route::middleware('web')->group(static::path('routes/common.php'));
    }

    /**
     * @return void
     */
    protected function bootBootstrappers()
    {
        $this->bootstrappers->each(
            function (string $bootstrapperClass) {
                $bootstrapper = app($bootstrapperClass);

                if ($bootstrapper instanceof Bootstrapper) {
                    $bootstrapper->boot();
                }
            }
        );
    }

    /**
     * 관리자메뉴 설정
     * @return void
     */
    protected function registerBackofficeSettingMenus()
    {
        // [SAMPLE]
        /* \XeRegister::push('settings/menu', 'custom_plugin::backoffice', [
            'title' => '[SAMPLE] 커스텀 플러그인',
            'description' => '[SAMPLE] 커스텀 플러그인 메뉴',
            'display' => true,
            'ordering' => 2000
        ]);

        \XeRegister::push('settings/menu', 'custom_plugin::backoffice.sample', [
            'title' => '[SAMPLE] 커스텀 플러그인 관리',
            'description' => '[SAMPLE] 커스텀 플러그인 관리 메뉴',
            'display' => true,
            'ordering' => 2100,
            'link' => route('custom_plugin::backoffice.sample')
        ]); */
    }

    /**
     * 모든 플러그인이 부트가 완료되었을때의 이벤트를 등록
     * @return void
     */
    protected function registerPluginBootedEvents()
    {
        Event::listen('booted.plugins', function ($pluginHandler) {
            // add events
        });
    }
}
