<?php

use App\Library\Code;

function del0($number)
{
    $number = trim(strval($number));
    if (preg_match('#^-?\d+?\.0+$#', $number)) {
        return preg_replace('#^(-?\d+?)\.0+$#', '$1', $number);
    }
    if (preg_match('#^-?\d+?\.[0-9]+?0+$#', $number)) {
        return preg_replace('#^(-?\d+\.[0-9]+?)0+$#', '$1', $number);
    }

    return $number;
}

/**
 * 隐藏身份证号
 * @param $cardNum
 * @return string
 */
function hideCardNum($cardNum)
{
    $suf = '';
    for ($i = 0; $i < strlen($cardNum) - 8; $i++) {
        $suf .= '*';
    }
    $cardNum_asterisk = substr($cardNum, 0, 4) . $suf . substr($cardNum, -4, 4);
    return $cardNum_asterisk;
}

function hideStar($str)
{
    if (strpos($str, '@')) {
        $email_array = explode("@", $str);
        $prefix = (strlen($email_array[0]) < 4) ? "" : substr($str, 0, 3); //邮箱前缀
        $count = 0;
        $str = preg_replace('/([\d\w+_-]{0,100})@/', '***@', $str, -1, $count);
        $rs = $prefix . $str;
    } else {
        $pattern = '/(1[3458]{1}[0-9])[0-9]{4}([0-9]{4})/i';
        if (preg_match($pattern, $str)) {
            $rs = preg_replace($pattern, '$1****$2', $str); // substr_replace($name,'****',3,4);
        } else {
            $rs = substr($str, 0, 3) . "***" . substr($str, -1);
        }
    }
    return $rs;
}

function success($data = [], $msg = 'success')
{
    if (is_string($data)) {
        $msg = $data;
        $data = [];
    }
    $res['code'] = Code::SUCCESS;
    $res['message'] = $msg;
    $res['data'] = $data;

    return $res;
}

function error($msg = 'error')
{
    $res['code'] = Code::ERROR;
    $res['message'] = $msg;

    return $res;
}
