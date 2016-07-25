<?php

namespace SimpleEngine\Controller;

class RequestController
{
    static function _isAjax()
    {
        return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) ? strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' : false;
    }

    static function _get($key,$type='asis', $check_exists = false)
    {
        return static::_input('get',$key,$type, $check_exists);
    }

    static function _post($key,$type='asis', $check_exists = false)
    {
        return static::_input('post',$key,$type, $check_exists);
    }

    static function _request($key,$type='asis')
    {
        return static::_input('request',$key,$type);
    }

    static function _cookie($key,$type='asis')
    {
        return static::_input('cookie',$key,$type);
    }

    static function _session($key,$type='asis')
    {
        return static::_input('session',$key,$type);
    }

    static function _getpost($key,$type='asis')
    {
        if ($get = static::_input('get',$key,$type))
            return $get;
        else
            return static::_input('post',$key,$type);
    }

    static function _postget($key,$type='asis')
    {
        if ($post = static::_input('post',$key,$type))
            return $post;
        else
            return static::_input('get',$key,$type);
    }

    static function _input($glob,$key,$type='asis', $check_exists = false)
    {
        $param = array('get'=>$_GET, 'post'=>$_POST, 'request'=>$_REQUEST, 'cookie'=>$_COOKIE, 'session' => $_SESSION);

        $var = (isset($param[$glob][$key])) ? $param[$glob][$key] : null;

        if ($check_exists && is_null($var))
            return $var;

        if (!is_array($var))
            $var = trim($var);

        if ($type=="asis")	return $var;
        elseif ($type=="i")		return (int)$var;
        elseif ($type=="f")		return (float)$var;
        elseif ($type=="s") 	return (string)htmlspecialchars(strip_tags($var));
        elseif ($type=="b") 	return (bool)$var;
        elseif ($type=="sql")	return mysql_real_escape_string($var);
        elseif ($type=="numeric")	return (is_numeric($var)) ? $var : 0;
        elseif ($type=="date")	return (preg_match("/[^0-9.\-]/",$var)) ? null : $var;
        elseif ($type=="datetime")	return (preg_match("/[^0-9.\-:\s]/",$var)) ? null : $var;
        elseif ($type=="email")	return (filter_var($var, FILTER_VALIDATE_EMAIL) ? $var : null);
        elseif ($type=="a")
        {
            return (is_array($var)) ? $var : array();
        }
        elseif ($type=="ai")
        {
            if (is_array($var))
            {
                foreach($var as $k=>$v)
                {
                    $var[$k] = (int)$v;
                }
                return $var;
            }
            return array();
        }
        elseif ($type=="anumeric")
        {
            if (is_array($var))
            {
                foreach($var as $k=>$v)
                {
                    $var[$k] = (is_numeric($v)) ? $v : null;
                }
                return $var;
            }
            return array();
        }
        else return null;

    }

    static function _checkGet()
    {
        $pattern = "/^([0-9a-zA-Z_\.]){0,}$/us";
        $err = array();

        foreach($_GET as $k=>$v)
        {
            if (is_array($v))
            {
                unset($_GET[$k]);
                $err[] = "--".$k."-- == --Array()--";
            }
            elseif (!preg_match($pattern, $v))
            {
                $err[] =  "--".$k."-- == --".$v."--";
                $_GET[$k]=0;
            }
        }

        if (count($err))
        {
            $log = $_SERVER['REMOTE_ADDR']." ".$_SERVER['REQUEST_URI'].". Некорректные GET параметры: ".implode(",",$err)." Исправлено на: ";
            foreach($_GET as $k=>$v)
            {
                $log.="&".$k."=".$v;
            }
        }
    }

    static function _validateRequest()
    {
        if (!isset($_SERVER['REQUEST_METHOD']) || $_SERVER['REQUEST_METHOD']!=='POST') return;

        if (isset($_SERVER['HTTP_REFERER']) && !empty($_SERVER['HTTP_REFERER']))
        {
            $ref = parse_url($_SERVER['HTTP_REFERER']);

            $host = "";
            $port = "";
            if (isset($ref['path'])) $host = $ref['path'];
            if (isset($ref['host'])) $host = $ref['host'];
            if (isset($ref['port'])) $port = $ref['port'];

            if ($_SERVER['HTTP_HOST']==$host) return;
            if (!empty($port) && $_SERVER['HTTP_HOST']==$host.":".$port) return;
        }

        if (isset($_SERVER['HTTP_REFERER']))
            $ref = $_SERVER['HTTP_REFERER'];
        else
            $ref='';

        exit('INVALID REQUEST');
    }

    static function _getInt($key)
    {
        return static::_input('get',$key,'i');
    }

    static function _postInt($key)
    {
        return static::_input('post',$key,'i');
    }
}