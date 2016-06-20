<?php



namespace Windqyoung\Utils\PixelAdmin;

class MenuGenerator
{

    private $menus;

    public function __construct($menus)
    {
        $this->menus = $menus;
    }

    public function render($containUl = false)
    {
        $result = '';

        $menus = $this->getMenuData();
        foreach ($menus as $li)
        {
            $result .= $this->renderLi($li);
        }

        return $containUl ? "<ul class=\"navigation\">\n$result\n</ul>" : $result;
    }

    private function renderLi($li, $level = 1)
    {
        // 叶节点
        if (empty($li['children']))
        {
            return $this->renderLeaf($li, $level);
        } else
        {
            // 子节点, 下拉菜单
            return $this->renderDropdown($li, $level);
        }
    }

    /**
     *  <li class="mm-dropdown">
     *      <a href="#"><i class="menu-icon fa fa-legal"></i><span class="mm-text">主菜单</span></a>
     *      <ul>
     *          <li>
     *              <a tabindex="-1" href="url"><span class="mm-text">子菜单</span></a>
     *          </li>
     *      </ul>
     *  </li>
     * @param array $li
     */
    private function renderDropdown($li, $level = 1)
    {
        $childrenStr = '';
        foreach ($li['children'] as $childLi)
        {
            $childrenStr .= $this->renderLi($childLi, $level + 2);
        }

        // 无子节点, 那此节点也不显示
        if (empty($childrenStr))
        {
            return '';
        }
        $name = isset($li['name']) ? $li['name'] : '';
        $icon = isset($li['icon']) ? $li['icon'] : '';

        return sprintf(<<<EOF
%1\$s<li class="mm-dropdown">
%1\$s    <a href="#"><i class="menu-icon fa $icon"></i><span class="mm-text">$name</span></a>
%1\$s    <ul>
$childrenStr
%1\$s   </ul>
%1\$s</li>

EOF

            , str_repeat('    ', $level)
        );
    }

    /**
     * <li>
     *  <a tabindex="-1" href="url"><i class="menu-icon fa fa-list-ul"></i><span class="mm-text">菜单名</span></a>
     * </li>
     */
    private function renderLeaf($li, $level = 1)
    {
        $url = isset($li['url']) ? $li['url'] : '';

        // 无权限, 则返回空
        if (! $this->canShow($li))
        {
            return '';
        }

        $name = isset($li['name']) ? $li['name'] : '';
        $icon = isset($li['icon']) ? $li['icon'] : '';


        return sprintf(str_repeat('    ', $level) . '<li><a tabindex="-1" href="%s"><i class="menu-icon fa %s"></i><span class="mm-text">%s</span></a></li>' . "\n",
            $url, $icon, $name
        );
    }

    protected function canShow($arg)
    {
        return true;
    }

    private function getMenuData()
    {
        return $this->menus;
    }
}
