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
 *
 * @method null onRender(Button $button)
 */
class Button extends Mesour\Components\Control\AttributesControl
{

    const WRAPPER = 'wrapper',
        DEFAULTS = 'defaults';

    private $text = '';

    private $disabled = FALSE;

    private $className = NULL;

    public $onRender = [];

    protected $defaults = [
        self::WRAPPER => [
            'el' => 'a',
            'attributes' => [
                'class' => 'btn btn-{_BTN_type_} {_BTN_size_}',
                'role' => 'button',
            ]
        ],
        self::DEFAULTS => [
            '_BTN_type_' => 'default',
            '_BTN_size_' => '',
            '_ICON_name_' => 'cog',
            '_ICON_prefix_' => 'glyphicon glyphicon-',
            '_RICON_name_' => 'cog',
            '_RICON_prefix_' => 'glyphicon glyphicon-',
        ]
    ];

    public function __construct($name = NULL, Mesour\Components\ComponentModel\IContainer $parent = NULL)
    {
        parent::__construct($name, $parent);

        $this->setHtmlElement(
            Mesour\Components\Utils\Html::el($this->getOption(self::WRAPPER, 'el'))
        );
    }

    /**
     * @return Mesour\Components\Utils\Html
     */
    public function getControlPrototype()
    {
        return $this->getHtmlElement();
    }

    public function setConfirm($message)
    {
        $this->setAttribute('onclick', 'return confirm(\'' . str_replace("'", "\\'", $this->getTranslator()->translate($message)) . '\');');
        return $this;
    }

    /**
     * @param $title
     * @param string $placement left|top|bottom|right
     * @return $this
     */
    public function setTooltip($title, $placement = 'top')
    {
        $this->setAttribute('title', $title);
        $this->setAttribute('data-mesour-toggle', 'tooltip');
        $this->setAttribute('data-placement', $placement);
        return $this;
    }

    public function setText($text)
    {
        return $this->setHtml(htmlspecialchars($this->getTranslator()->translate($text)));
    }

    public function setHtml($html)
    {
        $this->text = $html;
        return $this;
    }

    public function setSize($size_class)
    {
        $this->setOption(self::DEFAULTS, $size_class, '_BTN_size_');
        return $this;
    }

    public function setType($type)
    {
        $this->setOption(self::DEFAULTS, $type, '_BTN_type_');
        return $this;
    }

    public function setDisabled($disabled = TRUE)
    {
        $this->disabled = (bool)$disabled;
        return $this;
    }

    public function setClassName($className)
    {
        $this->className = $className;
        return $this;
    }

    public function isDisabled()
    {
        return $this->disabled;
    }

    public function setIcon($type = NULL, $classPrefix = NULL)
    {
        if ($this->hasLeftIcon()) {
            $icon = $this->getLeftIcon()
                ->setType(!$type ? $this->getOption(self::DEFAULTS, '_ICON_name_') : $type)
                ->setPrefix(!$classPrefix ? $this->getOption(self::DEFAULTS, '_ICON_prefix_') : $classPrefix);
            return $icon;
        }
        $this->createIcon(
            'leftIcon',
            !$type ? $this->getOption(self::DEFAULTS, '_ICON_name_') : $type,
            !$classPrefix ? $this->getOption(self::DEFAULTS, '_ICON_prefix_') : $classPrefix
        );
        return $this;
    }

    public function setRightIcon($type = NULL, $classPrefix = NULL)
    {
        if ($this->hasRightIcon()) {
            $icon = $this->getRightIcon()
                ->setType(!$type ? $this->getOption(self::DEFAULTS, '_RICON_name_') : $type)
                ->setPrefix(!$classPrefix ? $this->getOption(self::DEFAULTS, '_RICON_prefix_') : $classPrefix);
            return $icon;
        }
        $this->createIcon(
            'rightIcon',
            !$type ? $this->getOption(self::DEFAULTS, '_RICON_name_') : $type,
            !$classPrefix ? $this->getOption(self::DEFAULTS, '_RICON_prefix_') : $classPrefix
        );
        return $this;
    }

    public function setPermission($role, $resource = NULL, $privilege = NULL)
    {
        $this->setPermissionCheck($role, $resource, $privilege);
        return $this;
    }

    public function create()
    {
        parent::create();

        $wrapper = $this->getControlPrototype();
        $oldWrapper = clone $wrapper;
        foreach ($oldWrapper->attrs as $key => $attr) {
            if (is_object($attr)) {
                $oldWrapper->attrs[$key] = clone $attr;
            }
        }

        if ($this->hasLeftIcon()) {
            $oldLeftIcon = clone $this->getLeftIcon();
        }
        if ($this->hasRightIcon()) {
            $oldRightIcon = clone $this->getRightIcon();
        }

        $this->onRender($this);

        $optionData = $this->getOption(self::DEFAULTS);

        if (!$this->isAllowed()) {
            $this->setDisabled(TRUE);
        }

        foreach ($this->getOption(self::WRAPPER, 'attributes') as $key => $value) {
            if ($value instanceof Mesour\Components\Link\IUrl) {
                continue;
            }
            if (!$this->hasAttribute($key) || $this->getAttribute($key, FALSE) !== FALSE) {
                $value = trim(Mesour\Components\Utils\Helpers::parseValue($value, $optionData));
                if ($this->hasAttribute($key)) {
                    $value .= ' ' . $this->getAttribute($key);
                }
                $this->setAttribute($key, $value);
            }
        }

        if ($this->className) {
            $this->setAttribute('class', $this->className);
        }

        $this->getAttributes($this->isDisabled());

        if ($this->hasLeftIcon()) {
            $leftIcon = $this->getLeftIcon();
            $leftIcon->setOption('data', $this->getOption('data'));
            $wrapper->add($leftIcon->create());
            if (strlen($this->text) > 0) {
                $wrapper->add('&nbsp;');
            }
            if (isset($oldLeftIcon)) {
                unset($this['leftIcon']);
                $this['leftIcon'] = $oldLeftIcon;
            }
        }

        $wrapper->add($this->text);

        if ($this->hasRightIcon()) {
            $rightIcon = $this->getRightIcon();
            $rightIcon->setOption('data', $this->getOption('data'));
            if (strlen($this->text) > 0) {
                $wrapper->add('&nbsp;');
            }
            $wrapper->add($rightIcon->create());
            if (isset($oldRightIcon)) {
                unset($this['rightIcon']);
                $this['rightIcon'] = $oldRightIcon;
            }
        }
        $this->setHtmlElement($oldWrapper);
        return $wrapper;
    }

    /**
     * @return Icon
     * @throws Mesour\InvalidStateException
     */
    public function getLeftIcon()
    {
        if (!$this->hasLeftIcon()) {
            throw new Mesour\InvalidStateException('Left icon is not created.');
        }
        return $this['leftIcon'];
    }

    public function hasLeftIcon()
    {
        return isset($this['leftIcon']);
    }

    /**
     * @return Icon
     * @throws Mesour\InvalidStateException
     */
    public function getRightIcon()
    {
        if (!$this->hasRightIcon()) {
            throw new Mesour\InvalidStateException('Right icon is not created.');
        }
        return $this['rightIcon'];
    }

    public function hasRightIcon()
    {
        return isset($this['rightIcon']);
    }

    protected function createIcon($name, $type, $prefix)
    {
        $icon = new Icon();

        $icon->setType($type);
        $icon->setPrefix($prefix);

        return $this[$name] = $icon;
    }

}
