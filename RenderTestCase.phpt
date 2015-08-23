<?php

namespace Mesour\Button\Tests;

use Tester\Assert;
use \Mesour\UI\Button;

require_once __DIR__ . '/../bootstrap.php';

class RenderTestCase extends BaseTestCase
{

    private $withoutSettings = '<a class="btn btn-default" role="button"></a>';
    private $setText = '<a class="btn btn-default" role="button">To mesour.com &gt;&gt;</a>';
    private $setAttributeAndLink = '<a href="http://mesour.com" target="_blank" class="btn btn-default" role="button"></a>';
    private $sizeAndOwnClass = '<a href="http://mesour.com" target="_blank" class="btn btn-warning btn-lg my-own-appended-class" role="button">To mesour.com &gt;&gt;</a>';
    private $disabled = '<a target="_blank" class="btn btn-warning btn-lg my-own-appended-class disabled" role="button">To mesour.com &gt;&gt;</a>';
    private $withoutClasses = '<a href="http://mesour.com" target="_blank" role="button">To mesour.com &gt;&gt;</a>';
    private $leftAndRightButtons = '<a href="http://mesour.com" target="_blank" class="btn btn-danger btn-lg" role="button"><span class="glyphicon glyphicon-tree-deciduous"></span>&nbsp;MESOUR.COM&nbsp;<span class="glyphicon glyphicon-menu-right"></span></a>';
    private $onlyIcon = '<a href="http://mesour.com" target="_blank" class="btn btn-primary btn-lg" role="button"><span class="glyphicon glyphicon-pencil"></span></a>';
    private $usingDataParser = '<a id="user-root" href="/edit-user/?id=25" target="_blank" class="btn btn-primary btn-lg" role="button"><span class="glyphicon glyphicon-pencil"></span></a>';

    public function testWithoutSettings()
    {
        $button = new Button;

        $html = $this->getStringFromOb($button);
        Assert::same($html, $this->withoutSettings);
    }

    public function testSetText()
    {
        $button = new Button;
        $button->setText('To mesour.com >>');

        $html = $this->getStringFromOb($button);
        Assert::same($html, $this->setText);
    }

    public function testSetAttributeAndLink()
    {
        $button = new Button;
        $button->setAttribute('href', $button->link('http://mesour.com'))
            ->setAttribute('target', '_blank');

        $html = $this->getStringFromOb($button);
        Assert::same($html, $this->setAttributeAndLink);
    }

    public function testSetSizeAndOwnClass()
    {
        $button = new Button;

        $button->setText('To mesour.com >>')
            ->setType('warning')
            ->setSize('btn-lg')
            ->setClassName('my-own-appended-class')
            ->setAttribute('href', $button->link('http://mesour.com'))
            ->setAttribute('target', '_blank');

        $html = $this->getStringFromOb($button);
        Assert::same($html, $this->sizeAndOwnClass);
    }

    public function testSetDisabled()
    {
        $button = new Button;

        $button->setText('To mesour.com >>')
            ->setType('warning')
            ->setSize('btn-lg')
            ->setClassName('my-own-appended-class')
            ->setAttribute('href', $button->link('http://mesour.com'))
            ->setAttribute('target', '_blank');

        $button->setDisabled();

        $html = $this->getStringFromOb($button);
        Assert::same($html, $this->disabled);
    }

    public function testWithoutClasses()
    {
        $button = new Button;

        $button->setText('To mesour.com >>')
            ->setAttribute('class', FALSE)// set own class name or FALSE for unset
            ->setAttribute('href', $button->link('http://mesour.com'))
            ->setAttribute('target', '_blank');

        $html = $this->getStringFromOb($button);
        Assert::same($html, $this->withoutClasses);
    }

    public function testLeftAndRightButtons()
    {
        $button = new Button;

        $button->setIcon('tree-deciduous');

        $button->setRightIcon('menu-right');

        $button->setText('MESOUR.COM')
            ->setType('danger')
            ->setSize('btn-lg')
            ->setAttribute('href', $button->link('http://mesour.com'))
            ->setAttribute('target', '_blank');

        $html = $this->getStringFromOb($button);
        Assert::same($html, $this->leftAndRightButtons);
    }

    public function testOnlyIcon()
    {
        $button = new Button;

        $button->setIcon('pencil');

        $button->setType('primary')
            ->setSize('btn-lg')
            ->setAttribute('href', $button->link('http://mesour.com'))
            ->setAttribute('target', '_blank');

        $html = $this->getStringFromOb($button);
        Assert::same($html, $this->onlyIcon);
    }

    public function testUsingDataParser()
    {
        $button = new Button;

        $button->setIcon('pencil');

        $button->setType('primary')
            ->setSize('btn-lg')
            ->setAttribute('id', 'user-{username}')
            ->setAttribute('href', $button->link('/edit-user/', array('id' => '{id}')))
            ->setAttribute('target', '_blank');

        $html = $this->getStringFromOb($button, array(
            'id' => 25,
            'username' => 'root',
            'name' => 'Root'
        ));
        Assert::same($html, $this->usingDataParser);
    }

}

$test = new RenderTestCase();
$test->run();