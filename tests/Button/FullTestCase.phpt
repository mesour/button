<?php

namespace Mesour\Button\Tests;

use Tester\Assert;
use \Mesour\UI\Button;

require_once __DIR__ . '/../bootstrap.php';

class FullTestCase extends BaseTestCase
{

	/** @var Button */
	private $button;

	private $firstButton = '<a data-text="Test title" class="btn btn-default btn-lg my-test-2 disabled" data-xxx="ble" role="button"><span class="fa fa-menu-hamburger"></span>&nbsp;My text&nbsp;<span class="fa fa-option-horizontal"></span></a>';
	private $secondButton = '<a onclick="return confirm(\'Test confirm\\\' text?\');" data-text="Test title" class="btn btn-default btn-lg my-test-2" href="/test/?id=25" role="button"><span class="fa fa-education"></span>&nbsp;My text&nbsp;<span class="fa fa-option-horizontal"></span></a>';
	private $thirdButton = '<a onclick="return confirm(\'Test confirm\\\' text?\');" data-text="Test title" class="test" href="/test/?id=50" role="button"><span class="fa fa-education"></span>&nbsp;My text&nbsp;<span class="fa fa-option-horizontal"></span></a>';

	public function testFullExample()
	{
		$this->button = new Button();

		$this->button->setConfirm('Test confirm\' text?');

		$this->button->setAttribute('data-text', 'Test title', false, true); // TRUE = allow translates

		$this->button->setIcon('education');

		$this->button->setRightIcon('option-horizontal');

		$this->button->setSize('btn-lg');

		$this->button->setText('My text');

		$this->button->setAttribute('class', 'my-test-2');

		$this->button->setAttribute('href', $this->button->link('/test/', ['id' => '{id}']));

		$this->button->onRender[] = function (Button $button) {
			$data = $button->getOption('data');
			if ($data['id'] <= 5) {
				$button->setDisabled();
				$button->setAttribute('data-xxx', 'ble');
				$button->setIcon('menu-hamburger');
			} else {
				$button->setDisabled(false);

			}

			if ($data['id'] > 25) {
				$button->setClassName('test');
			}
		};
	}

	public function testAssertFirst()
	{
		$html = $this->getStringFromOb($this->button, ['id' => 5]);
		Assert::same($this->firstButton, $html);
	}

	public function testAssertSecond()
	{
		$html = $this->getStringFromOb($this->button, ['id' => 25]);
		Assert::same($this->secondButton, $html);
	}

	public function testAssertThird()
	{
		$html = $this->getStringFromOb($this->button, ['id' => 50]);
		Assert::same($this->thirdButton, $html);
	}

}

$test = new FullTestCase();
$test->run();