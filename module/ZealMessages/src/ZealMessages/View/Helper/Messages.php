<?php

namespace ZealMessages\View\Helper;

use Zend\View\Helper\AbstractHelper;
use ZealMessages\Controller\Plugin\Messages as MessagesPlugin;

class Messages extends AbstractHelper
{
    protected $messages;

    public function __construct(array $messages)
    {
        $this->messages = $messages;
    }

    public function __invoke()
    {
        if (count($this->messages) == 0) {
            return '';
        }

        $html = '';
        foreach ($this->messages as $key => $messagesArray) {
            //<div class="alert alert-success">...</div>
            $html .= '<div class="alert alert-dismissable fade in alert-'.$key.'">'
                    . '<button type="button" class="close" data-dismiss="alert" '
                    . 'aria-hidden="true">&times;</button>'.implode('', $messagesArray).'</div>';
        }

        return '<div id="messages">'.$html.'</div>';
    }
}
