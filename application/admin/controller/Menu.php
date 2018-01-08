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
        $list = $this->menu->where(['pid'=>0,'hide'=>0])->order('sort')->select();
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
                $html='<li id="menu_'.$menu->id.'">
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
                list($controller,$action)=explode('/',$menu->url,2);
                $html='<li id="'.$controller.'_'.$action.'" pmid="'.$menu->pid.'">
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
    
}
