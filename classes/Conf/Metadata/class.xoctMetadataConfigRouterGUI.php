<?php

declare(strict_types=1);

use srag\Plugins\Opencast\DI\OpencastDIC;

/**
 * @ilCtrl_IsCalledBy xoctMetadataConfigRouterGUI : xoctMainGUI
 */
class xoctMetadataConfigRouterGUI
{
    public const SUBTAB_EVENTS = 'events';
    public const SUBTAB_SERIES = 'series';
    /**
     * @var \ilCtrl
     */
    private $ctrl;
    /**
     * @var \ilTabsGUI
     */
    private $tabs;
    /**
     * @var OpencastDIC
     */
    private $container;
    /**
     * @var ilOpenCastPlugin
     */
    private $plugin;

    public function __construct()
    {
        global $DIC;
        $this->ctrl = $DIC->ctrl();
        $this->tabs = $DIC->tabs();
        $this->container = OpencastDIC::getInstance();
        $this->plugin = $this->container->plugin();
    }

    public function executeCommand(): void
    {
        global $DIC;
        $nextClass = $this->ctrl->getNextClass();

        $opencast_dic = OpencastDIC::getInstance();
        switch ($nextClass) {
            case strtolower(xoctSeriesMetadataConfigGUI::class):
                $this->setSubTabs(self::SUBTAB_SERIES);
                $gui = new xoctSeriesMetadataConfigGUI(
                    $opencast_dic->metadata()->confRepositorySeries(),
                    $opencast_dic->metadata()->catalogueFactory(),
                    $DIC
                );
                $this->ctrl->forwardCommand($gui);
                break;
            case strtolower(xoctEventMetadataConfigGUI::class):
            default:
                $this->setSubTabs(self::SUBTAB_EVENTS);
                $gui = new xoctEventMetadataConfigGUI(
                    $opencast_dic->metadata()->confRepositoryEvent(),
                    $opencast_dic->metadata()->catalogueFactory(),
                    $DIC
                );
                $this->ctrl->forwardCommand($gui);
                break;
        }
    }

    private function setSubTabs(string $active_subtab): void
    {
        $this->tabs->addSubTab(
            self::SUBTAB_EVENTS,
            $this->plugin->txt('subtab_' . self::SUBTAB_EVENTS),
            $this->ctrl->getLinkTargetByClass(xoctEventMetadataConfigGUI::class)
        );
        $this->tabs->addSubTab(
            self::SUBTAB_SERIES,
            $this->plugin->txt('subtab_' . self::SUBTAB_SERIES),
            $this->ctrl->getLinkTargetByClass(xoctSeriesMetadataConfigGUI::class)
        );
        $this->tabs->activateSubTab($active_subtab);
    }
}
