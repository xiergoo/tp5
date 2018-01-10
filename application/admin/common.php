<?php
/**
 * 加密密码
 * @param mixed $password 原密码
 * @param mixed $salt_len 盐长度，默认6位
 * @return mixed
 */
function hashPassword($password, $salt_len = 4)
{
    if (!$password) {
        $salt = '';
        $hashpwd = '';
    } else {
        $salt = getRandomChar($salt_len);
        $hashpwd = getHashPassword($password, $salt);
    }
    return array(
        'password' => $hashpwd,
        'salt' => $salt
    );
}

/**
 * 对密码进行HASH，加SALT
 * @param string $password 原密码
 * @param string $salt 盐
 * @return string 加密密码
 */
function getHashPassword($password, $salt)
{
    return md5($salt.md5($password.$salt));
}

function validateMenu($roleID,$menuID){
    if($roleID>0 && $menuID>0){
        if($roleID==1){
            return true;
        }
        static $roleModel = null;
        if($roleModel===null){            
            $roleModel = app\admin\model\Role::get($roleID);
        }
        return in_array($menuID, explode(',',$roleModel->menu_set));
    }
    return false;
}