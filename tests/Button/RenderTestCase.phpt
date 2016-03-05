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
	private $sizeAndOwnClass = '<a class="btn btn-warning btn-lg my-own-appended-class" href="http://mesour.com" target="_blank" role="button">To mesour.com &gt;&gt;</a>';
	private $disabled = '<a class="btn btn-warning btn-lg my-own-appended-class disabled" target="_blank" role="button">To mesour.com &gt;&gt;</a>';
	private $withoutClasses = '<a href="http://mesour.com" target="_blank" role="button">To mesour.com &gt;&gt;</a>';
	private $leftAndRightButtons = '<a href="http://mesour.com" target="_blank" class="btn btn-danger btn-lg" role="button"><span class="fa fa-tree-deciduous"></span>&nbsp;MESOUR.COM&nbsp;<span class="fa fa-menu-right"></span></a>';
	private $onlyIcon = '<a href="http://mesour.com" target="_blank" class="btn btn-primary btn-lg" role="button"><span class="fa fa-pencil"></span></a>';
	private $usingDataParser = '<a id="user-root" href="/edit-user/?id=25" target="_blank" class="btn btn-primary btn-lg" role="button"><span class="fa fa-pencil"></span></a>';

	public function testWithoutSettings()
	{
		$button = new Button;

		$html = $this->getStringFromOb($button);
		Assert::same($this->withoutSettings, $html);
	}

	public function testSetText()
	{
		$button = new Button;
		$button->setText('To mesour.com >>');

		$html = $this->getStringFromOb($button);
		Assert::same($this->setText, $html);
	}

	public function testSetAttributeAndLink()
	{
		$button = new Button;
		$button->setAttribute('href', $button->link('http://mesour.com'))
			->setAttribute('target', '_blank');

		$html = $this->getStringFromOb($button);
		Assert::same($this->setAttributeAndLink, $html);
	}

	public function testSetSizeAndOwnClass()
	{
		$button = new Button;

		$button->setText('To mesour.com >>')
			->setType('warning')
			->setSize('btn-lg')
			->setAttribute('class', 'my-own-appended-class')
			->setAttribute('href', $button->link('http://mesour.com'))
			->setAttribute('target', '_blank');

		$html = $this->getStringFromOb($button);
		Assert::same($this->sizeAndOwnClass, $html);
	}

	public function testSetDisabled()
	{
		$button = new Button;

		$button->setText('To mesour.com >>')
			->setType('warning')
			->setSize('btn-lg')
			->setAttribute('class', 'my-own-appended-class')
			->setAttribute('href', $button->link('http://mesour.com'))
			->setAttribute('target', '_blank');

		$button->setDisabled();

		$html = $this->getStringFromOb($button);
		Assert::same($this->disabled, $html);
	}

	public function testWithoutClasses()
	{
		$button = new Button;

		$button->setText('To mesour.com >>')
			->setAttribute('class', false)// set own class name or FALSE for unset
			->setAttribute('href', $button->link('http://mesour.com'))
			->setAttribute('target', '_blank');

		$html = $this->getStringFromOb($button);
		Assert::same($this->withoutClasses, $html);
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
		Assert::same($this->leftAndRightButtons, $html);
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
		Assert::same($this->onlyIcon, $html);
	}

	public function testUsingDataParser()
	{
		$button = new Button;

		$button->setIcon('pencil');

		$button->setType('primary')
			->setSize('btn-lg')
			->setAttribute('id', 'user-{username}')
			->setAttribute('href', $button->link('/edit-user/', ['id' => '{id}']))
			->setAttribute('target', '_blank');

		$html = $this->getStringFromOb($button, [
			'id' => 25,
			'username' => 'root',
			'name' => 'Root',
		]);
		Assert::same($this->usingDataParser, $html);
	}

}

$test = new RenderTestCase();
$test->run();