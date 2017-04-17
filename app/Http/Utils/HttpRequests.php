<?php
/**
 * Created by PhpStorm.
 * User: porfirio
 * Date: 4/17/17
 * Time: 2:03 PM
 */

namespace App\Http\Utils;


use HttpException;
use HttpRequest;

class HttpRequests
{
    public static function sendRequestGET()
    {
        $r = new HttpRequest('http://example.com/feed.rss', HttpRequest::METH_GET);
        $r->setOptions(array('lastmodified' => filemtime('local.rss')));
        $r->addQueryData(array('category' => 3));
        try {
            $r->send();
            if ($r->getResponseCode() == 200) {
                file_put_contents('local.rss', $r->getResponseBody());
            }
        } catch (HttpException $ex) {
            echo $ex;
        }
    }

    public static function sendRequestPOST() {
        $r = new HttpRequest('http://example.com/form.php', HttpRequest::METH_POST);
        $r->setOptions(array('cookies' => array('lang' => 'de')));
        $r->addPostFields(array('user' => 'mike', 'pass' => 's3c|r3t'));
        $r->addPostFile('image', 'profile.jpg', 'image/jpeg');
        try {
            echo $r->send()->getBody();
        } catch (HttpException $ex) {
            echo $ex;
        }
    }
}