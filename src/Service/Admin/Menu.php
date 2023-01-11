<?php

namespace Be\App\Tool\Service\Admin;

use Be\App\ServiceException;
use Be\Be;
use Be\Util\Annotation;

class Menu
{

    /**
     * 重置菜单
     */
    public function init()
    {
        $toolMenus = [];
        $appProperty = Be::getProperty('App.Tool');
        $controllerDir = $appProperty->getPath() . '/Controller';
        $controllerNames = scandir($controllerDir);
        foreach ($controllerNames as $controllerName) {
            if ($controllerName === '.' || $controllerName === '..' || is_dir($controllerName . '/' . $controllerName)) continue;

            $controllerName = substr($controllerName, 0, -4);

            if ($controllerName === 'Home') continue;

            $className = '\\Be\\App\\Tool\\Controller\\' . $controllerName;
            if (!class_exists($className)) continue;

            $reflection = new \ReflectionClass($className);
            $methods = $reflection->getMethods(\ReflectionMethod::IS_PUBLIC);
            foreach ($methods as $method) {
                $methodName = $method->getName();
                $methodComment = $method->getDocComment();
                $methodComments = Annotation::parse($methodComment);
                $item = [];
                foreach ($methodComments as $key => $val) {
                    if ($key === 'BeMenu') {
                        if (is_array($val[0])) {
                            if (!isset($val[0]['label']) && isset($val[0]['value'])) {
                                $val[0]['label'] = $val[0]['value'];
                            }

                            if (isset($val[0]['label'])) {
                                $item = $val[0];
                            }
                        }
                    }
                }

                if (!$item) {
                    continue;
                }

                $toolMenus[] = [
                    'label' => $item['label'],
                    'route' => 'Tool.' . $controllerName . '.' . $methodName,
                    'ordering' => $item['ordering'] ?? 0,
                ];
            }
        }

        if (count($toolMenus) > 0) {
            $orderings = array_column($toolMenus, 'ordering');
            array_multisort($toolMenus, SORT_ASC, SORT_NUMERIC, $orderings);
        }

        $this->delete();

        $now = date('Y-m-d H:i:s');
        $tupleMenuItem = Be::getTuple('system_menu');
        $tupleMenuItem->name = 'Tool';
        $tupleMenuItem->label = '工具菜单';
        $tupleMenuItem->is_system = 0;
        $tupleMenuItem->create_time = $now;
        $tupleMenuItem->update_time = $now;
        $tupleMenuItem->insert();

        foreach ($toolMenus as $toolMenu) {
            $tupleMenuItem = Be::getTuple('system_menu_item');
            $tupleMenuItem->parent_id = '';
            $tupleMenuItem->menu_name = 'Tool';
            $tupleMenuItem->name = $toolMenu['label'];
            $tupleMenuItem->route = $toolMenu['route'];
            $tupleMenuItem->params = '[]';
            $tupleMenuItem->url = '';
            $tupleMenuItem->description = '工具：' . $toolMenu['label'];
            $tupleMenuItem->target = '_self';
            $tupleMenuItem->is_enable = 1;
            $tupleMenuItem->ordering = $toolMenu['ordering'];
            $tupleMenuItem->create_time = $now;
            $tupleMenuItem->update_time = $now;
            $tupleMenuItem->insert();
        }
    }


    /**
     * 保存菜单项
     *
     * @param string $menuId 菜单ID
     * @param array $formData 菜单项数据
     * @return bool
     * @throws \Throwable
     */
    public function saveItems($menuId, $formData)
    {
        $menu = $this->getMenuById($menuId);
        if (!$menu) {
            throw new ServiceException('菜单（#' . $menuId . '）不存在！');
        }

        $menuItems = $formData['menuItems'];

        $db = Be::getDb();
        $db->startTransaction();
        try {

            $keepIds = [];
            foreach ($menuItems as $menuItem) {
                if (!isset($menuItem['id'])) {
                    throw new ServiceException('菜单项参数（id）缺失！');
                }

                if (substr($menuItem['id'], 0, 1) !== '-') {
                    $keepIds[] = $menuItem['id'];
                }
            }

            if (count($keepIds) > 0) {
                Be::getTable('system_menu_item')
                    ->where('menu_name', $menu->name)
                    ->where('id', 'NOT IN', $keepIds)
                    ->delete();
            } else {
                Be::getTable('system_menu_item')
                    ->where('menu_name', $menu->name)
                    ->delete();
            }

            $now = date('Y-m-d H:i:s');

            $parentIds = [];
            $ordering = 0;
            foreach ($menuItems as $menuItem) {
                $isNew = false;
                if (substr($menuItem['id'], 0, 1) === '-') {
                    $isNew = true;
                }

                $tupleMenuItem = Be::getTuple('system_menu_item');

                if (!$isNew) {
                    try {
                        $tupleMenuItem->load($menuItem['id']);
                    } catch (\Throwable $t) {
                        throw new ServiceException('菜单（' . $menu->name . '）下的菜单项（# ' . $menuItem['id'] . '）不存在！');
                    }
                }

                $tupleMenuItem->menu_name = $menu->name;

                $parentId = $menuItem['parent_id'] ?? '';
                $name = $menuItem['name'] ?? '';
                $route = $menuItem['route'] ?? '';
                $params = $menuItem['params'] ?? [];
                $url = $menuItem['url'] ?? '';
                $description = $menuItem['description'] ?? '';
                $target = $menuItem['target'] ?? '';
                $isEnable = $menuItem['is_enable'] ?? 1;

                if (substr($parentId, 0, 1) === '-') {
                    $parentId = $parentIds[$parentId];
                }

                if (!$name) {
                    throw new ServiceException('请填写第' . ($ordering + 1) . '个菜单项的名称！');
                }

                $params = json_encode($params);

                if (!in_array($target, ['_self', '_blank'])) {
                    $target = '_self';
                }

                if (!in_array($isEnable, [0, 1])) {
                    $isEnable = 1;
                }

                $tupleMenuItem->parent_id = $parentId;
                $tupleMenuItem->name = $name;
                $tupleMenuItem->route = $route;
                $tupleMenuItem->params = $params;
                $tupleMenuItem->url = $url;
                $tupleMenuItem->description = $description;
                $tupleMenuItem->target = $target;
                $tupleMenuItem->is_enable = $isEnable;

                $tupleMenuItem->ordering = $ordering;

                if (!$isNew) {
                    $tupleMenuItem->create_time = $now;
                }

                $tupleMenuItem->update_time = $now;
                $tupleMenuItem->save();

                if ($isNew) {
                    $parentIds[$menuItem['id']] = $tupleMenuItem->id;
                }

                $ordering++;
            }

            $db->commit();

            $this->update($menu->name);

        } catch (\Throwable $t) {
            $db->rollback();
            Be::getLog()->error($t);

            throw new ServiceException('保存菜单项异常！');
        }

        return true;
    }

    /**
     * 删除菜单
     */
    public function delete()
    {
        $db = Be::getDb();
        $sql = 'SELECT * FROM system_menu WHERE name=\'Tool\'';
        $menu = $db->getObject($sql);
        if ($menu) {
            $sql = 'DELETE FROM system_menu_item WHERE menu_name=\'Tool\'';
            $db->query($sql);

            $sql = 'DELETE FROM system_menu WHERE name=\'Tool\'';
            $db->query($sql);

            $runtime = Be::getRuntime();
            $path = $runtime->getRootPath() . '/data/Runtime/Menu/Tool.php';
            if (file_exists($path)) {
                @unlink($path);
            }
        }
    }

}
