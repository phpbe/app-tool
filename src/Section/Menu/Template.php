<?php

namespace Be\App\Tool\Section\Menu;

use Be\Be;
use Be\Theme\Section;

class Template extends Section
{

    public array $positions = ['middle', 'center'];


    public function display()
    {
        if ($this->config->enable === 0) {
            return;
        }

        $this->css();

        echo '<div class="tool-menu">';
        if ($this->position === 'middle' && $this->config->width === 'default') {
            echo '<div class="be-container">';
        }

        $toolMenu = Be::getMenu('Tool');
        $toolMenuTree = $toolMenu->getTree();
        $toolMenu->updateActiveItems();

        echo '<ul class="tool-menu-lv1">';
        foreach ($toolMenuTree as $item) {
            echo '<li class="tool-menu-lv1-item';
            if ($item->active === 1) {
                echo ' tool-menu-lv1-item-active';
            }
            echo '">';

            $url = 'javascript:void(0);';
            if ($item->route) {
                if ($item->params) {
                    $url = beUrl($item->route, $item->params);
                } else {
                    $url = beUrl($item->route);
                }
            } else {
                if ($item->url) {
                    $url = $item->url;
                }
            }
            echo '<a class="tool-menu-lv1-item-link" href="' . $url . '"';
            if ($item->target === '_blank') {
                echo ' target="_blank"';
            }
            echo '>' . $item->label . '</a>';
            echo '</li>';
        }
        echo '</ul>';

        foreach ($toolMenuTree as $item) {
            $hasSubItem = false;
            if (isset($item->subItems) && is_array($item->subItems) && count($item->subItems) > 0) {
                $hasSubItem = true;
            }

            if ($hasSubItem) {
                echo '<ul class="tool-menu-lv2';
                if ($item->active === 1) {
                    echo ' tool-menu-lv2-active';
                }
                echo '">';

                foreach ($item->subItems as $subItem) {

                    $url = 'javascript:void(0);';
                    if ($subItem->route) {
                        if ($subItem->params) {
                            $url = beUrl($subItem->route, $subItem->params);
                        } else {
                            $url = beUrl($subItem->route);
                        }
                    } else {
                        if ($subItem->url) {
                            $url = $subItem->url;
                        }
                    }

                    echo '<li class="tool-menu-lv2-item';
                    if ($subItem->active === 1) {
                        echo ' tool-menu-lv2-item-active';
                    }
                    echo '">';

                    echo '<a class="tool-menu-lv2-item-link" href="' . $url . '"';
                    if ($subItem->target === '_blank') {
                        echo ' target="_blank"';
                    }
                    echo '>' . $subItem->label . '</a>';
                    echo '</li>';
                }
                echo '</ul>';
            }
        }


        foreach ($toolMenuTree as $item) {
            $hasSubItem = false;
            if (isset($item->subItems) && is_array($item->subItems) && count($item->subItems) > 0) {
                $hasSubItem = true;
            }

            if ($hasSubItem) {
                foreach ($item->subItems as $subItem) {
                    $hasSubSubItem = false;
                    if (isset($subItem->subItems) && is_array($subItem->subItems) && count($subItem->subItems) > 0) {
                        $hasSubSubItem = true;
                    }

                    if ($hasSubSubItem) {
                        echo '<ul class="tool-menu-lv3';
                        if ($subItem->active === 1) {
                            echo ' tool-menu-lv3-active';
                        }
                        echo '">';

                        foreach ($subItem->subItems as $subSubItem) {
                            $url = 'javascript:void(0);';
                            if ($subSubItem->route) {
                                if ($subItem->params) {
                                    $url = beUrl($subSubItem->route, $subSubItem->params);
                                } else {
                                    $url = beUrl($subSubItem->route);
                                }
                            } else {
                                if ($subSubItem->url) {
                                    $url = $subSubItem->url;
                                }
                            }

                            echo '<li class="tool-menu-lv3-item';
                            if ($subSubItem->active === 1) {
                                echo ' tool-menu-lv3-item-active';
                            }
                            echo '">';

                            echo '<a class="tool-menu-lv3-item-link" href="' . $url . '"';
                            if ($subSubItem->target === '_blank') {
                                echo ' target="_blank"';
                            }
                            echo '>' . $subSubItem->label . '</a>';
                            echo '</li>';
                        }
                        echo '</ul>';
                    }
                }
            }
        }

        if ($this->position === 'middle' && $this->config->width === 'default') {
            echo '</div>';
        }
        echo '</div>';
    }


    private function css()
    {
        echo '<style type="text/css">';
        echo $this->getCssPadding('tool-menu');
        echo $this->getCssMargin('tool-menu');
        echo $this->getCssBackgroundColor('tool-menu');

        if (isset($this->config->backgroundColor) && $this->config->backgroundColor) {
            if ($this->page->pageConfig->north === 0) {
                echo 'html {';
                echo 'background-color:' . $this->config->backgroundColor . ';';
                echo '}';
            }
        }

        echo '#' . $this->id . ' .tool-menu {';
        echo '}';

        echo '#' . $this->id . ' .tool-menu-lv1,';
        echo '#' . $this->id . ' .tool-menu-lv2,';
        echo '#' . $this->id . ' .tool-menu-lv3 {';
        echo 'margin: 0;';
        echo 'padding: 0;';
        echo 'border-bottom: #eee 1px solid;';
        echo '}';

        echo '#' . $this->id . ' .tool-menu-lv2,';
        echo '#' . $this->id . ' .tool-menu-lv3 {';
        echo 'display: none;';
        echo 'margin-top: .25rem;';
        echo 'padding-top: .25rem;';
        echo '}';

        echo '#' . $this->id . ' .tool-menu-lv2-active,';
        echo '#' . $this->id . ' .tool-menu-lv3-active {';
        echo 'display: block;';
        echo '}';

        echo '#' . $this->id . ' .tool-menu-lv1-item,';
        echo '#' . $this->id . ' .tool-menu-lv2-item,';
        echo '#' . $this->id . ' .tool-menu-lv3-item {';
        echo 'list-style: none;';
        echo 'display: inline-block;';
        echo 'padding: .5rem .75rem;';
        echo '}';

        echo '#' . $this->id . ' .tool-menu-lv1-item-active a,';
        echo '#' . $this->id . ' .tool-menu-lv2-item-active a,';
        echo '#' . $this->id . ' .tool-menu-lv3-item-active a {';
        echo 'color: var(--major-color);';
        echo '}';

        echo '#' . $this->id . ' .tool-menu-lv1-item-link,';
        echo '#' . $this->id . ' .tool-menu-lv2-item-link,';
        echo '#' . $this->id . ' .tool-menu-lv3-item-link {';
        echo 'display: inline-block;';
        echo '}';

        echo '</style>';
    }

}

