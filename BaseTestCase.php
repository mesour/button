<?php

namespace Mesour\Button\Tests;

use Mesour\UI\Button;
use Tester\DomQuery;
use Tester\TestCase;

abstract class BaseTestCase extends TestCase
{

    protected function getDomQueryFromOb(Button $button, $data = array(), $xml = FALSE)
    {
        $out = $this->getStringFromOb($button, $data);
        return $xml ? DomQuery::fromXml($out) : DomQuery::fromHtml($out);
    }

    protected function getStringFromOb(Button $button, $data = array())
    {
        ob_start();
        $button->render($data);
        $out = ob_get_contents();
        ob_end_clean();
        return $out;
    }

}