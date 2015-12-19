<?php
/**
 * This file is part of the Mesour Button (http://components.mesour.com/component/button)
 *
 * Copyright (c) 2015 Matouš Němec (http://mesour.com)
 *
 * For full licence and copyright please view the file licence.md in root of this project
 */

namespace Mesour\UI;

use Mesour;

/**
 * @author Matouš Němec <matous.nemec@mesour.com>
 */
class Icon extends Mesour\Components\Control\AttributesControl
{

    const WRAPPER = 'wrapper';

    protected $defaults = [
        self::WRAPPER => [
            'el' => 'span',
            'attributes' => [
                'class' => ''
            ]
        ],
    ];

    protected $prefix = 'glyphicon glyphicon-';

    protected $type = 'cog';

    protected $inRendering = FALSE;

    public function setType($type)
    {
        if (!is_string($type) && strlen($type) <= 0) {
            throw new Mesour\InvalidArgumentException('Type must be non empty string.');
        }
        $this->type = $type;
        return $this;
    }

    public function setPrefix($prefix)
    {
        if (!is_string($prefix)) {
            throw new Mesour\InvalidArgumentException('Prefix must be string.');
        }
        $this->prefix = $prefix;
        return $this;
    }

    /**
     * @return Mesour\Components\Utils\Html
     */
    public function getControlPrototype()
    {
        return $this->getHtmlElement() ? $this->getHtmlElement() : $this->setHtmlElement(
            Mesour\Components\Utils\Html::el($this->getOption(self::WRAPPER, 'el'))
        );
    }

    /**
     * @param $key
     * @param $value
     * @param bool|FALSE $append
     * @param bool|FALSE $translated
     * @return $this
     */
    public function setAttribute($key, $value, $append = FALSE, $translated = FALSE)
    {
        if ($key === 'class' && !$this->inRendering) {
            throw new Mesour\NotSupportedException('Can not set class directly. Use methods setType and setPrefix for specify class name.');
        }
        parent::setAttribute($key, $value, $append, $translated);
    }

    public function create()
    {
        $wrapper = $this->getControlPrototype();
        $oldWrapper = clone $wrapper;

        $this->inRendering = TRUE;

        $this->setAttribute('class', $this->formatClassName());

        $this->getAttributes();

        $this->inRendering = FALSE;

        $this->setHtmlElement($oldWrapper);

        return $wrapper;
    }

    protected function formatClassName()
    {
        return $this->prefix . $this->type;
    }

}
