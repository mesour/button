<?php

namespace Mesour\Button\Tests;

use Mesour\UI\Button;
use Tester\Assert;

require_once __DIR__ . '/../bootstrap.php';

class DefaultsTestCase extends BaseTestCase
{

	private $html = '<b href="http://example.com?id=5" class="btnx btnx-defaultx d c" role="buttonx"><span class="glyphiconsa glyphicon-pencila"></span>&nbsp;Text&nbsp;<span class="glyphiconb glyphiconx-pencilb"></span></b>';

	public function testPrimaryKey()
	{
		$button = new TestButton;

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
		Assert::true($dom->has('b span.glyphiconsa.glyphicon-pencila'));
		Assert::true($dom->has('b span.glyphiconb.glyphiconx-pencilb'));

		$html = $this->getStringFromOb($button);

		Assert::same($this->html, $html);
	}

}

class TestButton extends Button
{

	protected $defaults = [
		self::WRAPPER => [
			'el' => 'b',
			'attributes' => [
				'class' => 'btnx btnx-{_BTN_type_} {_BTN_size_} {_BTN_own_class_}',
				'role' => 'buttonx',
			],
		],
		self::DEFAULTS => [
			'_BTN_type_' => 'defaultx',
			'_BTN_own_class_' => 'c',
			'_BTN_size_' => 'd',
			'_ICON_name_' => 'pencila',
			'_ICON_prefix_' => 'glyphiconsa glyphicon-',
			'_RICON_name_' => 'pencilb',
			'_RICON_prefix_' => 'glyphiconb glyphiconx-',
		],
	];

}

$test = new DefaultsTestCase();
$test->run();
