<?php
namespace app\admin\controller;
use app\admin\model;
class Menu extends Base
{
    /**
     * Summary of $menu
     * @var app\admin\model\Menu
     */
    private $menu;
    public function _initialize()
    {
        parent::_initialize();
        $this->menu=model('Menu');
    }
    
    public function index()
    {
        $html='';
        $list = $this->menu->where(['id'=>200, 'pid'=>0,'hide'=>0])->order('sort')->select();
        foreach ($list as $li)
        {
        	$html.=$this->createMenu($li);
        }
        return $html;
    }
    
    private function createMenu($menu){
        $html='';
        if($menu && $menu->id>0){
            $listSubMenu=$this->menu->where(['pid'=>$menu->id])->order('sort')->select();
            if($listSubMenu){
                $html='<li>
                    <a href="'.url($menu->url).'" class="dropdown-toggle">
                        <i class="'.$menu->icon.'"></i>
                        <span class="menu-text">
                            '.$menu->name.'
                        </span>
                        <b class="arrow fa fa-angle-down"></b>
                    </a>
                    <b class="arrow"></b>
                    <ul class="submenu">
                    ';
                foreach ($listSubMenu as $subMenu)
                {
                	$html.=$this->createMenu($subMenu);
                }
                $html.='</ul></li>';
                
            }else{
                $html='<li>
                        <a href="'.url($menu->url).'">
                            <i class="'.$menu->icon.'"></i>
                            <span class="menu-text"> '.$menu->name.' </span>
                        </a>
                        <b class="arrow"></b>
                    </li>';
            }
        }
        return $html;
    }
    
    private function createSubMenu($menu){
        die;
        $html='';
        if($menu->id>0){
            $list = $this->menu->where(['pid'=>$menu->id,'hide'=>0])->select();
            $html='
                    <ul class="submenu">
                        <li class="">
                            <a href="#" class="dropdown-toggle">
                                <i class="menu-icon fa fa-caret-right"></i>

                                Layouts
                                <b class="arrow fa fa-angle-down"></b>
                            </a>

                            <b class="arrow"></b>

                            <ul class="submenu">
                                <li class="">
                                    <a href="top-menu.html">
                                        <i class="menu-icon fa fa-caret-right"></i>
                                        Top Menu
                                    </a>

                                    <b class="arrow"></b>
                                </li>

                                <li class="">
                                    <a href="two-menu-1.html">
                                        <i class="menu-icon fa fa-caret-right"></i>
                                        Two Menus 1
                                    </a>

                                    <b class="arrow"></b>
                                </li>
                            </ul>
                        </li>

                        <li class="">
                            <a href="#" class="dropdown-toggle">
                                <i class="menu-icon fa fa-caret-right"></i>

                                Three Level Menu
                                <b class="arrow fa fa-angle-down"></b>
                            </a>

                            <b class="arrow"></b>

                            <ul class="submenu">
                                <li class="">
                                    <a href="#">
                                        <i class="menu-icon fa fa-leaf green"></i>
                                        Item #1
                                    </a>

                                    <b class="arrow"></b>
                                </li>

                                <li class="">
                                    <a href="#" class="dropdown-toggle">
                                        <i class="menu-icon fa fa-pencil orange"></i>

                                        4th level
                                        <b class="arrow fa fa-angle-down"></b>
                                    </a>

                                    <b class="arrow"></b>

                                    <ul class="submenu">
                                        <li class="">
                                            <a href="#">
                                                <i class="menu-icon fa fa-plus purple"></i>
                                                Add Product
                                            </a>

                                            <b class="arrow"></b>
                                        </li>

                                        <li class="">
                                            <a href="#">
                                                <i class="menu-icon fa fa-eye pink"></i>
                                                View Products
                                            </a>

                                            <b class="arrow"></b>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    </ul>';
            
            
        }
        return $html;
    }
}
