<?php

namespace Mesour\Button\Tests;

use Mesour\UI\Application;
use Mesour\UI\Button;
use Tester\DomQuery;
use Tester\TestCase;

abstract class BaseTestCase extends TestCase
{

	protected function createButton()
	{
		$application = new Application();
		$application->setRequest([]);

		return new Button('testButton', $application);
	}

	protected function getDomQueryFromOb(Button $button, $data = [], $xml = false)
	{
		$out = $this->getStringFromOb($button, $data);
		return $xml ? DomQuery::fromXml($out) : DomQuery::fromHtml($out);
	}

	protected function getStringFromOb(Button $button, $data = [])
	{
		ob_start();
		$button->setOption('data', $data);
		echo $button->render();
		$out = ob_get_contents();
		ob_end_clean();
		return $out;
	}

}
