<?php
defined('ZOTOP') or die('No direct access allowed.');

/**
 * 系统控制器操作类
 *
 * @package     zotop
 * @author      zotop team
 * @copyright   (c)2009 zotop team
 * @license     http://zotop.com/license.html
 */
class rewrite
{
    /**
     * 检查服务器是否支持rewrite
     *
     * @return void
     */
    public static function check()
    {
        $check = false;        
        $model    = c('system.url_model');

        if ( $model != 'rewrite' && rewrite::htaccess() )
        {
            c('system.url_model','rewrite');

            $http = zotop::instance('http');

            // 设置cookie
            $http->setCookie($_COOKIE);

            // 访问回调页面
            if ( $http->get(U('system/check/rewritecallback')) )
            {        
                $check = ( $http->data == 'ok') ? true : false;
            }

            c('system.url_model',$model);
        }

        return $check;
    }

    /**
     * rewrite::htaccess() 写入.htaccess 文件
     *
     * @return void
     */
    public static function htaccess()
    {
        if ( file_exists(ZOTOP_PATH . DS .'.htaccess') ) return true;        

        $basepath = request::basepath();

        $fp = @fopen(ZOTOP_PATH . DS .'.htaccess', 'w');

        $rw_rule = '#zotopcms rewrite rule

<IfModule mod_rewrite.c>
RewriteEngine On
RewriteBase ' . $basepath . '
RewriteCond %{REQUEST_FILENAME} !-d
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^(.*)$ index.php/$1 [QSA,PT,L]
</IfModule>
';
        if (!@fwrite($fp, $rw_rule))
        {
            return false;
        }

        fclose($fp);

        return true;
    }
}
?>