<?php

namespace Mesour\Button\Tests;

use Tester\Assert;
use \Mesour\UI\Button;

require_once __DIR__ . '/../bootstrap.php';

class DefaultsTestCase extends BaseTestCase
{

    private $html = '<b href="http://example.com?id=5" class="btnx btnx-defaultx c d" role="buttonx"><i class="glyphiconsa glyphicon-pencila"></i>&nbsp;Text&nbsp;<i class="glyphiconb glyphiconx-pencilb"></i></b>';

    public function testPrimaryKey()
    {
        Button::$defaults = array(
            Button::WRAPPER => array(
                'el' => 'b',
                'attributes' => array(
                    'class' => 'btnx btnx-{_BTN_type_} {_BTN_size_} {_BTN_own_class_}',
                    'role' => 'buttonx',
                )
            ),
            Button::ICON => array(
                'el' => 'i',
                'attributes' => array(
                    'class' => 'glyphiconsa glyphicon-{_ICON_name_}'
                )
            ),
            Button::RIGHT_ICON => array(
                'el' => 'i',
                'attributes' => array(
                    'class' => 'glyphiconb glyphiconx-{_RICON_name_}'
                )
            ),
            Button::DEFAULTS => array(
                '_BTN_type_' => 'defaultx',
                '_BTN_own_class_' => 'd',
                '_BTN_size_' => 'c',
                '_ICON_name_' => 'pencila',
                '_RICON_name_' => 'pencilb',
            )
        );

        $button = new Button;

        $button->setIcon();
        $button->setRightIcon();
        $button->setText('Text');
        $button->setAttribute('href', $button->link('http://example.com', ['id' => 5]));

        $dom = $this->getDomQueryFromOb($button);

        Assert::true($dom->has('b'));
        Assert::true($dom->has('b.c'));
        Assert::true($dom->has('b.d'));
        Assert::true($dom->has('b.btnx-defaultx'));
        Assert::true($dom->has('b.btnx'));
        Assert::true($dom->has('b.[href="http://example.com?id=5"]'));
        Assert::true($dom->has('b[role=buttonx]'));
        Assert::true($dom->has('b i.glyphiconsa.glyphicon-pencila'));
        Assert::true($dom->has('b i.glyphiconb.glyphiconx-pencilb'));

        $html = $this->getStringFromOb($button);

        Assert::same($html, $this->html);
    }



}

$test = new DefaultsTestCase();
$test->run();