<?php

namespace common\extensions;

use yii\helpers\Html;
use yii\widgets\LinkPager;

class GoLinkPager extends LinkPager
{
// 是否包含跳转功能跳转 默认false
    public $go = false;
    public $firstPageLabel = '<img style="vertical-align: middle;width: 12px;" src="/images/first.png" />';
    public $lastPageLabel = '<img style="vertical-align: middle;width: 12px;" src="/images/last.png" />';
    public $prevPageLabel = '<img style="vertical-align: middle;width: 12px;" src="/images/prev.png" />';
    public $nextPageLabel = '<img style="vertical-align: middle;width: 12px;" src="/images/next.png" />';

    
    /**
     * @name 渲染分页页面
     * @author fjl
     * @return string
     */
    protected function renderPageButtons()
    {
        $pageCount = $this->pagination->getPageCount();
        if ($pageCount < 2 && $this->hideOnSinglePage) {
            return '';
        }
        $buttons = [];
        $currentPage = $this->pagination->getPage();
        // first page
        $firstPageLabel = $this->firstPageLabel === true ? '1' : $this->firstPageLabel;
        if ($firstPageLabel !== false) {
            $buttons[] = $this->renderPageButton($firstPageLabel, 0, $this->firstPageCssClass, $currentPage <= 0, false);
        }
        // prev page
        if ($this->prevPageLabel !== false) {
            if (($page = $currentPage - 1) < 0) {
                $page = 0;
            }
            $buttons[] = $this->renderPageButton($this->prevPageLabel, $page, $this->prevPageCssClass, $currentPage <= 0, false);
        }
        // internal pages
        list($beginPage, $endPage) = $this->getPageRange();
        for ($i = $beginPage; $i <= $endPage; ++$i) {
            $buttons[] = $this->renderPageButton($i + 1, $i, null, false, $i == $currentPage);
        }
        // next page
        if ($this->nextPageLabel !== false) {
            if (($page = $currentPage + 1) >= $pageCount - 1) {
                $page = $pageCount - 1;
            }
            $buttons[] = $this->renderPageButton($this->nextPageLabel, $page, $this->nextPageCssClass, $currentPage >= $pageCount - 1, false);
        }
        // last page
        $lastPageLabel = $this->lastPageLabel === true ? $pageCount : $this->lastPageLabel;
        if ($lastPageLabel !== false) {
            $buttons[] = $this->renderPageButton($lastPageLabel, $pageCount - 1, $this->lastPageCssClass, $currentPage >= $pageCount - 1, false);
        }
        // go
        if ($this->go) {
            $goPage = $currentPage + 2;
            $goHtml = <<<goHtml
    <div class="jumpUrl">
     <span class="text">共 {$pageCount} 页</span>
     <span class="text"> {$this->pagination->totalCount} 条信息</span>
     <span class="text">到第</span>
     <input class="input" type="number" id="go-page-number" value="{$goPage}" min="1" max="{$pageCount}" aria-label="页码输入框">
     <span class="text">页</span>
     <span class="btn go-page" id="go-page" role="button" tabindex="0">确定</span>
    </div>
goHtml;
//            $buttons[] = $goHtml;
            $pageLink = $this->pagination->createUrl(false);
            $goJs = <<<goJs
            <script type="text/javascript">
            window.onload=function(){
                $(".go-page").on("click", function () {
                 var _this = $(this),
                  _pageInput = _this.siblings("input"),
                  goPage = _pageInput.val(),
                  pageLink = "{$pageLink}";
                  pageLink = pageLink.replace("page=1", "page="+goPage);
                 if (goPage >= 1 && goPage <= {$pageCount}) {
                  window.location.href=pageLink;
                 } else {
                  _pageInput.focus();
                 }
                });
            }
        </script>
goJs;
//            $this->view->registerJs($goJs);
        } else {
            $goHtml = $goJs = '';
        }
        $html = Html::tag('ul', implode("\n", $buttons)) . $goHtml;
        return '<div class="pagination">' . $html . '</div>' . $goJs;
//        return Html::tag('ul', implode("\n", $buttons,$this->options), $this->options);
    }
}