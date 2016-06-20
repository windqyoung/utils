<?php


namespace Windqyoung\Utils\Tests;




use Windqyoung\Utils\PixelAdmin\MenuGenerator;

class MenuGeneratorTest extends \PHPUnit_Framework_TestCase
{
    public function testMenuData()
    {
        $menus =
array (
  0 =>
  array (
    'name' => '菜单17',
    'icon' => 'fa-legal',
    'children' =>
    array (
      0 =>
      array (
        'name' => '菜单20',
        'icon' => '',
        'url' => 'http://exp.com/20',
      ),
      1 =>
      array (
        'name' => '菜单21',
        'icon' => '',
        'url' => 'http://exp.com/21',
      ),
      2 =>
      array (
        'name' => '菜单22',
        'icon' => '',
        'url' => 'http://exp.com/22',
      ),
      3 =>
      array (
        'name' => '菜单23',
        'icon' => '',
        'url' => 'http://exp.com/23',
      ),
      4 =>
      array (
        'name' => '菜单25',
        'icon' => '',
        'url' => 'http://exp.com/27',
        'children' =>
        array (
        ),
      ),
    ),
  ),
  1 =>
  array (
    'name' => '菜单34',
    'icon' => 'fa-calendar-o',
    'children' =>
    array (
      0 =>
      array (
        'name' => '菜单37',
        'icon' => '',
        'url' => 'http://exp.com/37',
      ),
      1 =>
      array (
        'name' => '菜单39',
        'icon' => '',
        'url' => 'http://exp.com/40',
        'children' =>
        array (
          0 =>
          array (
            'name' => '菜单42',
            'icon' => '',
            'url' => 'http://exp.com/42',
          ),
          1 =>
          array (
            'name' => '菜单43',
            'icon' => '',
            'url' => 'http://exp.com/43',
          ),
          2 =>
          array (
            'name' => '菜单44',
            'icon' => '',
            'url' => 'http://exp.com/44',
          ),
        ),
      ),
      2 =>
      array (
        'name' => '菜单47',
        'icon' => '',
        'url' => 'http://exp.com/47',
      ),
    ),
  ),
  2 =>
  array (
    'name' => '菜单50',
    'icon' => 'fa-list-ul',
    'url' => 'http://exp.com/50',
  ),
  3 =>
  array (
    'name' => '菜单51',
    'icon' => 'fa-user',
    'url' => 'http://exp.com/51',
  ),
  4 =>
  array (
    'name' => '菜单52',
    'icon' => 'fa-female',
    'url' => 'http://exp.com/52',
  ),
  5 =>
  array (
    'name' => '菜单53',
    'icon' => 'fa-users',
    'url' => 'http://exp.com/53',
  ),
  6 =>
  array (
    'name' => '菜单55',
    'icon' => 'fa-tasks',
    'children' =>
    array (
      0 =>
      array (
        'name' => '菜单58',
        'icon' => 'fa-shopping-cart',
        'url' => 'http://exp.com/58',
      ),
      1 =>
      array (
        'name' => '菜单59',
        'icon' => 'fa-check-circle',
        'url' => 'http://exp.com/59',
      ),
    ),
  ),
  7 =>
  array (
    'name' => '菜单62',
    'icon' => 'fa-truck',
    'url' => 'http://exp.com/62',
  ),
  8 =>
  array (
    'name' => '菜单64',
    'icon' => 'fa-refresh',
    'children' =>
    array (
      0 =>
      array (
        'name' => '菜单67',
        'icon' => 'fa-picture-o',
        'url' => 'http://exp.com/67',
      ),
      1 =>
      array (
        'name' => '菜单68',
        'icon' => 'fa-shopping-cart',
        'url' => 'http://exp.com/68',
      ),
    ),
  ),
  9 =>
  array (
    'name' => '菜单72',
    'icon' => 'fa-ticket',
    'children' =>
    array (
      0 =>
      array (
        'name' => '菜单75',
        'icon' => 'fa-list-ul',
        'url' => 'http://exp.com/75',
      ),
      1 =>
      array (
        'name' => '菜单76',
        'icon' => 'fa-star-o',
        'url' => 'http://exp.com/76',
      ),
      2 =>
      array (
        'name' => '菜单77',
        'icon' => 'fa-star-o',
        'url' => 'http://exp.com/77',
      ),
    ),
  ),
  10 =>
  array (
    'name' => '菜单80',
    'icon' => 'fa-cny',
    'url' => 'http://exp.com/80',
  ),
  11 =>
  array (
    'name' => '菜单81',
    'icon' => 'fa-dollar',
    'url' => 'http://exp.com/81',
  ),
  12 =>
  array (
    'name' => '菜单83',
    'icon' => 'fa-book',
    'children' =>
    array (
      0 =>
      array (
        'name' => '菜单86',
        'icon' => 'fa-list-ul',
        'url' => 'http://exp.com/86',
      ),
      1 =>
      array (
        'name' => '菜单87',
        'icon' => 'fa-edit',
        'url' => 'http://exp.com/87',
      ),
    ),
  ),
);


        $menu = new MenuGenerator($menus);


        $rs = <<<'EOF'
<ul class="navigation">
    <li class="mm-dropdown">
        <a href="#"><i class="menu-icon fa fa-legal"></i><span class="mm-text">菜单17</span></a>
        <ul>
            <li><a tabindex="-1" href="http://exp.com/20"><i class="menu-icon fa "></i><span class="mm-text">菜单20</span></a></li>
            <li><a tabindex="-1" href="http://exp.com/21"><i class="menu-icon fa "></i><span class="mm-text">菜单21</span></a></li>
            <li><a tabindex="-1" href="http://exp.com/22"><i class="menu-icon fa "></i><span class="mm-text">菜单22</span></a></li>
            <li><a tabindex="-1" href="http://exp.com/23"><i class="menu-icon fa "></i><span class="mm-text">菜单23</span></a></li>
            <li><a tabindex="-1" href="http://exp.com/27"><i class="menu-icon fa "></i><span class="mm-text">菜单25</span></a></li>

       </ul>
    </li>
    <li class="mm-dropdown">
        <a href="#"><i class="menu-icon fa fa-calendar-o"></i><span class="mm-text">菜单34</span></a>
        <ul>
            <li><a tabindex="-1" href="http://exp.com/37"><i class="menu-icon fa "></i><span class="mm-text">菜单37</span></a></li>
            <li class="mm-dropdown">
                <a href="#"><i class="menu-icon fa "></i><span class="mm-text">菜单39</span></a>
                <ul>
                    <li><a tabindex="-1" href="http://exp.com/42"><i class="menu-icon fa "></i><span class="mm-text">菜单42</span></a></li>
                    <li><a tabindex="-1" href="http://exp.com/43"><i class="menu-icon fa "></i><span class="mm-text">菜单43</span></a></li>
                    <li><a tabindex="-1" href="http://exp.com/44"><i class="menu-icon fa "></i><span class="mm-text">菜单44</span></a></li>

               </ul>
            </li>
            <li><a tabindex="-1" href="http://exp.com/47"><i class="menu-icon fa "></i><span class="mm-text">菜单47</span></a></li>

       </ul>
    </li>
    <li><a tabindex="-1" href="http://exp.com/50"><i class="menu-icon fa fa-list-ul"></i><span class="mm-text">菜单50</span></a></li>
    <li><a tabindex="-1" href="http://exp.com/51"><i class="menu-icon fa fa-user"></i><span class="mm-text">菜单51</span></a></li>
    <li><a tabindex="-1" href="http://exp.com/52"><i class="menu-icon fa fa-female"></i><span class="mm-text">菜单52</span></a></li>
    <li><a tabindex="-1" href="http://exp.com/53"><i class="menu-icon fa fa-users"></i><span class="mm-text">菜单53</span></a></li>
    <li class="mm-dropdown">
        <a href="#"><i class="menu-icon fa fa-tasks"></i><span class="mm-text">菜单55</span></a>
        <ul>
            <li><a tabindex="-1" href="http://exp.com/58"><i class="menu-icon fa fa-shopping-cart"></i><span class="mm-text">菜单58</span></a></li>
            <li><a tabindex="-1" href="http://exp.com/59"><i class="menu-icon fa fa-check-circle"></i><span class="mm-text">菜单59</span></a></li>

       </ul>
    </li>
    <li><a tabindex="-1" href="http://exp.com/62"><i class="menu-icon fa fa-truck"></i><span class="mm-text">菜单62</span></a></li>
    <li class="mm-dropdown">
        <a href="#"><i class="menu-icon fa fa-refresh"></i><span class="mm-text">菜单64</span></a>
        <ul>
            <li><a tabindex="-1" href="http://exp.com/67"><i class="menu-icon fa fa-picture-o"></i><span class="mm-text">菜单67</span></a></li>
            <li><a tabindex="-1" href="http://exp.com/68"><i class="menu-icon fa fa-shopping-cart"></i><span class="mm-text">菜单68</span></a></li>

       </ul>
    </li>
    <li class="mm-dropdown">
        <a href="#"><i class="menu-icon fa fa-ticket"></i><span class="mm-text">菜单72</span></a>
        <ul>
            <li><a tabindex="-1" href="http://exp.com/75"><i class="menu-icon fa fa-list-ul"></i><span class="mm-text">菜单75</span></a></li>
            <li><a tabindex="-1" href="http://exp.com/76"><i class="menu-icon fa fa-star-o"></i><span class="mm-text">菜单76</span></a></li>
            <li><a tabindex="-1" href="http://exp.com/77"><i class="menu-icon fa fa-star-o"></i><span class="mm-text">菜单77</span></a></li>

       </ul>
    </li>
    <li><a tabindex="-1" href="http://exp.com/80"><i class="menu-icon fa fa-cny"></i><span class="mm-text">菜单80</span></a></li>
    <li><a tabindex="-1" href="http://exp.com/81"><i class="menu-icon fa fa-dollar"></i><span class="mm-text">菜单81</span></a></li>
    <li class="mm-dropdown">
        <a href="#"><i class="menu-icon fa fa-book"></i><span class="mm-text">菜单83</span></a>
        <ul>
            <li><a tabindex="-1" href="http://exp.com/86"><i class="menu-icon fa fa-list-ul"></i><span class="mm-text">菜单86</span></a></li>
            <li><a tabindex="-1" href="http://exp.com/87"><i class="menu-icon fa fa-edit"></i><span class="mm-text">菜单87</span></a></li>

       </ul>
    </li>

</ul>
EOF;


        $this->assertEquals($menu->render(true), $rs);




    }
}
