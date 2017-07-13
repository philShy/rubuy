<?php
class CPage
{
    public static function newsPage($page,$totalPage,$where,$url)
    {
        $where =base64_encode($where);
        $prevPage=($page>=1)?$page-1:1;
        $nextPage=($page>=$totalPage)?$totalPage:$page+1;
        $prev = ($page == 1) ? "<b>上页</b>" : "<b><a href='{$url}?page={$prevPage}&where={$where}'>上页</a></b>";
        $next = ($page == $totalPage) ? "<b>下页</b>" : "<b><a href='{$url}?page={$nextPage}&where={$where}'>下页</a></b>";
        $str = "共{$totalPage}页";
        $p='';
        for($i = 1; $i <= $totalPage; $i ++) {
            //当前页无连接
            if ($page == $i) {
                $p .= "<b  style='display:inline-block;width:40px; height: 25px;font-size: 14px;color: #fff;background: #2a8bcc;margin-left: 3px;line-height: 25px;'>{$i}</b>";
            } else {
                if ($page-$i>=4&&$i!=1) {//只显示前3个页码
                    $p .= "<b>...</b>";
                    $i = $page-4;//将页码跳到没有省略号的页码
                }else {
                    if ($i>=$page+3&&$i!=$totalPage) {//只显示当前页的后两个页码
                        $p .= "<b>...</b>";
                        $i = $totalPage;//将页码跳到最后一页
                    }
                    $p .= "<b><a href='{$url}?page={$i}&where={$where}'>{$i}</a></b>";
                }
            }
        }
        $pageStr=$prev.$p.$next;
        return $pageStr;
    }

    public static function page($page,$totalPage,$url)
    {
        $prevPage=($page>=1)?$page-1:1;
        $nextPage=($page>=$totalPage)?$totalPage:$page+1;
        $prev = ($page == 1) ? "<b>上页</b>" : "<b><a href='{$url}?page={$prevPage}'>上页</a></b>";
        $next = ($page == $totalPage) ? "<b>下页</b>" : "<b><a href='{$url}?page={$nextPage}'>下页</a></b>";
        $str = "共{$totalPage}页";
        $p='';
        for($i = 1; $i <= $totalPage; $i ++) {
            //当前页无连接
            if ($page == $i) {
                $p .= "<b  style='display:inline-block;width:40px; height: 25px;font-size: 14px;color: #fff;background: #2a8bcc;margin-left: 3px;line-height: 25px;'>{$i}</b>";
            } else {
                if ($page-$i>=4&&$i!=1) {//只显示前3个页码
                    $p .= "<b>...</b>";
                    $i = $page-4;//将页码跳到没有省略号的页码
                }else {
                    if ($i>=$page+3&&$i!=$totalPage) {//只显示当前页的后两个页码
                        $p .= "<b>...</b>";
                        $i = $totalPage;//将页码跳到最后一页
                    }
                    $p .= "<b><a href='{$url}?page={$i}'>{$i}</a></b>";
                }
            }
        }
        $pageStr=$prev.$p.$next;
        return $pageStr;
    }
}