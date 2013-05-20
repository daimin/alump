<?php
class ALump_Cookie
{
    /**
     * 获取指定的COOKIE值
     *
     * @access public
     * @param string $key 指定的参数
     * @param string $default 默认的参数
     * @return mixed
     */
    public static function get($key, $default = NULL)
    {
        $val = isset($_COOKIE[$key]) ? $_COOKIE[$key] : $default;
        if(empty($val)){
        	return false;
        }

        return ALump_Common::decrypt($val);
    }

    /**
     * 设置指定的COOKIE值
     *
     * @access public
     * @param string $key 指定的参数
     * @param mixed $value 设置的值
     * @param integer $expire 过期时间,默认为0,表示随会话时间结束
     * @param string $url 路径(可以是域名,也可以是地址)
     * @return void
     */
    public static function set($key, $value, $expire = 0, $url = NULL)
    {
        $path = '/';
        if (!empty($url)) {
            $parsed = parse_url($url);

            /** 在路径后面强制加上斜杠 */
            $path = empty($parsed['path']) ? '/' : Alump_Common::url(NULL, $parsed['path']);
        }

        /** 对数组型COOKIE的写入支持 */
        if (is_array($value)) {
            foreach ($value as $name => $val) {
            	$val = ALump_Common::encrypt($val);
                setcookie("{$key}[{$name}]", $val, $expire, $path);
            }
        } else {
            setcookie($key, ALump_Common::encrypt($value), $expire, $path);
        }
    }

    /**
     * 删除指定的COOKIE值
     *
     * @access public
     * @param string $key 指定的参数
     * @return void
     */
    public static function delete($key, $url = NULL)
    {
        if (!isset($_COOKIE[$key])) {
            return;
        }

        $path = '/';
        if (!empty($url)) {
            $parsed = parse_url($url);

            /** 在路径后面强制加上斜杠 */
            $path = empty($parsed['path']) ? '/' : Alump_Common::url(NULL, $parsed['path']);
        }

        /** 对数组型COOKIE的删除支持 */
        if (is_array($_COOKIE[$key])) {
            foreach ($_COOKIE[$key] as $name => $val) {
                setcookie("{$key}[{$name}]", '', time() - 604800, $path);
            }
        } else {
            setcookie($key, '', time() - 604800, $path);
        }
    }
}
